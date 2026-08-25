<div id="quran-search-modal" class="fixed inset-0 z-50 hidden flex items-start justify-center pt-3 sm:pt-14 px-3 sm:px-4">
    <!-- Backdrop -->
    <div class="js-close-search fixed inset-0 quran-modal-backdrop"></div>

    @php
        $surahList = \Adyatama\Quran\Support\SurahSlug::all();

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
            ? 'Cari doa (wudhu, rezeki...), kategori...' 
            : ($isMaulid 
                ? 'Cari kitab maulid...' 
                : ($isTahlil 
                    ? 'Cari tahlil, yasin, dzikir...' 
                    : 'Cari surah, doa, wirid, maulid...'));
    @endphp

    <!-- Modal Content (Compact & Responsive) -->
    <div class="relative w-full max-w-lg bg-[var(--q-surface)] rounded-2xl shadow-2xl border border-[var(--q-border)] overflow-hidden z-10 flex flex-col max-h-[85vh] sm:max-h-[80vh]">
        
        <!-- Search Input Header -->
        <div class="p-2.5 sm:p-3.5 border-b border-[var(--q-border)] space-y-2 shrink-0">
            <!-- Search Bar Input Box -->
            <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-[var(--q-hover)] border border-[var(--q-border)]/60 focus-within:border-[#598456] focus-within:ring-1 focus-within:ring-[#598456] transition-all">
                <svg class="w-4 h-4 text-[var(--q-muted)] shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" 
                       id="quran-search-input" 
                       placeholder="{{ $placeholder }}" 
                       autocomplete="off"
                       class="w-full bg-transparent border-none text-xs sm:text-sm text-[var(--q-text)] placeholder-[var(--q-muted)] focus:outline-none">
                
                <!-- Quick Close Button -->
                <button type="button" class="js-close-search p-1 text-[var(--q-muted)] hover:text-[var(--q-text)] rounded-lg hover:bg-[var(--q-surface)] transition-colors shrink-0" title="Tutup">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Compact Context Filter Pills -->
            <div class="flex items-center gap-1 overflow-x-auto pb-0.5 scrollbar-none text-[11px]" id="search-filter-pills">
                <button type="button" data-filter="all" class="js-search-filter-btn q-tab-btn px-2.5 py-1 rounded-lg font-semibold shrink-0 {{ $defaultTab === 'all' ? 'is-active' : '' }}">
                    Semua
                </button>
                <button type="button" data-filter="surah" class="js-search-filter-btn q-tab-btn px-2.5 py-1 rounded-lg font-semibold shrink-0 {{ $defaultTab === 'surah' ? 'is-active' : '' }}">
                    Surah
                </button>
                <button type="button" data-filter="doa" class="js-search-filter-btn q-tab-btn px-2.5 py-1 rounded-lg font-semibold shrink-0 {{ $defaultTab === 'doa' ? 'is-active' : '' }}">
                    Doa
                </button>
                <button type="button" data-filter="wirid" class="js-search-filter-btn q-tab-btn px-2.5 py-1 rounded-lg font-semibold shrink-0 {{ $defaultTab === 'wirid' ? 'is-active' : '' }}">
                    Wirid
                </button>
                <button type="button" data-filter="maulid" class="js-search-filter-btn q-tab-btn px-2.5 py-1 rounded-lg font-semibold shrink-0 {{ $defaultTab === 'maulid' ? 'is-active' : '' }}">
                    Maulid
                </button>
            </div>
        </div>

        <!-- Search Results List (Compact Rows) -->
        <div class="overflow-y-auto p-1.5 sm:p-2 space-y-1 flex-1" id="search-modal-results">
            
            <!-- 1. Surahs -->
            @foreach($surahList as $num => $s)
                <a href="{{ route('quran.surah.show', ['surahSlug' => $s['slug']]) }}" 
                    class="js-search-item flex items-center justify-between p-2 rounded-xl hover:bg-[var(--q-hover)] transition-colors group"
                    data-type="surah"
                    data-search="{{ $num }} {{ $s['latin'] }} {{ $s['translation'] ?? '' }} {{ $s['slug'] }} surah quran">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="w-7 h-7 rounded-lg bg-[var(--q-hover)] group-hover:bg-[#1b594a] group-hover:text-white dark:group-hover:bg-[#598456] text-[var(--q-text)] font-bold text-xs flex items-center justify-center shrink-0 transition-colors">
                            {{ $num }}
                        </span>
                        <div class="min-w-0">
                            <div class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-[#598456] dark:group-hover:text-[#e0d68f] transition-colors truncate">
                                {{ $s['latin'] }}
                            </div>
                            <div class="text-[11px] text-[var(--q-muted)] truncate">
                                {{ $s['translation'] ?? '' }}
                            </div>
                        </div>
                    </div>
                    <span class="font-calligraphy text-2xl text-[#1b594a] dark:text-[#baae4f] shrink-0 group-hover:scale-105 transition-transform" title="{{ $s['arabic'] }}">
                        {{ mb_chr($num === 102 ? 0xE102 : (0xE000 + $num), 'UTF-8') }}
                    </span>
                </a>
            @endforeach

            <!-- 2. Doa Categories -->
            @foreach($doaCategoriesList as $cat)
                <a href="{{ route('quran.wirid', ['tab' => 'doa', 'kategori' => $cat['slug']]) }}" 
                    class="js-search-item flex items-center justify-between p-2 rounded-xl hover:bg-[var(--q-hover)] transition-colors group"
                    data-type="doa"
                    data-search="doa {{ $cat['name'] }} {{ $cat['desc'] }} {{ $cat['slug'] }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="w-7 h-7 rounded-lg bg-[#598456]/15 flex items-center justify-center shrink-0">
                            <img src="{{ asset('vendor/quran/images/wirid.png') }}" class="w-4 h-4 object-contain" alt="Doa">
                        </span>
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5">
                                <span class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-[#598456] dark:group-hover:text-[#e0d68f] transition-colors truncate">
                                    {{ $cat['name'] }}
                                </span>
                                <span class="text-[9px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wider bg-[#598456]/20 text-[#1b594a] dark:text-[#baae4f] shrink-0">
                                    Doa
                                </span>
                            </div>
                            <div class="text-[11px] text-[var(--q-muted)] truncate">{{ $cat['desc'] }}</div>
                        </div>
                    </div>
                    <svg class="w-3.5 h-3.5 text-[var(--q-muted)] group-hover:text-[var(--q-text)] group-hover:translate-x-0.5 transition-all shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            @endforeach

            <!-- 3. Wirid Collections -->
            @foreach($wiridList as $w)
                <a href="{{ route('quran.wirid', ['tab' => 'wirid', 'koleksi' => $w['slug']]) }}" 
                    class="js-search-item flex items-center justify-between p-2 rounded-xl hover:bg-[var(--q-hover)] transition-colors group"
                    data-type="wirid"
                    data-search="wirid dzikir {{ $w['name'] }} {{ $w['desc'] }} {{ $w['slug'] }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="w-7 h-7 rounded-lg bg-[#598456]/15 flex items-center justify-center shrink-0">
                            <img src="{{ asset('vendor/quran/images/wirid.png') }}" class="w-4 h-4 object-contain" alt="Wirid">
                        </span>
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5">
                                <span class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-[#598456] dark:group-hover:text-[#e0d68f] transition-colors truncate">
                                    {{ $w['name'] }}
                                </span>
                                <span class="text-[9px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wider bg-[#598456]/20 text-[#1b594a] dark:text-[#baae4f] shrink-0">
                                    Wirid
                                </span>
                            </div>
                            <div class="text-[11px] text-[var(--q-muted)] truncate">{{ $w['desc'] }}</div>
                        </div>
                    </div>
                    <svg class="w-3.5 h-3.5 text-[var(--q-muted)] group-hover:text-[var(--q-text)] group-hover:translate-x-0.5 transition-all shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            @endforeach

            <!-- 4. Maulid Collections -->
            @foreach($maulidList as $m)
                <a href="{{ route('quran.maulid', ['koleksi' => $m['slug']]) }}" 
                    class="js-search-item flex items-center justify-between p-2 rounded-xl hover:bg-[var(--q-hover)] transition-colors group"
                    data-type="maulid"
                    data-search="maulid nabi sholawat {{ $m['name'] }} {{ $m['desc'] }} {{ $m['slug'] }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="w-7 h-7 rounded-lg bg-[#598456]/15 flex items-center justify-center shrink-0">
                            <img src="{{ asset('vendor/quran/images/maulid.png') }}" class="w-4 h-4 object-contain" alt="Maulid">
                        </span>
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5">
                                <span class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-[#598456] dark:group-hover:text-[#e0d68f] transition-colors truncate">
                                    {{ $m['name'] }}
                                </span>
                                <span class="text-[9px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wider bg-[#598456]/20 text-[#1b594a] dark:text-[#baae4f] shrink-0">
                                    Maulid
                                </span>
                            </div>
                            <div class="text-[11px] text-[var(--q-muted)] truncate">{{ $m['desc'] }}</div>
                        </div>
                    </div>
                    <svg class="w-3.5 h-3.5 text-[var(--q-muted)] group-hover:text-[var(--q-text)] group-hover:translate-x-0.5 transition-all shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            @endforeach

            <!-- Empty Search Result -->
            <div id="search-modal-empty" class="hidden py-8 px-4 text-center text-[var(--q-muted)]">
                <svg class="w-8 h-8 mx-auto text-[var(--q-muted)]/60 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    <line x1="8" y1="11" x2="14" y2="11"></line>
                </svg>
                <p class="text-xs font-bold text-[var(--q-text)]">Tidak ada hasil ditemukan</p>
                <p class="text-[11px] text-[var(--q-muted)] mt-0.5">Coba kata kunci pencarian yang lain.</p>
            </div>
        </div>
    </div>
</div>
