<div id="quran-search-modal" class="fixed inset-0 z-50 hidden flex items-start justify-center pt-12 sm:pt-16 px-4">
    <!-- Backdrop -->
    <div class="js-close-search fixed inset-0 quran-modal-backdrop"></div>

    @php
        $surahList = \Quran\Support\SurahSlug::all();

        $doaCategoriesList = [
            ['name' => 'Doa Keseharian', 'slug' => 'doa-keseharian', 'desc' => '19 Bacaan Doa Harian'],
            ['name' => 'Doa Rezeki', 'slug' => 'doa-rezeki', 'desc' => '9 Bacaan Doa Kelancaran Rezeki'],
            ['name' => 'Doa Tolak Bala', 'slug' => 'doa-tolak-bala', 'desc' => '13 Bacaan Doa Perlindungan'],
            ['name' => 'Doa Kesehatan', 'slug' => 'doa-kesehatan', 'desc' => '5 Bacaan Doa Kesembuhan'],
            ['name' => 'Doa Perjalanan', 'slug' => 'doa-perjalanan', 'desc' => '10 Bacaan Doa Safar'],
            ['name' => 'Doa Ilmu', 'slug' => 'doa-ilmu', 'desc' => '9 Bacaan Doa Menuntut Ilmu'],
            ['name' => 'Doa Waktu Tertentu', 'slug' => 'doa-waktu-tertentu', 'desc' => '12 Bacaan Doa Momen Khusus'],
            ['name' => 'Doa Kualitas Diri', 'slug' => 'doa-kualitas-diri', 'desc' => '10 Bacaan Doa Akhlak'],
            ['name' => 'Doa Pernikahan & Rumah Tangga', 'slug' => 'doa-pernikahan-rumah-tangga', 'desc' => '10 Bacaan Doa Keluarga'],
            ['name' => 'Doa Hamil & Persalinan', 'slug' => 'doa-hamil-dan-persalinan', 'desc' => '7 Bacaan Doa Ibu & Anak'],
            ['name' => 'Doa Wudhu', 'slug' => 'doa-wudhu', 'desc' => '11 Bacaan Doa Bersuci'],
            ['name' => 'Doa para Nabi di Al-Quran', 'slug' => 'doa-para-nabi-di-al-quran', 'desc' => '14 Bacaan Doa Para Nabi'],
            ['name' => 'Doa Baca Al-Quran', 'slug' => 'doa-baca-al-quran', 'desc' => '7 Bacaan Doa Tilawah'],
            ['name' => 'Doa Shalat', 'slug' => 'doa-shalat', 'desc' => '20 Bacaan Doa Ibadah Shalat'],
            ['name' => 'Doa Harian', 'slug' => 'doa-harian', 'desc' => '5 Bacaan Doa Rutin'],
            ['name' => 'Doa Ibadah', 'slug' => 'doa-ibadah', 'desc' => '2 Bacaan Doa Ibadah'],
            ['name' => 'Doa Keselamatan', 'slug' => 'doa-keselamatan', 'desc' => '1 Bacaan Doa Selamat'],
            ['name' => 'Doa Kematian', 'slug' => 'doa-kematian', 'desc' => '6 Bacaan Doa Ziarah & Jenazah'],
        ];

        $wiridList = [
            ['name' => 'Ratib al-Haddad', 'slug' => 'ratib-al-haddad-tebuireng', 'desc' => 'Koleksi Dzikir Ratib Al-Haddad Tebuireng'],
            ['name' => 'Istighosah Kubro KH Sansuri Badawi', 'slug' => 'istighosah-kubro-kh-sansuri-badawi', 'desc' => 'Istighosah Kubro Ijazah KH Sansuri Badawi'],
            ['name' => 'Istighotsah & Mujahadah', 'slug' => 'istighotsah-mujahadah', 'desc' => 'Rangkaian Dzikir & Mujahadah'],
            ['name' => 'Ratib Al-Athos', 'slug' => 'ratib', 'desc' => 'Koleksi Dzikir Ratib Al-Athos'],
            ['name' => 'Hizib', 'slug' => 'hizib', 'desc' => 'Kumpulan Hizib ASWAJA'],
            ['name' => 'Manaqib Syekh Abdul Qadir', 'slug' => 'manaqib-syekh-abdul-qadir', 'desc' => 'Manaqib & Doa Syekh Abdul Qadir Al-Jilani'],
            ['name' => 'Tahlil Lengkap dan Doanya', 'slug' => 'tahlil-lengkap', 'desc' => 'Rangkaian Tahlil, Yasin & Doa Arwah'],
            ['name' => 'Dalailul Khairat', 'slug' => 'dalailul-khairat', 'desc' => 'Kitab Shalawat Dalailul Khairat'],
        ];

        $maulidList = [
            ['name' => 'Maulid ad-Diba\'i', 'slug' => 'maulid-dibai', 'desc' => 'Kitab Maulid Ad-Diba\'i Lengkap'],
            ['name' => 'Maulid Simtudduror', 'slug' => 'maulid-simtudduror', 'desc' => 'Kitab Maulid Simtudduror Habib Ali Al-Habsyi'],
            ['name' => 'Maulid Ad-Dhiya’ul Lami’', 'slug' => 'ad-dhiyaul-lami', 'desc' => 'Kitab Maulid Ad-Dhiya’ul Lami’ Habib Umar bin Hafidz'],
        ];

        $isWirid = request()->routeIs('quran.wirid*');
        $isMaulid = request()->routeIs('quran.maulid*');
        $isTahlil = request()->routeIs('quran.tahlil*');

        $defaultTab = $isWirid ? 'doa' : ($isMaulid ? 'maulid' : ($isTahlil ? 'wirid' : 'all'));
        $placeholder = $isWirid 
            ? 'Cari doa (wudhu, rezeki...), kategori, atau wirid...' 
            : ($isMaulid 
                ? 'Cari kitab maulid (Diba\'i, Simtudduror...)' 
                : ($isTahlil 
                    ? 'Cari tahlil, yasin, atau dzikir...' 
                    : 'Cari surah (Al-Baqarah, Yasin...), doa, wirid, maulid...'));
    @endphp

    <!-- Modal Content -->
    <div class="relative w-full max-w-lg bg-[var(--q-surface)] rounded-2xl shadow-2xl border border-[var(--q-border)] overflow-hidden z-10">
        
        <!-- Search Input Header -->
        <div class="p-3.5 sm:p-4 border-b border-[var(--q-border)] space-y-3">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-[var(--q-muted)] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" 
                       id="quran-search-input" 
                       placeholder="{{ $placeholder }}" 
                       class="w-full bg-transparent border-none text-[var(--q-text)] placeholder-[var(--q-muted)] focus:outline-none text-sm sm:text-base">
                <button type="button" class="js-close-search text-xs px-2 py-1 bg-[var(--q-hover)] text-[var(--q-muted)] rounded hover:text-[var(--q-text)] font-semibold shrink-0">
                    ESC
                </button>
            </div>

            <!-- Context Filter Pills -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-0.5 scrollbar-none text-xs" id="search-filter-pills">
                <button type="button" data-filter="all" class="js-search-filter-btn px-2.5 py-1 rounded-lg border border-[var(--q-border)] font-medium transition-colors {{ $defaultTab === 'all' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-[var(--q-surface)] text-[var(--q-muted)] hover:text-[var(--q-text)]' }}">
                    Semua
                </button>
                <button type="button" data-filter="surah" class="js-search-filter-btn px-2.5 py-1 rounded-lg border border-[var(--q-border)] font-medium transition-colors {{ $defaultTab === 'surah' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-[var(--q-surface)] text-[var(--q-muted)] hover:text-[var(--q-text)]' }}">
                    📖 Surah
                </button>
                <button type="button" data-filter="doa" class="js-search-filter-btn px-2.5 py-1 rounded-lg border border-[var(--q-border)] font-medium transition-colors {{ $defaultTab === 'doa' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-[var(--q-surface)] text-[var(--q-muted)] hover:text-[var(--q-text)]' }}">
                    🤲 Doa
                </button>
                <button type="button" data-filter="wirid" class="js-search-filter-btn px-2.5 py-1 rounded-lg border border-[var(--q-border)] font-medium transition-colors {{ $defaultTab === 'wirid' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-[var(--q-surface)] text-[var(--q-muted)] hover:text-[var(--q-text)]' }}">
                    📿 Wirid
                </button>
                <button type="button" data-filter="maulid" class="js-search-filter-btn px-2.5 py-1 rounded-lg border border-[var(--q-border)] font-medium transition-colors {{ $defaultTab === 'maulid' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-[var(--q-surface)] text-[var(--q-muted)] hover:text-[var(--q-text)]' }}">
                    📗 Maulid
                </button>
            </div>
        </div>

        <!-- Search Results List -->
        <div class="max-h-96 overflow-y-auto p-2 space-y-1" id="search-modal-results">
            
            <!-- 1. Surahs -->
            @foreach($surahList as $num => $s)
                <a href="{{ route('quran.surah.show', ['surahSlug' => $s['slug']]) }}" 
                   class="js-search-item flex items-center justify-between p-2.5 rounded-xl hover:bg-[var(--q-hover)] transition-colors"
                   data-type="surah"
                   data-search="{{ $num }} {{ $s['latin'] }} {{ $s['translation'] ?? '' }} {{ $s['slug'] }} surah quran">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-[var(--q-hover)] text-[var(--q-muted)] font-semibold text-xs flex items-center justify-center shrink-0">
                            {{ $num }}
                        </span>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-sm text-[var(--q-text)]">{{ $s['latin'] }}</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold uppercase">Surah</span>
                            </div>
                            <div class="text-xs text-[var(--q-muted)] mt-0.5">{{ $s['translation'] ?? '' }} · {{ $s['count'] }} Ayat</div>
                        </div>
                    </div>
                    <span class="font-calligraphy text-2xl text-emerald-900 dark:text-emerald-300" title="{{ $s['arabic'] }}">
                        {{ mb_chr($num === 102 ? 0xE102 : (0xE000 + $num), 'UTF-8') }}
                    </span>
                </a>
            @endforeach

            <!-- 2. Doa Categories -->
            @foreach($doaCategoriesList as $cat)
                <a href="{{ route('quran.wirid', ['tab' => 'doa', 'kategori' => $cat['slug']]) }}" 
                   class="js-search-item flex items-center justify-between p-2.5 rounded-xl hover:bg-[var(--q-hover)] transition-colors"
                   data-type="doa"
                   data-search="doa {{ $cat['name'] }} {{ $cat['desc'] }} {{ $cat['slug'] }}">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold text-sm flex items-center justify-center shrink-0">
                            🤲
                        </span>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-sm text-[var(--q-text)]">{{ $cat['name'] }}</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-teal-500/10 text-teal-600 dark:text-teal-400 font-bold uppercase">Doa</span>
                            </div>
                            <div class="text-xs text-[var(--q-muted)] mt-0.5">{{ $cat['desc'] }}</div>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-[var(--q-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endforeach

            <!-- 3. Wirid Collections -->
            @foreach($wiridList as $w)
                <a href="{{ route('quran.wirid', ['tab' => 'wirid', 'koleksi' => $w['slug']]) }}" 
                   class="js-search-item flex items-center justify-between p-2.5 rounded-xl hover:bg-[var(--q-hover)] transition-colors"
                   data-type="wirid"
                   data-search="wirid dzikir {{ $w['name'] }} {{ $w['desc'] }} {{ $w['slug'] }}">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold text-sm flex items-center justify-center shrink-0">
                            📿
                        </span>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-sm text-[var(--q-text)]">{{ $w['name'] }}</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-blue-500/10 text-blue-600 dark:text-blue-400 font-bold uppercase">Wirid</span>
                            </div>
                            <div class="text-xs text-[var(--q-muted)] mt-0.5">{{ $w['desc'] }}</div>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-[var(--q-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endforeach

            <!-- 4. Maulid Collections -->
            @foreach($maulidList as $m)
                <a href="{{ route('quran.maulid', ['koleksi' => $m['slug']]) }}" 
                   class="js-search-item flex items-center justify-between p-2.5 rounded-xl hover:bg-[var(--q-hover)] transition-colors"
                   data-type="maulid"
                   data-search="maulid nabi sholawat {{ $m['name'] }} {{ $m['desc'] }} {{ $m['slug'] }}">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold text-sm flex items-center justify-center shrink-0">
                            📗
                        </span>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-sm text-[var(--q-text)]">{{ $m['name'] }}</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold uppercase">Maulid</span>
                            </div>
                            <div class="text-xs text-[var(--q-muted)] mt-0.5">{{ $m['desc'] }}</div>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-[var(--q-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endforeach

            <!-- Empty Search Result -->
            <div id="search-modal-empty" class="hidden p-8 text-center text-[var(--q-muted)]">
                <p class="text-sm font-semibold text-[var(--q-text)]">Tidak ada hasil ditemukan.</p>
                <p class="text-xs mt-1">Coba kata kunci pencarian yang lain.</p>
            </div>
        </div>
    </div>
</div>
