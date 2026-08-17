@extends('quran::layouts.quran')

@section('title', ($tab === 'wirid' ? ($activeWiridCollection['name'] ?? 'Daftar Wirid & Dzikir ASWAJA') : ($activeDoaCategory['name'] ?? 'Kumpulan Doa Harian')))
@section('meta_description', 'Kumpulan Doa Harian, Wirid, Dzikir, Hizib, dan Ratib ASWAJA lengkap teks Arab, latin, dan terjemahan Indonesia.')

@section('content')
<!-- Reader Top Toolbar & Tab Switcher (Full Width Edge-to-Edge, Flush to Navbar) -->
<div class="sticky top-16 z-30 -mt-6 bg-[var(--q-surface)]/95 backdrop-blur-md py-2.5 mb-6 border-b border-[var(--q-border)] transition-colors">
    <div class="quran-container flex flex-wrap items-center justify-between gap-3">
            <!-- Left: Back Navigation -->
            <div class="flex items-center gap-2">
                @if(($tab === 'doa' && (!empty($categorySlug) || !empty($search))) || ($tab === 'wirid' && !empty($wiridSlug)))
                    <!-- Back to Category Cards Grid -->
                    <a href="{{ route('quran.wirid', ['tab' => $tab]) }}" 
                       class="h-9 px-3 flex items-center gap-2 rounded-lg bg-[var(--q-hover)] text-xs font-bold text-[var(--q-text)] border border-[var(--q-border)] hover:bg-emerald-600 hover:text-white transition-colors shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>{{ $tab === 'wirid' ? 'Daftar Wirid' : 'Daftar Doa' }}</span>
                    </a>
                @else
                    <a href="{{ route('quran.home') }}" 
                       class="h-9 w-9 flex items-center justify-center rounded-lg bg-[var(--q-hover)] text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-border)]/50 transition-colors shrink-0" 
                       title="Kembali ke Beranda Quran">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                @endif
            </div>

            <!-- Middle: Tab Switcher (Doa | Wirid) -->
            <div class="flex items-center bg-[var(--q-hover)] p-1 rounded-xl border border-[var(--q-border)] shadow-xs">
                <a href="{{ route('quran.wirid', ['tab' => 'doa']) }}" 
                   class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $tab === 'doa' ? 'bg-emerald-600 text-white shadow-sm' : 'text-[var(--q-muted)] hover:text-[var(--q-text)]' }}">
                    <span>🤲 Doa</span>
                </a>
                <a href="{{ route('quran.wirid', ['tab' => 'wirid']) }}" 
                   class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $tab === 'wirid' ? 'bg-emerald-600 text-white shadow-sm' : 'text-[var(--q-muted)] hover:text-[var(--q-text)]' }}">
                    <span>📿 Wirid</span>
                </a>
            </div>

            <!-- Right: Settings Drawer Button -->
            <div class="flex items-center gap-2">
                <button type="button" 
                        class="js-open-settings h-9 w-9 flex items-center justify-center rounded-lg bg-[var(--q-hover)] border border-[var(--q-border)] text-[var(--q-text)] hover:text-emerald-600 hover:border-emerald-500 transition-colors shrink-0" 
                        title="Pengaturan Tampilan Pembaca">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

<div class="quran-reader-container">


    <!-- ========================================== -->
    <!-- TAB 1: DOA CATEGORIES & READER             -->
    <!-- ========================================== -->
    @if($tab === 'doa')

        @if(empty($categorySlug) && empty($search))
            <!-- MODE A: DOA CATEGORIES INDEX GRID (EXACT MATCH SCREENSHOT 2) -->
            <div class="quran-card p-6 sm:p-8 text-center mb-6 relative overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-950 to-slate-950 text-white rounded-2xl shadow-xl border border-emerald-800/50">
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
                <div class="text-5xl sm:text-6xl mb-2 drop-shadow-md relative z-10">🤲</div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight relative z-10">Kategori Doa Islami</h1>
                <p class="text-xs text-emerald-100/90 mt-1 relative z-10 font-medium">Pilih Kategori Doa Harian & Pilihan ASWAJA</p>
            </div>




            <!-- 2-COLUMN DOA CATEGORY CARDS GRID (EXACT SCREENSHOT 2 MATCH) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 sm:gap-4 mb-8">
                @foreach($doaCategories as $cat)
                    <a href="{{ route('quran.wirid', ['tab' => 'doa', 'kategori' => $cat['slug']]) }}" 
                       class="quran-card quran-card-hover p-0 flex items-stretch rounded-2xl border border-[var(--q-border)] bg-[var(--q-surface)] overflow-hidden group transition-all shadow-2xs">
                        
                        <!-- Left Number Box (Light Green Rectangle) -->
                        <div class="w-14 sm:w-16 bg-emerald-500/10 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 font-bold text-lg sm:text-xl flex items-center justify-center shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            {{ $loop->iteration }}
                        </div>

                        <!-- Right Content -->
                        <div class="p-3.5 sm:p-4 flex-1 min-w-0 flex flex-col justify-center">
                            <h3 class="font-bold text-sm sm:text-base text-[var(--q-text)] group-hover:text-emerald-600 transition-colors truncate">
                                {{ $cat['name'] }}
                            </h3>
                            <p class="text-xs text-[var(--q-muted)] mt-0.5 font-medium">
                                {{ $cat['prayers_count'] ?? 0 }} Bacaan
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

        @else
            <!-- MODE B: TAHLIL-STYLE READER VIEW FOR SELECTED DOA CATEGORY -->
            <div class="quran-card p-6 sm:p-8 text-center mb-8 relative overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-950 to-slate-950 text-white rounded-2xl shadow-xl border border-emerald-800/50">
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
                <div class="text-5xl sm:text-6xl mb-3 drop-shadow-md relative z-10">🤲</div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight relative z-10">
                    {{ $activeDoaCategory['name'] ?? (!empty($search) ? 'Hasil Pencarian: "'.$search.'"' : 'Kumpulan Doa') }}
                </h1>
                <p class="text-xs text-emerald-100/90 mt-2 relative z-10 font-medium">Rangkaian Bacaan Doa ASWAJA Teks Utsmani, Transliterasi, & Terjemahan</p>
            </div>

            @if(!empty($doaItems))
                <div class="space-y-4">
                    @foreach($doaItems as $itemIndex => $prayer)
                        @php($vals = collect($prayer['values'] ?? [])->pluck('value', 'field_key'))
                        @php($arabic = $prayer['arabic_uthmani'] ?? $prayer['arabic'] ?? $vals->get('arabic_text') ?? $vals->get('arabic') ?? '')
                        @php($latin = $prayer['latin'] ?? $vals->get('latin') ?? '')
                        @php($translation = $prayer['translation'] ?? $vals->get('translation') ?? '')
                        @php($rawSource = $prayer['source'] ?? $vals->get('source') ?? null)
                        @php($sourceName = is_array($rawSource) ? ($rawSource['name'] ?? null) : (is_string($rawSource) ? $rawSource : null))
                        @php($sourceRef = is_array($rawSource) ? ($rawSource['reference'] ?? $rawSource['description'] ?? null) : ($prayer['description'] ?? null))
                        @php($sourceUrl = is_array($rawSource) ? ($rawSource['url'] ?? null) : null)
                        @php($sourceHadith = is_array($rawSource) ? ($rawSource['hadith_number'] ?? null) : null)

                        <div id="doa-item-{{ $loop->iteration }}" 
                             class="js-verse-item pt-0.5 pb-1.5 quran-divider transition-colors"
                             data-surah-num="0"
                             data-surah-name="{{ $prayer['title'] ?? 'Doa' }}"
                             data-surah-slug="wirid-doa"
                             data-ayah="{{ $loop->iteration }}">
                            
                            <!-- Action Toolbar: 3-dot LEFT, title CENTER (match verse-item layout) -->
                            <div class="flex items-center justify-start mb-0">
                                <!-- Left Side: Vertical 3-dots Menu Button & Dropdown -->
                                <div class="relative">
                                    <button type="button" 
                                            class="js-verse-menu-btn p-1 rounded-md border border-[var(--q-border)] bg-[var(--q-surface)] text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] transition-colors flex items-center justify-center"
                                            title="Menu Opsi Bacaan">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div class="js-verse-menu-dropdown hidden absolute left-0 mt-1.5 w-52 bg-[var(--q-surface)] border border-[var(--q-border)] rounded-xl shadow-xl z-30 py-1 text-xs divide-y divide-[var(--q-border)]">
                                        <div class="py-1">
                                            <button type="button" 
                                                    class="js-copy-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                                                    data-surah="{{ $prayer['title'] ?? 'Doa' }}"
                                                    data-surah-num="0"
                                                    data-ayah="{{ $loop->iteration }}"
                                                    data-arabic="{{ $arabic }}"
                                                    data-latin="{{ $latin }}"
                                                    data-translation="{{ $translation }}">
                                                <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                                </svg>
                                                <span>Salin Teks Doa</span>
                                            </button>
                                            <button type="button" 
                                                    class="js-share-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                                                    data-surah="{{ $prayer['title'] ?? 'Doa' }}"
                                                    data-surah-num="0"
                                                    data-ayah="{{ $loop->iteration }}"
                                                    data-arabic="{{ $arabic }}"
                                                    data-translation="{{ $translation }}">
                                                <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                                </svg>
                                                <span>Bagikan Doa</span>
                                            </button>

                                            @if(!empty($sourceName) || !empty($sourceRef) || !empty($sourceUrl))
                                                <button type="button" 
                                                        class="js-show-source w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors border-t border-[var(--q-border)] mt-1 pt-1.5"
                                                        data-title="{{ $prayer['title'] ?? 'Doa' }}"
                                                        data-source-name="{{ $sourceName ?? '' }}"
                                                        data-source-ref="{{ str_starts_with($sourceRef ?? '', '[Status:') ? '' : ($sourceRef ?? '') }}"
                                                        data-source-url="{{ $sourceUrl ?? '' }}">
                                                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                    <span class="font-medium text-emerald-600 dark:text-emerald-400">Sumber & Rujukan</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Doa Title: centered, with counter (X/Total), no emoji -->
                            <div class="text-center mb-3 mt-1">
                                <p class="text-xs text-[var(--q-muted)] font-semibold tracking-wide mb-0.5">{{ $loop->iteration }}/{{ count($doaItems) }}</p>
                                <h2 class="text-sm font-bold text-[var(--q-text)]">{{ $prayer['title'] ?? 'Doa' }}</h2>
                            </div>


                            <!-- Arabic Text -->
                            @if(!empty($arabic))
                                <div class="font-arabic mt-0 mb-0.5 text-[var(--q-text)]" dir="rtl">
                                    {{ $arabic }}
                                </div>
                            @endif

                            <!-- Latin Transliteration -->
                            @if(!empty($latin))
                                <div class="verse-latin-text my-1">
                                    <div id="doa-latin-{{ $loop->iteration }}" class="text-base font-medium text-[var(--q-verse-accent)] leading-relaxed italic line-clamp-4">
                                        {{ $latin }}
                                    </div>
                                    @if(mb_strlen($latin) > 180)
                                        <button type="button" class="js-expand-text text-xs font-bold text-[var(--q-verse-accent)] hover:underline mt-0.5" data-target="doa-latin-{{ $loop->iteration }}">
                                            <span>Selengkapnya...</span>
                                        </button>
                                    @endif
                                </div>
                            @endif

                            <!-- Indonesian Translation -->
                            @if(!empty($translation))
                                <div class="verse-translation-text mt-1">
                                    <div id="doa-trans-{{ $loop->iteration }}" class="text-base text-[var(--q-text)] leading-relaxed line-clamp-4">
                                        "{{ $translation }}"
                                    </div>
                                    @if(mb_strlen($translation) > 180)
                                        <button type="button" class="js-expand-text text-xs font-bold text-[var(--q-verse-accent)] hover:underline mt-0.5" data-target="doa-trans-{{ $loop->iteration }}">
                                            <span>Selengkapnya...</span>
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="quran-card p-12 text-center text-[var(--q-muted)]">
                    <p class="text-base font-semibold text-[var(--q-text)]">Teks Doa sedang dimuat...</p>
                </div>
            @endif
        @endif


    <!-- ========================================== -->
    <!-- TAB 2: WIRID CATEGORIES & READER           -->
    <!-- ========================================== -->
    @elseif($tab === 'wirid')

        @if(empty($wiridSlug))
            <!-- MODE C: WIRID CATEGORIES INDEX GRID (EXACT MATCH SCREENSHOT 1) -->
            <div class="quran-card p-6 sm:p-8 text-center mb-6 relative overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-950 to-slate-950 text-white rounded-2xl shadow-xl border border-emerald-800/50">
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
                <div class="text-5xl sm:text-6xl mb-2 drop-shadow-md relative z-10">📿</div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight relative z-10">Koleksi Wirid & Dzikir</h1>
                <p class="text-xs text-emerald-100/90 mt-1 relative z-10 font-medium">Pilih Rangkaian Wirid, Ratib, Hizib, & Manaqib ASWAJA</p>
            </div>

            <!-- 2-COLUMN WIRID CATEGORIES CARDS GRID (EXACT SCREENSHOT 1 MATCH) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 sm:gap-4 mb-8">
                @foreach($wiridCollections as $col)
                    <a href="{{ route('quran.wirid', ['tab' => 'wirid', 'koleksi' => $col['slug']]) }}" 
                       class="quran-card quran-card-hover p-0 flex items-stretch rounded-2xl border border-[var(--q-border)] bg-[var(--q-surface)] overflow-hidden group transition-all shadow-2xs">
                        
                        <!-- Left Number Box (Light Green Rectangle) -->
                        <div class="w-14 sm:w-16 bg-emerald-500/10 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 font-bold text-lg sm:text-xl flex items-center justify-center shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            {{ $loop->iteration }}
                        </div>

                        <!-- Right Content -->
                        <div class="p-3.5 sm:p-4 flex-1 min-w-0 flex flex-col justify-center">
                            <h3 class="font-bold text-sm sm:text-base text-[var(--q-text)] group-hover:text-emerald-600 transition-colors truncate">
                                {{ $col['name'] }}
                            </h3>
                            <p class="text-xs text-[var(--q-muted)] mt-0.5 font-medium">
                                {{ $col['sort_order'] > 0 ? ($col['sort_order'] * 3 + 4) : 6 }} Bacaan
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

        @else
            <!-- MODE D: TAHLIL-STYLE READER VIEW FOR SELECTED WIRID COLLECTION -->
            <div class="quran-card p-6 sm:p-8 text-center mb-8 relative overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-950 to-slate-950 text-white rounded-2xl shadow-xl border border-emerald-800/50">
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
                <div class="text-5xl sm:text-6xl mb-3 drop-shadow-md relative z-10">📿</div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight relative z-10">
                    {{ $activeWiridCollection['name'] ?? 'Wirid' }}
                </h1>
                <p class="text-xs text-emerald-100/90 mt-2 relative z-10 font-medium">
                    {{ $activeWiridCollection['description'] ?? 'Rangkaian Dzikir & Wirid ASWAJA' }}
                </p>
            </div>

            <!-- Items Loop (Same Tahlil Verse Item Flow) -->
            @if(!empty($activeWiridCollection['sections']))
                @php($itemIndex = 1)
                @foreach($activeWiridCollection['sections'] as $section)
                    @foreach($section['items'] ?? [] as $item)
                        @if(($item['source_type'] ?? '') === 'content' && !empty($item['content']))
                            @php($c = $item['content'])
                            @php($vals = collect($c['values'] ?? [])->pluck('value', 'field_key'))
                            @php($arabic = $vals->get('arabic_text') ?? '')
                            @php($latin = $vals->get('latin') ?? '')
                            @php($translation = $vals->get('translation') ?? '')
                            @php($repeat = (int) ($item['repeat_count'] ?? $vals->get('repeat') ?? 1))
                            @php($repeatArabic = str_replace(['0','1','2','3','4','5','6','7','8','9'], ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'], (string) $repeat))

                            @if(!empty($c['sections']))
                                <!-- Sub-Header Title for Multi-Segment Hizib/Wirid (Centered matching Doa with Counter X/Total) -->
                                <div class="text-center mt-8 mb-4 pt-4 border-t border-[var(--q-border)]">
                                    <p class="text-xs text-[var(--q-muted)] font-semibold tracking-wide mb-0.5">{{ $loop->iteration }}/{{ count($section['items'] ?? []) }}</p>
                                    <h2 class="text-sm sm:text-base font-bold text-[var(--q-text)]">{{ $c['title'] ?? 'Bacaan' }}</h2>
                                </div>

                                @foreach($c['sections'] as $seg)
                                    @php($segArabic = $seg['arabic'] ?? '')
                                    @php($segLatin = $seg['latin'] ?? '')
                                    @php($segTrans = $seg['translation'] ?? '')
                                    @php($segRepeat = (int) ($seg['repeat_count'] ?? 1))
                                    @php($segRepeatArabic = str_replace(['0','1','2','3','4','5','6','7','8','9'], ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'], (string) $segRepeat))

                                    @if(!empty($segArabic) || !empty($segLatin) || !empty($segTrans))
                                        <div id="wirid-item-{{ $itemIndex }}" 
                                             class="js-verse-item pt-0.5 pb-1.5 quran-divider transition-colors"
                                             data-surah-num="0"
                                             data-surah-name="{{ $c['title'] ?? ($activeWiridCollection['name'] ?? 'Wirid') }}"
                                             data-surah-slug="wirid-doa"
                                             data-ayah="{{ $itemIndex }}">
                                            
                                            <div class="flex items-center justify-between mb-0">
                                                <div class="relative">
                                                    <button type="button" 
                                                            class="js-verse-menu-btn p-1 rounded-md border border-[var(--q-border)] bg-[var(--q-surface)] text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] transition-colors flex items-center justify-center"
                                                            title="Menu Opsi Bacaan">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                        </svg>
                                                    </button>

                                                    <div class="js-verse-menu-dropdown hidden absolute left-0 mt-1.5 w-48 bg-[var(--q-surface)] border border-[var(--q-border)] rounded-xl shadow-xl z-30 py-1 text-xs divide-y divide-[var(--q-border)]">
                                                        <div class="py-1">
                                                            <button type="button" 
                                                                    class="js-copy-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                                                                    data-surah="{{ $c['title'] ?? ($activeWiridCollection['name'] ?? 'Wirid') }}"
                                                                    data-surah-num="0"
                                                                    data-ayah="{{ $itemIndex }}"
                                                                    data-arabic="{{ $segArabic }}"
                                                                    data-latin="{{ $segLatin }}"
                                                                    data-translation="{{ $segTrans }}">
                                                                <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                                                </svg>
                                                                <span>Salin Teks Bacaan</span>
                                                            </button>
                                                            <button type="button" 
                                                                    class="js-share-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                                                                    data-surah="{{ $c['title'] ?? ($activeWiridCollection['name'] ?? 'Wirid') }}"
                                                                    data-surah-num="0"
                                                                    data-ayah="{{ $itemIndex }}"
                                                                    data-arabic="{{ $segArabic }}"
                                                                    data-translation="{{ $segTrans }}">
                                                                <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                                                </svg>
                                                                <span>Bagikan Bacaan</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(!empty($segArabic))
                                                <div class="font-arabic mt-0 mb-0.5 text-[var(--q-text)]" dir="rtl">
                                                    {{ $segArabic }}
                                                    @if($segRepeat > 1)
                                                        <span class="inline-block text-amber-600 dark:text-amber-400 ms-2 font-arabic font-normal select-none" dir="rtl">
                                                            × {{ $segRepeatArabic }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif

                                            @if(!empty($segLatin))
                                                <div class="verse-latin-text my-1">
                                                    <div id="wirid-latin-{{ $itemIndex }}" class="text-base font-medium text-[var(--q-verse-accent)] leading-relaxed italic line-clamp-4">
                                                        {{ $segLatin }}
                                                    </div>
                                                </div>
                                            @endif

                                            @if(!empty($segTrans))
                                                <div class="verse-translation-text mt-1">
                                                    <div id="wirid-trans-{{ $itemIndex }}" class="text-base text-[var(--q-text)] leading-relaxed line-clamp-4">
                                                        "{{ $segTrans }}"
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        @php($itemIndex++)
                                    @endif
                                @endforeach
                            @elseif(!empty($arabic) || !empty($latin) || !empty($translation))
                                <div id="wirid-item-{{ $itemIndex }}" 
                                     class="js-verse-item pt-0.5 pb-1.5 quran-divider transition-colors"
                                     data-surah-num="0"
                                     data-surah-name="{{ $activeWiridCollection['name'] ?? 'Wirid' }}"
                                     data-surah-slug="wirid-doa"
                                     data-ayah="{{ $itemIndex }}">
                                    
                                    <div class="flex items-center justify-between mb-0">
                                        <div class="relative">
                                            <button type="button" 
                                                    class="js-verse-menu-btn p-1 rounded-md border border-[var(--q-border)] bg-[var(--q-surface)] text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] transition-colors flex items-center justify-center"
                                                    title="Menu Opsi Bacaan">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                </svg>
                                            </button>

                                            <div class="js-verse-menu-dropdown hidden absolute left-0 mt-1.5 w-48 bg-[var(--q-surface)] border border-[var(--q-border)] rounded-xl shadow-xl z-30 py-1 text-xs divide-y divide-[var(--q-border)]">
                                                <div class="py-1">
                                                    <button type="button" 
                                                            class="js-copy-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                                                            data-surah="{{ $activeWiridCollection['name'] ?? 'Wirid' }}"
                                                            data-surah-num="0"
                                                            data-ayah="{{ $itemIndex }}"
                                                            data-arabic="{{ $arabic }}"
                                                            data-latin="{{ $latin }}"
                                                            data-translation="{{ $translation }}">
                                                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                                        </svg>
                                                        <span>Salin Teks Bacaan</span>
                                                    </button>
                                                    <button type="button" 
                                                            class="js-share-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                                                            data-surah="{{ $activeWiridCollection['name'] ?? 'Wirid' }}"
                                                            data-surah-num="0"
                                                            data-ayah="{{ $itemIndex }}"
                                                            data-arabic="{{ $arabic }}"
                                                            data-translation="{{ $translation }}">
                                                        <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                                        </svg>
                                                        <span>Bagikan Bacaan</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if(!empty($c['title']))
                                        <div class="text-center mb-3 mt-1">
                                            <p class="text-xs text-[var(--q-muted)] font-semibold tracking-wide mb-0.5">{{ $loop->iteration }}/{{ count($section['items'] ?? []) }}</p>
                                            <h2 class="text-sm font-bold text-[var(--q-text)]">{{ $c['title'] }}</h2>
                                        </div>
                                    @endif

                                    @if(!empty($arabic))
                                        <div class="font-arabic mt-0 mb-0.5 text-[var(--q-text)]" dir="rtl">
                                            {{ $arabic }}
                                            @if($repeat > 1)
                                                <span class="inline-block text-amber-600 dark:text-amber-400 ms-2 font-arabic font-normal select-none" dir="rtl">
                                                    × {{ $repeatArabic }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    @if(!empty($latin))
                                        <div class="verse-latin-text my-1">
                                            <div id="wirid-latin-{{ $itemIndex }}" class="text-base font-medium text-[var(--q-verse-accent)] leading-relaxed italic line-clamp-4">
                                                {{ $latin }}
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($translation))
                                        <div class="verse-translation-text mt-1">
                                            <div id="wirid-trans-{{ $itemIndex }}" class="text-base text-[var(--q-text)] leading-relaxed line-clamp-4">
                                                "{{ $translation }}"
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @php($itemIndex++)
                            @endif
                        @elseif(($item['source_type'] ?? '') === 'quran' && !empty($item['quran']['ayahs']))
                            @php($qSurah = $item['quran']['surah'] ?? null)
                            @php($qRepeat = (int) ($item['repeat_count'] ?? 1))
                            @php($qRepeatArabic = str_replace(['0','1','2','3','4','5','6','7','8','9'], ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'], (string) $qRepeat))
                            <div class="my-4">
                                @foreach($item['quran']['ayahs'] as $v)
                                    <div id="ayah-{{ $v['surah_id'] }}-{{ $v['ayah_number'] }}" 
                                         class="js-verse-item pt-0.5 pb-1.5 quran-divider transition-colors"
                                         data-surah-num="{{ $qSurah['number'] ?? 0 }}"
                                         data-surah-name="{{ $qSurah['name_latin'] ?? '' }}"
                                         data-surah-slug="wirid-doa"
                                         data-ayah="{{ $v['ayah_number'] }}">
                                        
                                        <div class="font-arabic mt-0 mb-0.5 text-[var(--q-text)]" dir="rtl">
                                            {{ $v['arabic_uthmani'] ?? '' }}
                                            <span class="font-arabic inline-block text-[var(--q-verse-accent)] mx-1.5 font-normal select-none text-2xl" dir="rtl">{{ $v['ayah_marker'] ?? '' }}</span>
                                            @if($qRepeat > 1 && $loop->last)
                                                <span class="inline-block text-amber-600 dark:text-amber-400 ms-2 font-arabic font-normal select-none" dir="rtl">
                                                    × {{ $qRepeatArabic }}
                                                </span>
                                            @endif
                                        </div>

                                        @if(!empty($v['latin']))
                                            <div class="verse-latin-text my-1">
                                                <div id="latin-q-{{ $v['id'] }}" class="text-base font-medium text-[var(--q-verse-accent)] leading-relaxed italic line-clamp-4">
                                                    {{ $v['latin'] }}
                                                </div>
                                            </div>
                                        @endif

                                        @if(!empty($v['translation']))
                                            <div class="verse-translation-text mt-1">
                                                <div id="trans-q-{{ $v['id'] }}" class="text-base text-[var(--q-text)] leading-relaxed line-clamp-4">
                                                    "{{ $v['translation'] }}"
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endforeach
            @endif
        @endif
    @endif

</div>

<!-- Modal Sumber & Rujukan Doa -->
<div id="quran-source-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs transition-opacity">
    <div class="quran-card bg-[var(--q-surface)] border border-[var(--q-border)] rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-2xl relative transition-all transform scale-95 opacity-0 modal-content overflow-hidden">
        
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-[var(--q-border)] pb-3 mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-base">
                    📖
                </div>
                <div>
                    <h3 class="font-bold text-sm sm:text-base text-[var(--q-text)]" id="modal-source-title">Sumber & Rujukan Doa</h3>
                    <p class="text-xs text-[var(--q-muted)]">Sanad & Kitab Rujukan Doa ASWAJA</p>
                </div>
            </div>
            <button type="button" class="js-close-source-modal p-1.5 rounded-lg text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="space-y-3.5 text-xs sm:text-sm">
            <!-- Kitab / Hadith Name -->
            <div id="modal-source-name-box" class="p-3.5 rounded-xl bg-[var(--q-hover)] border border-[var(--q-border)]">
                <p class="text-xs font-semibold text-[var(--q-muted)] uppercase tracking-wider mb-1">Kitab / Riwayat / Hadits</p>
                <p class="font-bold text-[var(--q-text)] leading-snug" id="modal-source-name"></p>
            </div>

            <!-- Notes / Reference Details -->
            <div id="modal-source-ref-box" class="hidden p-3.5 rounded-xl bg-emerald-500/5 dark:bg-emerald-950/20 border border-emerald-500/20 text-[var(--q-text)]">
                <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Keterangan / Catatan Takhrij</p>
                <p class="text-xs sm:text-sm leading-relaxed" id="modal-source-ref"></p>
            </div>

            <!-- URL Link -->
            <div id="modal-source-url-box" class="hidden p-3.5 rounded-xl bg-[var(--q-hover)] border border-[var(--q-border)] text-[var(--q-text)]">
                <p class="text-xs font-semibold text-[var(--q-muted)] uppercase tracking-wider mb-1">Link Rujukan Online</p>
                <a id="modal-source-url" href="#" target="_blank" rel="noopener noreferrer" 
                   class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-emerald-600 dark:text-emerald-400 hover:underline break-all transition-colors">
                    <span id="modal-source-url-text" class="break-all"></span>
                    <svg class="w-3.5 h-3.5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-5 pt-3 border-t border-[var(--q-border)] flex justify-end">
            <button type="button" class="js-close-source-modal px-4 py-2 rounded-xl bg-[var(--q-hover)] text-[var(--q-text)] font-semibold text-xs hover:bg-[var(--q-border)] transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.js-show-source');
        if (btn) {
            const title = btn.dataset.title || 'Doa';
            const name = btn.dataset.sourceName || '';
            const ref = btn.dataset.sourceRef || '';
            const url = btn.dataset.sourceUrl || '';

            const modal = document.getElementById('quran-source-modal');
            if (!modal) return;
            const modalContent = modal.querySelector('.modal-content');
            
            document.getElementById('modal-source-title').textContent = title;
            document.getElementById('modal-source-name').textContent = name || 'Rujukan Hadis / Kitab Fiqih Klasik';
            
            const refBox = document.getElementById('modal-source-ref-box');
            if (ref && ref.trim().length > 0) {
                document.getElementById('modal-source-ref').textContent = ref;
                refBox.classList.remove('hidden');
            } else {
                refBox.classList.add('hidden');
            }

            const urlBox = document.getElementById('modal-source-url-box');
            const urlLink = document.getElementById('modal-source-url');
            const urlText = document.getElementById('modal-source-url-text');
            if (url && url.trim().length > 0 && url !== 'null') {
                urlLink.href = url;
                urlText.textContent = url;
                urlBox.classList.remove('hidden');
            } else {
                urlBox.classList.add('hidden');
            }

            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        if (e.target.closest('.js-close-source-modal') || (e.target && e.target.id === 'quran-source-modal')) {
            const modal = document.getElementById('quran-source-modal');
            if (modal && !modal.classList.contains('hidden')) {
                const modalContent = modal.querySelector('.modal-content');
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 150);
            }
        }
    });
});
</script>
@endsection

