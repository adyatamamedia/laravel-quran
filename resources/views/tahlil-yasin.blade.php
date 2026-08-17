@extends('quran::layouts.quran')

@section('title', ($tab === 'yasin' ? 'Surah Yasin' : 'Tahlil Lengkap & Doa') . ' | Quran NU Wajak')
@section('meta_description', 'Bacaan Tahlil Lengkap, Doa Arwah, dan Surah Yasin dengan teks Arab, latin, terjemahan Indonesia, dan audio murottal.')

@section('content')
<!-- Reader Top Toolbar (Full Width Edge-to-Edge, Flush to Navbar) -->
<div class="sticky top-16 z-30 -mt-6 bg-[var(--q-surface)]/95 backdrop-blur-md py-2.5 mb-6 border-b border-[var(--q-border)] transition-colors">
    <div class="quran-container flex items-center justify-between gap-3">
        <!-- Left: Back Navigation -->
        <div class="flex items-center gap-2">
            <a href="{{ route('quran.home') }}" 
               class="h-9 w-9 flex items-center justify-center rounded-lg bg-[var(--q-hover)] text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-border)]/50 transition-colors shrink-0" 
               title="Kembali ke Beranda Quran">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
        </div>

        <!-- Middle: Tab Switcher (Tahlil / Yasin) -->
        <div class="flex items-center bg-[var(--q-hover)] p-1 rounded-xl border border-[var(--q-border)] shadow-xs">
            <a href="{{ route('quran.tahlil', ['tab' => 'tahlil']) }}" 
               class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $tab === 'tahlil' ? 'bg-emerald-600 text-white shadow-sm' : 'text-[var(--q-muted)] hover:text-[var(--q-text)]' }}">
                <span>Tahlil</span>
            </a>
            <a href="{{ route('quran.tahlil', ['tab' => 'yasin']) }}" 
               class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $tab === 'yasin' ? 'bg-emerald-600 text-white shadow-sm' : 'text-[var(--q-muted)] hover:text-[var(--q-text)]' }}">
                <span>Yasin</span>
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

    <!-- Surah / Tahlil Header Card (Identical to Single Surah Header) -->
    <div class="quran-card p-6 sm:p-8 text-center mb-8 relative overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-950 to-slate-950 text-white rounded-2xl shadow-xl border border-emerald-800/50">
        <!-- Pattern Accent Overlay -->
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>

        <!-- Calligraphy / Icon -->
        <div class="font-calligraphy text-6xl sm:text-7xl text-amber-300 mb-3 drop-shadow-md relative z-10">
            {{ $tab === 'yasin' ? ($yasinSurah ? $yasinSurah->calligraphyGlyph : 'يس') : '📿' }}
        </div>

        <!-- Title -->
        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight relative z-10">
            {{ $tab === 'yasin' ? 'Surat Yasin' : 'Tahlil Lengkap & Doa' }}
        </h1>

        <!-- Subtitle & Badges -->
        <div class="flex flex-wrap items-center justify-center gap-2 text-xs text-emerald-100/90 mt-2 relative z-10 font-medium">
            <span>{{ $tab === 'yasin' ? '"' . ($yasinSurah ? $yasinSurah->translatedName : 'Eyemoon') . '"' : 'Rangkaian Bacaan Tahlil & Doa Arwah' }}</span>
            <span>·</span>
            <span class="px-2.5 py-0.5 rounded-full bg-emerald-800/80 text-amber-300 font-semibold border border-emerald-700/60 shadow-xs">
                {{ $tab === 'yasin' ? ($yasinSurah ? $yasinSurah->revelationType : 'Makkiyah') : 'MUI' }}
            </span>
            <span>·</span>
            <span>{{ $tab === 'yasin' ? ($yasinSurah ? $yasinSurah->versesCount : 83) . ' Ayat' : 'Rangkaian Dzikir' }}</span>
        </div>

        @if($tab === 'yasin' && $yasinSurah && !empty($yasinSurah->audioUrl))
            <!-- Yasin Audio Player Button -->
            <div class="mt-4 relative z-10 flex justify-center">
                <button type="button" 
                        class="js-play-surah-audio inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs shadow-md transition-all transform hover:scale-105"
                        data-audio="{{ $yasinSurah->audioUrl }}"
                        data-surah-num="36"
                        data-surah-name="Yasin"
                        data-total-verses="83"
                        data-title="Surat Yasin">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"></path>
                    </svg>
                    <span>Putar Audio Surah Yasin</span>
                </button>
            </div>
        @endif

        @if($tab === 'yasin' && $yasinSurah)
            <!-- Basmallah -->
            @if($yasinSurah->number !== 9 && $yasinSurah->number !== 1)
                <div class="font-arabic !text-center text-2xl sm:text-3xl text-amber-200/90 my-6 pt-5 border-t border-emerald-800/60 relative z-10 drop-shadow-xs">
                    بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ
                </div>
            @endif
        @endif
    </div>

    <!-- TAB 1: TAHLIL LENGKAP -->
    @if($tab === 'tahlil')
        @if(!empty($tahlilData['sections']))
            @php($itemIndex = 1)
            @foreach($tahlilData['sections'] as $section)
                @foreach($section['items'] ?? [] as $item)
                    @if(($item['source_type'] ?? '') === 'content' && !empty($item['content']))
                        @php($c = $item['content'])
                        @php($vals = collect($c['values'] ?? [])->pluck('value', 'field_key'))
                        @php($arabic = $vals->get('arabic_text') ?? '')
                        @php($latin = $vals->get('latin') ?? '')
                        @php($translation = $vals->get('translation') ?? '')
                        @php($repeat = (int) ($item['repeat_count'] ?? $vals->get('repeat') ?? 1))
                        @php($repeatArabic = str_replace(['0','1','2','3','4','5','6','7','8','9'], ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'], (string) $repeat))

                        <div id="tahlil-item-{{ $itemIndex }}" 
                             class="js-verse-item pt-0.5 pb-1.5 quran-divider transition-colors"
                             data-surah-num="0"
                             data-surah-name="Tahlil"
                             data-surah-slug="tahlil-yasin"
                             data-ayah="{{ $itemIndex }}">
                            
                            <!-- Action Toolbar (Identical to verse-item.blade.php) -->
                            <div class="flex items-center justify-between mb-0">
                                <div class="relative">
                                    <button type="button" 
                                            class="js-verse-menu-btn p-1 rounded-md border border-[var(--q-border)] bg-[var(--q-surface)] text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] transition-colors flex items-center justify-center"
                                            title="Menu Opsi Bacaan">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div class="js-verse-menu-dropdown hidden absolute left-0 mt-1.5 w-48 bg-[var(--q-surface)] border border-[var(--q-border)] rounded-xl shadow-xl z-30 py-1 text-xs divide-y divide-[var(--q-border)]">
                                        <div class="py-1">
                                            <!-- Copy -->
                                            <button type="button" 
                                                    class="js-copy-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                                                    data-surah="Tahlil"
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

                                            <!-- Share -->
                                            <button type="button" 
                                                    class="js-share-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                                                    data-surah="Tahlil"
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

                            <!-- Arabic Text with End-of-Verse Repeater -->
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

                            <!-- Latin Transliteration -->
                            @if(!empty($latin))
                                <div class="verse-latin-text my-1">
                                    <div id="tahlil-latin-{{ $itemIndex }}" 
                                         class="text-base font-medium text-[var(--q-verse-accent)] leading-relaxed italic line-clamp-4">
                                        {{ $latin }}
                                    </div>
                                    @if(mb_strlen($latin) > 180)
                                        <button type="button" 
                                                class="js-expand-text text-xs font-bold text-[var(--q-verse-accent)] hover:underline mt-0.5" 
                                                data-target="tahlil-latin-{{ $itemIndex }}">
                                            <span>Selengkapnya...</span>
                                        </button>
                                    @endif
                                </div>
                            @endif

                            <!-- Indonesian Translation -->
                            @if(!empty($translation))
                                <div class="verse-translation-text mt-1">
                                    <div id="tahlil-trans-{{ $itemIndex }}" 
                                         class="text-base text-[var(--q-text)] leading-relaxed line-clamp-4">
                                        "{{ $translation }}"
                                    </div>
                                    @if(mb_strlen($translation) > 180)
                                        <button type="button" 
                                                class="js-expand-text text-xs font-bold text-[var(--q-verse-accent)] hover:underline mt-0.5" 
                                                data-target="tahlil-trans-{{ $itemIndex }}">
                                            <span>Selengkapnya...</span>
                                        </button>
                                    @endif
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
                                <div id="ayah-{{ $v['surah_id'] }}-{{ $v['ayah_number'] }}" 
                                     class="js-verse-item pt-0.5 pb-1.5 quran-divider transition-colors"
                                     data-surah-num="{{ $qSurah['number'] ?? 0 }}"
                                     data-surah-name="{{ $qSurah['name_latin'] ?? '' }}"
                                     data-surah-slug="tahlil-yasin"
                                     data-ayah="{{ $v['ayah_number'] }}">
                                    
                                    <div class="flex items-center justify-between mb-0">
                                        <div class="relative">
                                            <button type="button" 
                                                    class="js-verse-menu-btn p-1 rounded-md border border-[var(--q-border)] bg-[var(--q-surface)] text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] transition-colors flex items-center justify-center"
                                                    title="Menu Opsi Ayat">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                </svg>
                                            </button>

                                            <!-- Dropdown Menu -->
                                            <div class="js-verse-menu-dropdown hidden absolute left-0 mt-1.5 w-48 bg-[var(--q-surface)] border border-[var(--q-border)] rounded-xl shadow-xl z-30 py-1 text-xs divide-y divide-[var(--q-border)]">
                                                <div class="py-1">
                                                    @if(!empty($v['audio']['primary']))
                                                        <button type="button" 
                                                                class="js-play-verse-audio w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors font-medium"
                                                                data-audio="{{ $v['audio']['primary'] }}"
                                                                data-title="QS. {{ $qSurah['name_latin'] ?? '' }}: {{ $v['ayah_number'] }}">
                                                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M8 5v14l11-7z"></path>
                                                            </svg>
                                                            <span>Putar Audio Ayat</span>
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="py-1">
                                                    <button type="button" 
                                                            class="js-copy-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                                                            data-surah="{{ $qSurah['name_latin'] ?? '' }}"
                                                            data-surah-num="{{ $qSurah['number'] ?? 0 }}"
                                                            data-ayah="{{ $v['ayah_number'] }}"
                                                            data-arabic="{{ $v['arabic_uthmani'] ?? '' }}"
                                                            data-latin="{{ $v['latin'] ?? '' }}"
                                                            data-translation="{{ $v['translation'] ?? '' }}">
                                                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                                        </svg>
                                                        <span>Salin Teks Ayat</span>
                                                    </button>
                                                    <button type="button" 
                                                            class="js-share-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                                                            data-surah="{{ $qSurah['name_latin'] ?? '' }}"
                                                            data-surah-num="{{ $qSurah['number'] ?? 0 }}"
                                                            data-ayah="{{ $v['ayah_number'] }}"
                                                            data-arabic="{{ $v['arabic_uthmani'] ?? '' }}"
                                                            data-translation="{{ $v['translation'] ?? '' }}">
                                                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                                        </svg>
                                                        <span>Bagikan Ayat</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
                                            <div id="latin-q-{{ $v['id'] }}" 
                                                 class="text-base font-medium text-[var(--q-verse-accent)] leading-relaxed italic line-clamp-4">
                                                {{ $v['latin'] }}
                                            </div>
                                            @if(mb_strlen($v['latin']) > 180)
                                                <button type="button" 
                                                        class="js-expand-text text-xs font-bold text-[var(--q-verse-accent)] hover:underline mt-0.5" 
                                                        data-target="latin-q-{{ $v['id'] }}">
                                                    <span>Selengkapnya...</span>
                                                </button>
                                            @endif
                                        </div>
                                    @endif

                                    @if(!empty($v['translation']))
                                        <div class="verse-translation-text mt-1">
                                            <div id="trans-q-{{ $v['id'] }}" 
                                                 class="text-base text-[var(--q-text)] leading-relaxed line-clamp-4">
                                                "{{ $v['translation'] }}"
                                            </div>
                                            @if(mb_strlen($v['translation']) > 180)
                                                <button type="button" 
                                                        class="js-expand-text text-xs font-bold text-[var(--q-verse-accent)] hover:underline mt-0.5" 
                                                        data-target="trans-q-{{ $v['id'] }}">
                                                    <span>Selengkapnya...</span>
                                                </button>
                                            @endif
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
                <p class="text-base font-semibold text-[var(--q-text)]">Data Tahlil sedang dimuat...</p>
                <p class="text-xs mt-1">Jika belum tampil, silakan muat ulang halaman.</p>
            </div>
        @endif

    <!-- TAB 2: SURAH YASIN (Exact Quran Reader Component Loop) -->
    @elseif($tab === 'yasin')
        @if($yasinSurah && !empty($yasinSurah->verses))
            <!-- Verses Container (Exact verse-item.blade.php components) -->
            <div class="space-y-4">
                @foreach($yasinSurah->verses as $verse)
                    @include('quran::components.verse-item', ['verse' => $verse, 'surah' => $yasinSurah])
                @endforeach
            </div>
        @else
            <div class="quran-card p-12 text-center text-[var(--q-muted)]">
                <p class="text-base font-semibold text-[var(--q-text)]">Surah Yasin sedang dimuat...</p>
            </div>
        @endif
    @endif

</div>
@endsection
