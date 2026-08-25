document.addEventListener('DOMContentLoaded', () => {
  // --- Theme & Reader Settings Store ---
  const SETTINGS_KEY = 'quran_reader_settings';
  const BOOKMARKS_KEY = 'quran_bookmarks';
  const LAST_READ_KEY = 'quran_last_read';

  const defaultSettings = {
    theme: 'light', // 'light' | 'dark'
    arabicFontSize: 32, // in px
    showLatin: true,
    showTranslation: true,
    showTafsir: false,
    reciter: 'ar.alafasy',
  };

  const RECITER_MAP = {
    'ar.alafasy': 'Alafasy_128kbps',
    'ar.sudais': 'Abdurrahmaan_As-Sudais_192kbps',
    'ar.ghamdi': 'Ghamadi_40kbps',
    'ar.minshawi': 'Minshawy_Murattal_128kbps',
    'ar.husary': 'Husary_128kbps',
    'ar.abdulbasit': 'Abdul_Basit_Murattal_192kbps',
    'ar.shatri': 'Abu_Bakr_Ash-Shaatree_128kbps',
    'ar.maher': 'MaherAlMuaiqly128kbps',
    'ar.rifai': 'Hani_Rifai_192kbps',
    'ar.alijaber': 'Ali_Jaber_64kbps'
  };

  function getSettings() {
    try {
      const stored = localStorage.getItem(SETTINGS_KEY);
      return stored ? { ...defaultSettings, ...JSON.parse(stored) } : defaultSettings;
    } catch (e) {
      return defaultSettings;
    }
  }

  function saveSettings(newSettings) {
    try {
      localStorage.setItem(SETTINGS_KEY, JSON.stringify(newSettings));
      applySettings(newSettings);
    } catch (e) {
      console.error('Failed to save settings:', e);
    }
  }

  let cachedSettings = null;

  function applySettings(settings, forceAll = false) {
    // 1. Theme
    if (forceAll || !cachedSettings || cachedSettings.theme !== settings.theme) {
      if (settings.theme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.setAttribute('data-theme', 'light');
        document.documentElement.classList.remove('dark');
      }
    }

    // 2. Font size
    if (forceAll || !cachedSettings || cachedSettings.arabicFontSize !== settings.arabicFontSize) {
      document.documentElement.style.setProperty('--q-arabic-size', `${settings.arabicFontSize}px`);
    }

    // 3. Visibility toggles (only executed if visibility settings actually changed)
    if (forceAll || !cachedSettings || cachedSettings.showLatin !== settings.showLatin) {
      document.querySelectorAll('.verse-latin-text').forEach(el => {
        el.style.display = settings.showLatin ? 'block' : 'none';
      });
    }

    if (forceAll || !cachedSettings || cachedSettings.showTranslation !== settings.showTranslation) {
      document.querySelectorAll('.verse-translation-text').forEach(el => {
        el.style.display = settings.showTranslation ? 'block' : 'none';
      });
    }

    if (forceAll || !cachedSettings || cachedSettings.showTafsir !== settings.showTafsir) {
      document.querySelectorAll('.js-tafsir-box').forEach(el => {
        if (settings.showTafsir) {
          el.classList.remove('hidden');
        } else {
          el.classList.add('hidden');
        }
      });
    }

    cachedSettings = { ...settings };

    // 4. Sync inputs in settings modal
    const fontInput = document.getElementById('setting-font-size');
    if (fontInput) fontInput.value = settings.arabicFontSize;

    const fontValDisplay = document.getElementById('setting-font-size-val');
    if (fontValDisplay) fontValDisplay.textContent = `${settings.arabicFontSize}px`;

    const latinInput = document.getElementById('setting-toggle-latin');
    if (latinInput) latinInput.checked = settings.showLatin;

    const transInput = document.getElementById('setting-toggle-translation');
    if (transInput) transInput.checked = settings.showTranslation;

    const tafsirInput = document.getElementById('setting-toggle-tafsir');
    if (tafsirInput) tafsirInput.checked = settings.showTafsir;

    const themeSelect = document.getElementById('setting-theme-select');
    if (themeSelect) themeSelect.value = settings.theme;

    const reciterSelect = document.getElementById('setting-reciter');
    if (reciterSelect) reciterSelect.value = settings.reciter || 'ar.alafasy';
  }

  // Initial settings apply
  const currentSettings = getSettings();
  applySettings(currentSettings);

  // --- Theme Toggle Button ---
  const themeToggleBtns = document.querySelectorAll('.js-toggle-theme');
  themeToggleBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const settings = getSettings();
      settings.theme = settings.theme === 'dark' ? 'light' : 'dark';
      saveSettings(settings);
    });
  });

  // --- Settings Drawer / Modal Handler ---
  const settingsModal = document.getElementById('quran-settings-modal');
  const openSettingsBtns = document.querySelectorAll('.js-open-settings');
  const closeSettingsBtns = document.querySelectorAll('.js-close-settings');

  openSettingsBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (settingsModal) settingsModal.classList.remove('hidden');
    });
  });

  closeSettingsBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (settingsModal) settingsModal.classList.add('hidden');
    });
  });

  // --- Changelog Modal Handler (Fetches directly from GitHub Releases API) ---
  const changelogModal = document.getElementById('quran-changelog-modal');
  const openChangelogBtns = document.querySelectorAll('.js-open-changelog');
  const closeChangelogBtns = document.querySelectorAll('.js-close-changelog');

  const GH_RELEASES_URL = 'https://api.github.com/repos/adyatamamedia/laravel-quran/releases';
  const GH_RELEASES_CACHE_KEY = 'quran_github_releases_cache_v1';
  const GH_CACHE_DURATION = 15 * 60 * 1000; // 15 minutes cache

  function parseMarkdownToHtml(markdown) {
    if (!markdown) return '';
    let html = markdown
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/^### (.*$)/gim, '<h4 class="font-bold text-xs text-[var(--q-text)] mt-2.5 mb-1 uppercase tracking-wide">$1</h4>')
      .replace(/^## (.*$)/gim, '<h3 class="font-bold text-xs text-[var(--q-text)] mt-3 mb-1">$1</h3>')
      .replace(/\*\*(.*?)\*\*/gim, '<strong class="font-semibold text-[var(--q-text)]">$1</strong>')
      .replace(/\[([^\]]+)\]\((https?:\/\/[^\)]+)\)/gim, '<a href="$2" target="_blank" rel="noopener noreferrer" class="text-[#1b594a] dark:text-[#baae4f] underline hover:text-[#598456]">$1</a>')
      .replace(/^\s*-\s+(.*$)/gim, '<li class="text-[11px] text-[var(--q-text)] leading-relaxed">$1</li>');

    html = html.replace(/(<li.*<\/li>(\s*<li.*<\/li>)*)/gim, '<ul class="list-disc list-inside space-y-1 my-1.5 pl-0.5">$1</ul>');

    html = html.split('\n\n').map(p => {
      if (p.trim().startsWith('<h') || p.trim().startsWith('<ul')) return p;
      return `<p class="text-[11px] text-[var(--q-muted)] leading-relaxed my-1">${p}</p>`;
    }).join('');

    return html;
  }

  async function loadGitHubReleases() {
    const listContainer = document.getElementById('changelog-releases-list');
    if (!listContainer) return;

    // 1. Try Cached Data
    try {
      const cachedRaw = localStorage.getItem(GH_RELEASES_CACHE_KEY);
      if (cachedRaw) {
        const cached = JSON.parse(cachedRaw);
        if (Date.now() - cached.timestamp < GH_CACHE_DURATION && Array.isArray(cached.data) && cached.data.length > 0) {
          renderReleases(cached.data, listContainer);
          return;
        }
      }
    } catch (e) {}

    // 2. Fetch from GitHub API
    try {
      const res = await fetch(GH_RELEASES_URL, {
        headers: { 'Accept': 'application/vnd.github.v3+json' }
      });
      if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
      const data = await res.json();

      if (Array.isArray(data) && data.length > 0) {
        localStorage.setItem(GH_RELEASES_CACHE_KEY, JSON.stringify({
          timestamp: Date.now(),
          data: data
        }));
        renderReleases(data, listContainer);
      } else {
        renderFallbackReleases(listContainer);
      }
    } catch (err) {
      console.warn('Failed to fetch GitHub releases, using fallback:', err);
      renderFallbackReleases(listContainer);
    }
  }

  function renderReleases(releases, container) {
    if (!container) return;

    const latestBadge = document.getElementById('changelog-latest-badge');
    if (latestBadge && releases[0] && releases[0].tag_name) {
      latestBadge.textContent = releases[0].tag_name;
    }

    container.innerHTML = releases.map((release, index) => {
      const isLatest = index === 0;
      const releaseDate = release.published_at 
        ? new Date(release.published_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })
        : '26 Agustus 2026';

      const bodyHtml = parseMarkdownToHtml(release.body || 'Tidak ada catatan rilis.');

      return `
        <div class="p-4 rounded-xl ${isLatest ? 'bg-[var(--q-hover)]/60 border border-[var(--q-border)] shadow-xs' : 'bg-[var(--q-hover)]/25 border border-[var(--q-border)] opacity-85'} space-y-2.5 transition-all">
          <div class="flex items-center justify-between pb-2 border-b border-[var(--q-border)]/50">
            <div class="flex items-center gap-2">
              <span class="font-bold text-sm text-[var(--q-text)]">${release.name || release.tag_name}</span>
              ${isLatest ? '<span class="text-[10px] font-bold px-2 py-0.5 rounded bg-[#598456]/20 text-[#1b594a] dark:text-[#baae4f]">Terbaru</span>' : ''}
            </div>
            <span class="text-[10px] text-[var(--q-muted)] font-medium">${releaseDate}</span>
          </div>

          <div class="changelog-body text-[var(--q-text)]">
            ${bodyHtml}
          </div>

          <div class="pt-2 border-t border-[var(--q-border)]/40 flex items-center justify-between">
            <a href="${release.html_url}" target="_blank" rel="noopener noreferrer" class="text-[10px] font-semibold text-[#1b594a] dark:text-[#baae4f] hover:underline inline-flex items-center gap-1">
              <span>Buka Rilis di GitHub</span>
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
            <span class="text-[10px] text-[var(--q-muted)] font-mono">${release.tag_name}</span>
          </div>
        </div>
      `;
    }).join('');
  }

  function renderFallbackReleases(container) {
    if (!container) return;
    container.innerHTML = `
      <div class="p-4 rounded-xl bg-[var(--q-hover)]/60 border border-[var(--q-border)] space-y-2.5">
        <div class="flex items-center justify-between pb-2 border-b border-[var(--q-border)]/50">
          <div class="flex items-center gap-2">
            <span class="font-bold text-sm text-[var(--q-text)]">Versi v2.1.1</span>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-[#598456]/20 text-[#1b594a] dark:text-[#baae4f]">Terbaru</span>
          </div>
          <span class="text-[10px] text-[var(--q-muted)]">26 Agustus 2026</span>
        </div>
        <ul class="list-disc list-inside space-y-1 text-[var(--q-text)] text-[11px] leading-relaxed">
          <li><strong>Tombol Back to Top Cerdas:</strong> Auto-hide di puncak halaman & auto-fade saat idle membaca.</li>
          <li><strong>Sistem Palet 6 Warna Kustom:</strong> Desain harmonis dengan rasio kontras WCAG AAA & mode gelap.</li>
          <li><strong>Aset Visual 3D & Kaligrafi HD:</strong> Ikon 3D untuk 4 layanan utama dan kaligrafi surat.</li>
          <li><strong>Redesain Modal Search Compact:</strong> Pencarian instan yang super ringkas dan responsif di mobile.</li>
          <li><strong>Preload Font Arab (Omar):</strong> Jaminan font Omar langsung termuat saat pertama kali diakses.</li>
          <li><strong>Perbaikan Tipografi & Sambungan Huruf:</strong> Line-height 1.45, ligature OpenType, dan overflow visible.</li>
        </ul>
      </div>
    `;
  }

  openChangelogBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (changelogModal) {
        changelogModal.classList.remove('hidden');
        loadGitHubReleases();
      }
    });
  });

  closeChangelogBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (changelogModal) changelogModal.classList.add('hidden');
    });
  });

  // Settings Input Listeners
  const fontInput = document.getElementById('setting-font-size');
  if (fontInput) {
    fontInput.addEventListener('input', (e) => {
      const val = parseInt(e.target.value, 10);
      const settings = getSettings();
      settings.arabicFontSize = val;
      saveSettings(settings);
    });
  }

  const latinInput = document.getElementById('setting-toggle-latin');
  if (latinInput) {
    latinInput.addEventListener('change', (e) => {
      const settings = getSettings();
      settings.showLatin = e.target.checked;
      saveSettings(settings);
    });
  }

  const transInput = document.getElementById('setting-toggle-translation');
  if (transInput) {
    transInput.addEventListener('change', (e) => {
      const settings = getSettings();
      settings.showTranslation = e.target.checked;
      saveSettings(settings);
    });
  }

  const tafsirInput = document.getElementById('setting-toggle-tafsir');
  if (tafsirInput) {
    tafsirInput.addEventListener('change', (e) => {
      const settings = getSettings();
      settings.showTafsir = e.target.checked;
      saveSettings(settings);
    });
  }

  const reciterSelect = document.getElementById('setting-reciter');
  if (reciterSelect) {
    reciterSelect.addEventListener('change', (e) => {
      const settings = getSettings();
      settings.reciter = e.target.value;
      saveSettings(settings);
    });
  }

  // --- Helper to resolve audio URL based on selected Qari ---
  function resolveAudioUrl(btn) {
    const settings = getSettings();
    const reciterKey = settings.reciter || 'ar.alafasy';
    const folder = RECITER_MAP[reciterKey] || 'Alafasy_128kbps';

    const verseItem = btn.closest('.js-verse-item');
    if (verseItem) {
      const surahNum = verseItem.getAttribute('data-surah-num');
      const ayahNum = verseItem.getAttribute('data-ayah');
      if (surahNum && ayahNum) {
        const s = String(surahNum).padStart(3, '0');
        const a = String(ayahNum).padStart(3, '0');
        return `https://everyayah.com/data/${folder}/${s}${a}.mp3`;
      }
    }

    const rawAudio = btn.getAttribute('data-audio');
    if (rawAudio) {
      const surahMatch = rawAudio.match(/\/(\d+)\.mp3$/);
      if (surahMatch) {
        const s = String(surahMatch[1]).padStart(3, '0');
        return `https://everyayah.com/data/${folder}/${s}001.mp3`;
      }
      return rawAudio;
    }

    return null;
  }

  // --- Verse Dropdown Menu Toggle Handler ---
  document.querySelectorAll('.js-verse-menu-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const parent = btn.closest('.relative');
      const dropdown = parent ? parent.querySelector('.js-verse-menu-dropdown') : null;
      if (dropdown) {
        document.querySelectorAll('.js-verse-menu-dropdown').forEach(d => {
          if (d !== dropdown) d.classList.add('hidden');
        });
        dropdown.classList.toggle('hidden');
      }
    });
  });

  document.addEventListener('click', () => {
    document.querySelectorAll('.js-verse-menu-dropdown').forEach(d => d.classList.add('hidden'));
  });

  // --- Global Audio Player Handler & Sequential Surah Playback ---
  let activeAudio = null;
  let activeAudioBtn = null;

  let isSequentialMode = false;
  let seqSurahNum = 0;
  let seqSurahName = '';
  let seqTotalVerses = 0;
  let seqCurrentAyah = 1;

  const audioPlayerBar = document.getElementById('quran-audio-player');
  const playerTitle = document.getElementById('player-title');
  const playerSubtitle = document.getElementById('player-subtitle');
  const playerBtnPlay = document.getElementById('player-btn-play');
  const playerBtnPlayMobile = document.getElementById('player-btn-play-mobile');
  const playerBtnPrev = document.getElementById('player-btn-prev');
  const playerBtnNext = document.getElementById('player-btn-next');
  const playerIconPlay = document.getElementById('player-icon-play');
  const playerIconPause = document.getElementById('player-icon-pause');
  const playerIconPlayM = document.getElementById('player-icon-play-m');
  const playerIconPauseM = document.getElementById('player-icon-pause-m');
  const playerSeekbar = document.getElementById('player-seekbar');
  const playerSeekbarM = document.getElementById('player-seekbar-m');
  const playerTimeCurrent = document.getElementById('player-time-current');
  const playerTimeCurrentM = document.getElementById('player-time-current-m');
  const playerTimeTotal = document.getElementById('player-time-total');
  const playerTimeTotalM = document.getElementById('player-time-total-m');
  const playerBtnClose = document.getElementById('player-btn-close');

  function formatTime(seconds) {
    if (isNaN(seconds) || seconds < 0) return '00:00';
    const m = Math.floor(seconds / 60);
    const s = Math.floor(seconds % 60);
    return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
  }

  function updatePlayerUI(isPlaying) {
    if (isPlaying) {
      if (playerIconPlay) playerIconPlay.classList.add('hidden');
      if (playerIconPause) playerIconPause.classList.remove('hidden');
      if (playerIconPlayM) playerIconPlayM.classList.add('hidden');
      if (playerIconPauseM) playerIconPauseM.classList.remove('hidden');
    } else {
      if (playerIconPlay) playerIconPlay.classList.remove('hidden');
      if (playerIconPause) playerIconPause.classList.add('hidden');
      if (playerIconPlayM) playerIconPlayM.classList.remove('hidden');
      if (playerIconPauseM) playerIconPauseM.classList.add('hidden');
    }
  }

  function togglePlayPause() {
    if (!activeAudio) return;
    if (activeAudio.paused) {
      activeAudio.play().then(() => updatePlayerUI(true)).catch(() => {});
    } else {
      activeAudio.pause();
      updatePlayerUI(false);
    }
  }

  if (playerBtnPlay) playerBtnPlay.addEventListener('click', togglePlayPause);
  if (playerBtnPlayMobile) playerBtnPlayMobile.addEventListener('click', togglePlayPause);

  if (playerBtnClose) {
    playerBtnClose.addEventListener('click', () => {
      isSequentialMode = false;
      if (activeAudio) {
        activeAudio.pause();
        activeAudio = null;
      }
      if (activeAudioBtn) {
        activeAudioBtn.classList.remove('animate-pulse');
        activeAudioBtn = null;
      }
      if (audioPlayerBar) {
        audioPlayerBar.classList.add('translate-y-full');
        setTimeout(() => audioPlayerBar.classList.add('hidden'), 300);
      }
    });
  }

  function handleSeek(e) {
    if (!activeAudio || !activeAudio.duration) return;
    const val = parseFloat(e.target.value);
    activeAudio.currentTime = (val / 100) * activeAudio.duration;
  }

  if (playerSeekbar) playerSeekbar.addEventListener('input', handleSeek);
  if (playerSeekbarM) playerSeekbarM.addEventListener('input', handleSeek);

  function getEveryAyahUrl(surahNum, ayahNum) {
    const settings = getSettings();
    const reciterKey = settings.reciter || 'ar.alafasy';
    const folder = RECITER_MAP[reciterKey] || 'Alafasy_128kbps';
    const s = String(surahNum).padStart(3, '0');
    const a = String(ayahNum).padStart(3, '0');
    return `https://everyayah.com/data/${folder}/${s}${a}.mp3`;
  }

  function playAyahInSequence(ayahNum) {
    if (ayahNum < 1 || ayahNum > seqTotalVerses) return;
    seqCurrentAyah = ayahNum;

    if (activeAudio) {
      activeAudio.pause();
      activeAudio = null;
    }

    const audioUrl = getEveryAyahUrl(seqSurahNum, seqCurrentAyah);
    activeAudio = new Audio(audioUrl);

    // Open Player Bar
    if (audioPlayerBar) {
      audioPlayerBar.classList.remove('hidden');
      requestAnimationFrame(() => audioPlayerBar.classList.remove('translate-y-full'));
    }

    const reciterSelect = document.getElementById('setting-reciter');
    const reciterName = reciterSelect ? reciterSelect.options[reciterSelect.selectedIndex].text : 'Mishary Rashid Alafasy';

    if (playerTitle) playerTitle.textContent = `QS. ${seqSurahName} : Ayat ${seqCurrentAyah} / ${seqTotalVerses}`;
    if (playerSubtitle) playerSubtitle.textContent = `Murottal ${reciterName}`;

    // Auto Smooth Scroll to playing verse
    const verseEl = document.getElementById(`ayah-${seqCurrentAyah}`) || document.getElementById(`verse-${seqCurrentAyah}`);
    if (verseEl) {
      verseEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    updatePlayerUI(true);

    activeAudio.play().catch(err => console.error('Audio play error:', err));

    activeAudio.ontimeupdate = () => {
      if (!activeAudio) return;
      const cur = activeAudio.currentTime || 0;
      const dur = activeAudio.duration || 0;
      const pct = dur > 0 ? (cur / dur) * 100 : 0;

      if (playerSeekbar) playerSeekbar.value = pct;
      if (playerSeekbarM) playerSeekbarM.value = pct;
      if (playerTimeCurrent) playerTimeCurrent.textContent = formatTime(cur);
      if (playerTimeCurrentM) playerTimeCurrentM.textContent = formatTime(cur);
      if (playerTimeTotal) playerTimeTotal.textContent = formatTime(dur);
      if (playerTimeTotalM) playerTimeTotalM.textContent = formatTime(dur);
    };

    activeAudio.onended = () => {
      if (isSequentialMode && seqCurrentAyah < seqTotalVerses) {
        playAyahInSequence(seqCurrentAyah + 1);
      } else {
        isSequentialMode = false;
        if (activeAudioBtn) activeAudioBtn.classList.remove('animate-pulse');
        activeAudio = null;
        activeAudioBtn = null;
        updatePlayerUI(false);
      }
    };
  }

  if (playerBtnNext) {
    playerBtnNext.addEventListener('click', () => {
      if (isSequentialMode && seqCurrentAyah < seqTotalVerses) {
        playAyahInSequence(seqCurrentAyah + 1);
      } else if (activeAudio && activeAudio.duration) {
        activeAudio.currentTime = Math.min(activeAudio.duration, activeAudio.currentTime + 10);
      }
    });
  }

  if (playerBtnPrev) {
    playerBtnPrev.addEventListener('click', () => {
      if (isSequentialMode && seqCurrentAyah > 1) {
        playAyahInSequence(seqCurrentAyah - 1);
      } else if (activeAudio && activeAudio.duration) {
        activeAudio.currentTime = Math.max(0, activeAudio.currentTime - 10);
      }
    });
  }

  // --- Handle Clicks on Verse Audio & Surah Audio ---
  document.querySelectorAll('.js-play-surah-audio').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const surahNum = parseInt(btn.getAttribute('data-surah-num') || '0', 10);
      const surahName = btn.getAttribute('data-surah-name') || '';
      const totalVerses = parseInt(btn.getAttribute('data-total-verses') || '0', 10);

      if (surahNum > 0 && totalVerses > 0) {
        // Toggle if already playing this surah
        if (isSequentialMode && seqSurahNum === surahNum && activeAudio) {
          if (activeAudio.paused) {
            activeAudio.play();
            updatePlayerUI(true);
          } else {
            activeAudio.pause();
            updatePlayerUI(false);
          }
          return;
        }

        isSequentialMode = true;
        seqSurahNum = surahNum;
        seqSurahName = surahName;
        seqTotalVerses = totalVerses;
        activeAudioBtn = btn;
        btn.classList.add('animate-pulse');

        playAyahInSequence(1);
      }
    });
  });

  document.querySelectorAll('.js-play-verse-audio').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      isSequentialMode = false;

      const audioUrl = resolveAudioUrl(btn);
      if (!audioUrl) return;

      if (activeAudio) {
        activeAudio.pause();
        const sameSrc = activeAudio.src === audioUrl;
        if (activeAudioBtn) activeAudioBtn.classList.remove('animate-pulse');
        if (sameSrc) {
          activeAudio = null;
          activeAudioBtn = null;
          updatePlayerUI(false);
          return;
        }
      }

      activeAudio = new Audio(audioUrl);
      activeAudioBtn = btn;
      btn.classList.add('animate-pulse');

      // Open Sticky Bottom Audio Player Bar
      if (audioPlayerBar) {
        audioPlayerBar.classList.remove('hidden');
        requestAnimationFrame(() => audioPlayerBar.classList.remove('translate-y-full'));
      }

      // Metadata Info
      const verseItem = btn.closest('.js-verse-item');
      const reciterSelect = document.getElementById('setting-reciter');
      const reciterName = reciterSelect ? reciterSelect.options[reciterSelect.selectedIndex].text : 'Mishary Rashid Alafasy';

      if (verseItem) {
        const surahName = verseItem.getAttribute('data-surah-name') || '';
        const ayahNum = verseItem.getAttribute('data-ayah') || '';
        if (playerTitle) playerTitle.textContent = `QS. ${surahName} : Ayat ${ayahNum}`;
        if (playerSubtitle) playerSubtitle.textContent = `Murottal ${reciterName}`;
      }

      updatePlayerUI(true);

      activeAudio.play().catch(err => console.error('Audio play error:', err));

      activeAudio.ontimeupdate = () => {
        if (!activeAudio) return;
        const cur = activeAudio.currentTime || 0;
        const dur = activeAudio.duration || 0;
        const pct = dur > 0 ? (cur / dur) * 100 : 0;

        if (playerSeekbar) playerSeekbar.value = pct;
        if (playerSeekbarM) playerSeekbarM.value = pct;
        if (playerTimeCurrent) playerTimeCurrent.textContent = formatTime(cur);
        if (playerTimeCurrentM) playerTimeCurrentM.textContent = formatTime(cur);
        if (playerTimeTotal) playerTimeTotal.textContent = formatTime(dur);
        if (playerTimeTotalM) playerTimeTotalM.textContent = formatTime(dur);
      };

      activeAudio.onended = () => {
        btn.classList.remove('animate-pulse');
        activeAudio = null;
        activeAudioBtn = null;
        updatePlayerUI(false);
      };
    });
  });

  // --- Expandable Text Toggle Handler (Selengkapnya... / Tutup) ---
  document.querySelectorAll('.js-expand-text').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const targetId = btn.getAttribute('data-target');
      const targetEl = document.getElementById(targetId);
      if (targetEl) {
        const isClamped = targetEl.classList.contains('line-clamp-4');
        if (isClamped) {
          targetEl.classList.remove('line-clamp-4');
          btn.innerHTML = '<span>Tutup</span>';
        } else {
          targetEl.classList.add('line-clamp-4');
          btn.innerHTML = '<span>Selengkapnya...</span>';
        }
      }
    });
  });

  // --- Tafsir Box Toggle Button Handler ---
  document.querySelectorAll('.js-toggle-tafsir').forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.getAttribute('data-target');
      const box = document.getElementById(targetId);
      if (box) {
        box.classList.toggle('hidden');
      }
    });
  });

  // --- Search Modal Handler (Contextual & Multi-Category) ---
  const searchModal = document.getElementById('quran-search-modal');
  const openSearchBtns = document.querySelectorAll('.js-open-search');
  const closeSearchBtns = document.querySelectorAll('.js-close-search');
  const searchInput = document.getElementById('quran-search-input');
  const searchItems = document.querySelectorAll('.js-search-item');
  const filterBtns = document.querySelectorAll('.js-search-filter-btn');
  const searchEmpty = document.getElementById('search-modal-empty');

  let activeFilter = 'all';

  // Determine initial active filter from pre-rendered active button
  filterBtns.forEach(btn => {
    if (btn.classList.contains('is-active') || btn.classList.contains('bg-[#1b594a]') || btn.classList.contains('bg-emerald-600')) {
      activeFilter = btn.getAttribute('data-filter') || 'all';
    }
  });

  function filterSearchResults() {
    const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
    let visibleCount = 0;

    searchItems.forEach(item => {
      const type = item.getAttribute('data-type');
      const text = (item.getAttribute('data-search') || '').toLowerCase();

      const matchesFilter = (activeFilter === 'all') || (type === activeFilter);
      const matchesQuery = (query === '') || text.includes(query);

      if (matchesFilter && matchesQuery) {
        item.classList.remove('hidden');
        visibleCount++;
      } else {
        item.classList.add('hidden');
      }
    });

    if (searchEmpty) {
      if (visibleCount === 0) {
        searchEmpty.classList.remove('hidden');
      } else {
        searchEmpty.classList.add('hidden');
      }
    }
  }

  filterBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      activeFilter = btn.getAttribute('data-filter') || 'all';

      filterBtns.forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');

      filterSearchResults();
    });
  });

  openSearchBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (searchModal) {
        searchModal.classList.remove('hidden');
        if (searchInput) {
          searchInput.focus();
          filterSearchResults();
        }
      }
    });
  });

  closeSearchBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (searchModal) searchModal.classList.add('hidden');
    });
  });

  if (searchInput) {
    searchInput.addEventListener('input', () => {
      filterSearchResults();
    });
  }

  // --- Robust Clipboard Copy Helper ---
  function copyToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
      return navigator.clipboard.writeText(text).catch(() => {
        return execCommandCopy(text);
      });
    }
    return execCommandCopy(text);
  }

  function execCommandCopy(text) {
    return new Promise((resolve, reject) => {
      const textarea = document.createElement('textarea');
      textarea.value = text;
      textarea.style.position = 'fixed';
      textarea.style.left = '-999999px';
      textarea.style.top = '-999999px';
      document.body.appendChild(textarea);
      textarea.focus();
      textarea.select();
      try {
        const successful = document.execCommand('copy');
        document.body.removeChild(textarea);
        if (successful) resolve(); else reject(new Error('execCommand failed'));
      } catch (err) {
        document.body.removeChild(textarea);
        reject(err);
      }
    });
  }

  // --- Helper to build formatted verse text for Share & Copy ---
  function buildVerseShareText(target) {
    const btn = target.closest('button') || target;
    const surahName = btn.getAttribute('data-surah') || '';
    const surahNum = btn.getAttribute('data-surah-num') || '';
    const ayahNum = btn.getAttribute('data-ayah') || '';
    const arabic = btn.getAttribute('data-arabic') || '';
    const translation = btn.getAttribute('data-translation') || '';

    const isQuran = surahNum && parseInt(surahNum, 10) > 0 && surahName !== 'Tahlil';
    const baseUrl = window.location.origin + window.location.pathname;
    const verseUrl = isQuran ? `${baseUrl}#verse-${ayahNum}` : baseUrl;
    const title = isQuran ? `QS. ${surahName} [${surahNum}]: ${ayahNum}` : `Bacaan ${surahName || 'Tahlil'}`;

    const MAX_TRANS_LENGTH = 150;
    let transText = translation.trim();
    let shareBody = '';

    if (transText) {
      if (transText.length > MAX_TRANS_LENGTH) {
        const truncated = transText.substring(0, MAX_TRANS_LENGTH).trim();
        shareBody = `${arabic}\n\n"${truncated}..."\n\nSelengkapnya: ${verseUrl}`;
      } else {
        shareBody = `${arabic}\n\n"${transText}"\n\n${verseUrl}`;
      }
    } else {
      shareBody = `${arabic}\n\n${verseUrl}`;
    }

    return {
      title,
      isQuran,
      verseUrl,
      fullText: isQuran ? `${title}\n\n${shareBody}` : (surahName ? `${surahName}\n\n${shareBody}` : shareBody)
    };
  }

  // --- Copy Verse & Web Share API ---
  document.querySelectorAll('.js-copy-verse').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const targetBtn = e.currentTarget;
      const { fullText } = buildVerseShareText(targetBtn);

      copyToClipboard(fullText).then(() => {
        const originalText = targetBtn.innerHTML;
        targetBtn.innerHTML = `<svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-emerald-500 font-medium">Tersalin!</span>`;
        setTimeout(() => {
          targetBtn.innerHTML = originalText;
        }, 2000);
      }).catch(err => {
        console.error('Copy error:', err);
        alert('Gagal menyalin teks.');
      });
    });
  });

  // --- Custom Share Modal Handlers ---
  const shareModal = document.getElementById('quran-share-modal');
  const closeShareBtns = document.querySelectorAll('.js-close-share');
  let currentShareData = null;

  closeShareBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (shareModal) shareModal.classList.add('hidden');
    });
  });

  document.querySelectorAll('.js-share-verse').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const targetBtn = e.currentTarget;
      const data = buildVerseShareText(targetBtn);
      currentShareData = data;

      const titleEl = document.getElementById('share-modal-title');
      const subtitleEl = document.getElementById('share-modal-subtitle');
      const previewEl = document.getElementById('share-modal-preview');
      const btnWa = document.getElementById('share-btn-wa');
      const btnFb = document.getElementById('share-btn-fb');
      const btnX = document.getElementById('share-btn-x');
      const btnNative = document.getElementById('share-btn-native');

      if (titleEl) titleEl.textContent = data.title;
      if (subtitleEl) subtitleEl.textContent = data.isQuran ? `Bagikan Ayat ${data.title}` : `Bagikan ${data.title}`;
      if (previewEl) previewEl.textContent = data.fullText;

      const encodedText = encodeURIComponent(data.fullText);
      const encodedUrl = encodeURIComponent(data.verseUrl);

      if (btnWa) btnWa.href = `https://api.whatsapp.com/send?text=${encodedText}`;
      if (btnFb) btnFb.href = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
      if (btnX) btnX.href = `https://twitter.com/intent/tweet?text=${encodedText}`;

      if (btnNative) {
        if (navigator.share) {
          btnNative.classList.remove('hidden');
        } else {
          btnNative.classList.add('hidden');
        }
      }

      if (shareModal) shareModal.classList.remove('hidden');
    });
  });

  // Share Modal Action Buttons
  const modalNativeBtn = document.getElementById('share-btn-native');
  if (modalNativeBtn) {
    modalNativeBtn.addEventListener('click', () => {
      if (!currentShareData || !navigator.share) return;
      navigator.share({
        title: currentShareData.title,
        text: currentShareData.fullText,
        url: currentShareData.verseUrl
      }).catch(() => {});
    });
  }

  const modalCopyBtn = document.getElementById('share-btn-copy');
  if (modalCopyBtn) {
    modalCopyBtn.addEventListener('click', () => {
      if (!currentShareData) return;
      copyToClipboard(currentShareData.fullText).then(() => {
        const textSpan = document.getElementById('share-btn-copy-text');
        if (textSpan) {
          const orig = textSpan.textContent;
          textSpan.textContent = 'Berhasil Disalin!';
          setTimeout(() => { textSpan.textContent = orig; }, 2000);
        }
      });
    });
  }

  // --- Bookmarks Modal Handler ---
  const bookmarksModal = document.getElementById('quran-bookmarks-modal');
  const openBookmarksBtns = document.querySelectorAll('.js-open-bookmarks');
  const closeBookmarksBtns = document.querySelectorAll('.js-close-bookmarks');
  const bookmarksListEl = document.getElementById('bookmarks-modal-list');

  function renderBookmarksList() {
    if (!bookmarksListEl) return;
    let bookmarks = [];
    try {
      bookmarks = JSON.parse(localStorage.getItem(BOOKMARKS_KEY)) || [];
    } catch (e) {
      bookmarks = [];
    }

    if (bookmarks.length === 0) {
      bookmarksListEl.innerHTML = `
        <div class="text-center py-8 text-[var(--q-muted)] text-xs">
          Belum ada ayat yang ditandai ke Bookmark.
        </div>
      `;
      return;
    }

    let html = '';
    bookmarks.forEach((b, idx) => {
      const dateStr = b.date ? new Date(b.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : '';
      html += `
        <div class="p-3 rounded-xl bg-[var(--q-hover)] border border-[var(--q-border)] flex items-center justify-between gap-3 group">
          <a href="/${b.slug}#verse-${b.ayah}" class="js-goto-bookmark flex-1 min-w-0" data-slug="${b.slug}" data-ayah="${b.ayah}">
            <div class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-[#598456] transition-colors truncate">
              QS. ${b.name} : Ayat ${b.ayah}
            </div>
            ${dateStr ? `<div class="text-[10px] text-[var(--q-muted)] mt-0.5">Ditandai: ${dateStr}</div>` : ''}
          </a>
          <button type="button" class="js-remove-bookmark p-1.5 rounded-lg text-[var(--q-muted)] hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-950/40 transition-colors shrink-0" data-index="${idx}" title="Hapus Bookmark">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
              <line x1="10" y1="11" x2="10" y2="17"></line>
              <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
          </button>
        </div>
      `;
    });

    bookmarksListEl.innerHTML = html;

    // Attach click events for remove
    bookmarksListEl.querySelectorAll('.js-remove-bookmark').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const index = parseInt(btn.getAttribute('data-index'), 10);
        bookmarks.splice(index, 1);
        localStorage.setItem(BOOKMARKS_KEY, JSON.stringify(bookmarks));
        renderBookmarksList();
        // Update star icon highlight on page
        document.querySelectorAll('.js-bookmark-verse').forEach(bBtn => {
          const surahNum = parseInt(bBtn.getAttribute('data-surah-num'), 10);
          const ayahNum = parseInt(bBtn.getAttribute('data-ayah'), 10);
          if (!bookmarks.some(b => b.surah === surahNum && b.ayah === ayahNum)) {
            bBtn.classList.remove('text-amber-500');
          }
        });
      });
    });

    // Attach click events for navigation
    bookmarksListEl.querySelectorAll('.js-goto-bookmark').forEach(link => {
      link.addEventListener('click', (e) => {
        if (bookmarksModal) bookmarksModal.classList.add('hidden');
        const ayahNum = link.getAttribute('data-ayah');
        const targetAyah = document.getElementById(`verse-${ayahNum}`) || document.getElementById(`ayah-${ayahNum}`);
        if (targetAyah) {
          e.preventDefault();
          targetAyah.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      });
    });
  }

  openBookmarksBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      renderBookmarksList();
      if (bookmarksModal) bookmarksModal.classList.remove('hidden');
    });
  });

  closeBookmarksBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      if (bookmarksModal) bookmarksModal.classList.add('hidden');
    });
  });

  // --- Bookmark Local Storage ---
  document.querySelectorAll('.js-bookmark-verse').forEach(btn => {
    btn.addEventListener('click', () => {
      const surahNum = parseInt(btn.getAttribute('data-surah-num'), 10);
      const ayahNum = parseInt(btn.getAttribute('data-ayah'), 10);
      const surahSlug = btn.getAttribute('data-slug');
      const surahName = btn.getAttribute('data-surah');

      let bookmarks = [];
      try {
        bookmarks = JSON.parse(localStorage.getItem(BOOKMARKS_KEY)) || [];
      } catch (e) {
        bookmarks = [];
      }

      const existsIndex = bookmarks.findIndex(b => b.surah === surahNum && b.ayah === ayahNum);
      if (existsIndex >= 0) {
        bookmarks.splice(existsIndex, 1);
        btn.classList.remove('text-amber-500');
      } else {
        bookmarks.push({ surah: surahNum, ayah: ayahNum, slug: surahSlug, name: surahName, date: new Date().toISOString() });
        btn.classList.add('text-amber-500');
      }

      localStorage.setItem(BOOKMARKS_KEY, JSON.stringify(bookmarks));
      renderBookmarksList();
    });
  });

  // Highlight existing bookmarks
  try {
    const bookmarks = JSON.parse(localStorage.getItem(BOOKMARKS_KEY)) || [];
    document.querySelectorAll('.js-bookmark-verse').forEach(btn => {
      const surahNum = parseInt(btn.getAttribute('data-surah-num'), 10);
      const ayahNum = parseInt(btn.getAttribute('data-ayah'), 10);
      if (bookmarks.some(b => b.surah === surahNum && b.ayah === ayahNum)) {
        btn.classList.add('text-amber-500');
      }
    });
  } catch (e) {}

  // --- Last Read Observer & Scroll Handler ---
  const verses = document.querySelectorAll('.js-verse-item');
  if (verses.length > 0 && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const surahNum = parseInt(entry.target.getAttribute('data-surah-num'), 10);
          const ayahNum = parseInt(entry.target.getAttribute('data-ayah'), 10);
          const surahName = entry.target.getAttribute('data-surah-name');
          const surahSlug = entry.target.getAttribute('data-surah-slug');

          const lastReadData = {
            surah: surahNum,
            ayah: ayahNum,
            name: surahName,
            slug: surahSlug,
            timestamp: Date.now()
          };

          localStorage.setItem(LAST_READ_KEY, JSON.stringify(lastReadData));
        }
      });
    }, { threshold: 0.6 });

    verses.forEach(v => observer.observe(v));
  }

  // Last Read Banner Renderer on Index Page
  const lastReadContainer = document.getElementById('quran-last-read-container');
  if (lastReadContainer) {
    try {
      const lastRead = JSON.parse(localStorage.getItem(LAST_READ_KEY));
      if (lastRead && lastRead.name && lastRead.ayah) {
        lastReadContainer.innerHTML = `
          <div class="quran-card p-4 mb-6 flex items-center justify-between bg-[var(--q-surface)] border border-[var(--q-border)] shadow-xs">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-[#598456]/15 text-[#1b594a] dark:text-[#baae4f] flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                  <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                  <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
              </div>
              <div>
                <div class="text-xs text-[var(--q-muted)]">Terakhir Dibaca</div>
                <div class="font-bold text-[var(--q-text)]">QS. ${lastRead.name} — Ayat ${lastRead.ayah}</div>
              </div>
            </div>
            <a href="/${lastRead.slug}/${lastRead.ayah}" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-[#1b594a] hover:bg-[#13463a] text-white transition-colors">
              Lanjutkan
            </a>
          </div>
        `;
      }
    } catch (e) {}
  }

  // --- Dynamic Back to Top Button (Disappears at Top & Auto-fades on Idle) ---
  const backToTopBtn = document.getElementById('quran-back-to-top');
  if (backToTopBtn) {
    let scrollIdleTimer = null;
    let isHovered = false;

    function showBackToTop() {
      backToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-8', 'translate-y-2');
      backToTopBtn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
    }

    function hideBackToTop(subtle = false) {
      if (isHovered) return;
      backToTopBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
      backToTopBtn.classList.add('opacity-0', 'pointer-events-none', subtle ? 'translate-y-2' : 'translate-y-8');
    }

    function handleScroll() {
      const scrollPos = window.scrollY || document.documentElement.scrollTop;

      if (scrollPos < 300) {
        hideBackToTop(false);
        if (scrollIdleTimer) clearTimeout(scrollIdleTimer);
      } else {
        showBackToTop();
        if (scrollIdleTimer) clearTimeout(scrollIdleTimer);
        
        // Auto fade out when idle after 2.5 seconds
        scrollIdleTimer = setTimeout(() => {
          if (!isHovered) {
            hideBackToTop(true);
          }
        }, 2500);
      }
    }

    window.addEventListener('scroll', handleScroll, { passive: true });

    backToTopBtn.addEventListener('mouseenter', () => {
      isHovered = true;
      showBackToTop();
      if (scrollIdleTimer) clearTimeout(scrollIdleTimer);
    });

    backToTopBtn.addEventListener('mouseleave', () => {
      isHovered = false;
      handleScroll();
    });

    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
});
