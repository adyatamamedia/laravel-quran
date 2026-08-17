@extends('quran::layouts.quran')

@section('title', ($activeCollection['name'] ?? 'Kitab Maulid Nabi Muhammad SAW'))
@section('meta_description', 'Kumpulan Kitab Maulid Nabi Muhammad SAW lengkap dengan teks Arab, latin, dan terjemahan Indonesia.')

@section('content')
<!-- Reader Top Toolbar (Full Width Edge-to-Edge, Flush to Navbar) -->
<div class="sticky top-16 z-30 -mt-6 bg-[var(--q-surface)]/95 backdrop-blur-md py-2.5 mb-6 border-b border-[var(--q-border)] transition-colors">
    <div class="quran-container flex flex-wrap items-center justify-between gap-3">
        <!-- Left: Back Navigation -->
        <div class="flex items-center gap-2">
            @if(!empty($slug))
                <a href="{{ route('quran.maulid') }}" 
                   class="h-9 px-3 flex items-center gap-2 rounded-lg bg-[var(--q-hover)] text-xs font-bold text-[var(--q-text)] border border-[var(--q-border)] hover:bg-amber-600 hover:text-white transition-colors shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Daftar Maulid</span>
                </a>
            @else
                <a href="{{ route('quran.home') }}" 
                   class="h-9 w-9 flex items-center justify-center rounded-lg bg-[var(--q-hover)] text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-border)]/50 transition-colors shrink-0" 
                   title="Kembali ke Beranda">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
            @endif
        </div>

        <!-- Middle: Page Title -->
        <div class="text-center">
            <p class="text-xs font-bold text-[var(--q-muted)] uppercase tracking-widest">✨ Maulid Nabi</p>
        </div>

        <!-- Right: Settings -->
        <div class="flex items-center gap-2">
            <button type="button" 
                    class="js-open-settings h-9 w-9 flex items-center justify-center rounded-lg bg-[var(--q-hover)] border border-[var(--q-border)] text-[var(--q-text)] hover:text-amber-600 hover:border-amber-500 transition-colors shrink-0" 
                    title="Pengaturan Tampilan">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<div class="quran-reader-container">


    <!-- ========================================== -->
    <!-- MODE A: MAULID COLLECTIONS INDEX GRID      -->
    <!-- ========================================== -->
    @if(empty($slug))

        <div class="quran-card p-6 sm:p-8 text-center mb-6 relative overflow-hidden bg-gradient-to-br from-amber-900 via-amber-950 to-slate-950 text-white rounded-2xl shadow-xl border border-amber-800/50">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#f59e0b_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
            <div class="text-5xl sm:text-6xl mb-2 drop-shadow-md relative z-10">📗</div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight relative z-10">Kitab Maulid Nabi</h1>
            <p class="text-xs text-amber-100/90 mt-1 relative z-10 font-medium">Pilih Kitab Maulid yang ingin dibaca</p>
        </div>

        <!-- 2-COLUMN MAULID CARDS GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 sm:gap-4 mb-8">
            @forelse($maulidCollections as $col)
                <a href="{{ route('quran.maulid', ['koleksi' => $col['slug']]) }}" 
                   class="quran-card quran-card-hover p-0 flex items-stretch rounded-2xl border border-[var(--q-border)] bg-[var(--q-surface)] overflow-hidden group transition-all shadow-2xs">
                    
                    <!-- Left Number Box -->
                    <div class="w-14 sm:w-16 bg-amber-500/10 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 font-bold text-lg sm:text-xl flex items-center justify-center shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                        {{ $loop->iteration }}
                    </div>

                    <!-- Right Content -->
                    <div class="p-3.5 sm:p-4 flex-1 min-w-0 flex flex-col justify-center">
                        <h3 class="font-bold text-sm sm:text-base text-[var(--q-text)] group-hover:text-amber-600 transition-colors truncate">
                            {{ $col['name'] }}
                        </h3>
                        <p class="text-xs text-[var(--q-muted)] mt-0.5 font-medium">
                            {{ $col['sort_order'] > 0 ? ($col['sort_order'] * 3 + 4) : 6 }} Bacaan
                        </p>
                    </div>
                </a>
            @empty
                <div class="col-span-2 quran-card p-12 text-center text-[var(--q-muted)]">
                    <p class="text-base font-semibold">Tidak ada data Maulid tersedia.</p>
                </div>
            @endforelse
        </div>


    <!-- ========================================== -->
    <!-- MODE B: MAULID READER VIEW                 -->
    <!-- ========================================== -->
    @else

        <div class="quran-card p-6 sm:p-8 text-center mb-8 relative overflow-hidden bg-gradient-to-br from-amber-900 via-amber-950 to-slate-950 text-white rounded-2xl shadow-xl border border-amber-800/50">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#f59e0b_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
            <div class="text-5xl sm:text-6xl mb-3 drop-shadow-md relative z-10">📗</div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight relative z-10">
                {{ $activeCollection['name'] ?? 'Maulid' }}
            </h1>
            <p class="text-xs text-amber-100/90 mt-2 relative z-10 font-medium">
                {{ $activeCollection['description'] ?? 'Kitab Maulid Nabi Muhammad SAW' }}
            </p>
        </div>

        @if(!empty($activeCollection['sections']))
            @php($itemIndex = 1)
            @foreach($activeCollection['sections'] as $section)
                @foreach($section['items'] ?? [] as $item)
                    @if(($item['source_type'] ?? '') === 'content' && !empty($item['content']))
                        @php($c = $item['content'])
                        @php($vals = collect($c['values'] ?? [])->pluck('value', 'field_key'))
                        @php($arabic = $vals->get('arabic_text') ?? '')
                        @php($latin = $vals->get('latin') ?? '')
                        @php($translation = $vals->get('translation') ?? '')
                        @php($repeat = (int) ($item['repeat_count'] ?? $vals->get('repeat') ?? 1))
                        @php($repeatArabic = str_replace(['0','1','2','3','4','5','6','7','8','9'], ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'], (string) $repeat))

                        <div id="maulid-item-{{ $itemIndex }}" 
                             class="js-verse-item pt-0.5 pb-1.5 quran-divider transition-colors"
                             data-surah-num="0"
                             data-surah-name="{{ $activeCollection['name'] ?? 'Maulid' }}"
                             data-surah-slug="maulid"
                             data-ayah="{{ $itemIndex }}">
                            
                            <!-- 3-dot menu LEFT (matching verse-item layout) -->
                            <div class="flex items-center justify-start mb-0">
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
                                                    data-surah="{{ $activeCollection['name'] ?? 'Maulid' }}"
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
                                                    data-surah="{{ $activeCollection['name'] ?? 'Maulid' }}"
                                                    data-surah-num="0"
                                                    data-ayah="{{ $itemIndex }}"
                                                    data-arabic="{{ $arabic }}"
                                                    data-translation="{{ $translation }}">
                                                <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                                </svg>
                                                <span>Bagikan Bacaan</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                    <div id="maulid-latin-{{ $itemIndex }}" class="text-base font-medium text-[var(--q-verse-accent)] leading-relaxed italic line-clamp-4">
                                        {{ $latin }}
                                    </div>
                                </div>
                            @endif

                            @if(!empty($translation))
                                <div class="verse-translation-text mt-1">
                                    <div id="maulid-trans-{{ $itemIndex }}" class="text-base text-[var(--q-text)] leading-relaxed line-clamp-4">
                                        "{{ $translation }}"
                                    </div>
                                </div>
                            @endif
                        </div>

                        @php($itemIndex++)
                    @elseif(($item['source_type'] ?? '') === 'quran' && !empty($item['quran']['ayahs']))
                        @php($qSurah = $item['quran']['surah'] ?? null)
                        @php($qRepeat = (int) ($item['repeat_count'] ?? 1))
                        @php($qRepeatArabic = str_replace(['0','1','2','3','4','5','6','7','8','9'], ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'], (string) $qRepeat))
                        <div class="my-4">
                            @foreach($item['quran']['ayahs'] as $v)
                                <div id="ayah-m-{{ $v['surah_id'] }}-{{ $v['ayah_number'] }}" 
                                     class="js-verse-item pt-0.5 pb-1.5 quran-divider transition-colors"
                                     data-surah-num="{{ $qSurah['number'] ?? 0 }}"
                                     data-surah-name="{{ $qSurah['name_latin'] ?? '' }}"
                                     data-surah-slug="maulid"
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
                                            <div class="text-base font-medium text-[var(--q-verse-accent)] leading-relaxed italic line-clamp-4">{{ $v['latin'] }}</div>
                                        </div>
                                    @endif

                                    @if(!empty($v['translation']))
                                        <div class="verse-translation-text mt-1">
                                            <div class="text-base text-[var(--q-text)] leading-relaxed line-clamp-4">"{{ $v['translation'] }}"</div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            @endforeach
        @else
            <div class="quran-card p-12 text-center text-[var(--q-muted)]">
                <p class="text-base font-semibold text-[var(--q-text)]">Bacaan tidak tersedia.</p>
            </div>
        @endif

    @endif

</div>
@endsection
