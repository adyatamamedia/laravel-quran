@props([
    'verse',
    'surah'
])

<div id="ayah-{{ $verse->ayahNumber }}" 
     class="js-verse-item pt-0.5 pb-1.5 quran-divider transition-colors"
     data-surah-num="{{ $surah->number }}"
     data-surah-name="{{ $surah->nameLatin }}"
     data-surah-slug="{{ $surah->slug }}"
     data-ayah="{{ $verse->ayahNumber }}">
    
    <!-- Verse Action Toolbar -->
    <div class="flex items-center justify-start mb-0">
        <!-- Left Side: Vertical 3-dots Menu Button & Dropdown -->
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
                    <!-- Play Audio -->
                    @if(!empty($verse->audioUrl))
                        <button type="button" 
                                class="js-play-verse-audio w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors font-medium"
                                data-audio="{{ $verse->audioUrl }}"
                                data-title="QS. {{ $surah->nameLatin }}: {{ $verse->ayahNumber }}">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"></path>
                            </svg>
                            <span>Putar Audio Ayat</span>
                        </button>
                    @endif

                    <!-- Tafsir Toggle -->
                    @if(!empty($verse->tafsir))
                        <button type="button" 
                                class="js-toggle-tafsir w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors font-medium"
                                data-target="tafsir-{{ $surah->number }}-{{ $verse->ayahNumber }}">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span>Tafsir Kemenag</span>
                        </button>
                    @endif
                </div>

                <div class="py-1">
                    <!-- Copy -->
                    <button type="button" 
                            class="js-copy-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                            data-surah="{{ $surah->nameLatin }}"
                            data-surah-num="{{ $surah->number }}"
                            data-ayah="{{ $verse->ayahNumber }}"
                            data-arabic="{{ $verse->arabicUtsmani }}"
                            data-latin="{{ $verse->latin }}"
                            data-translation="{{ $verse->translationId }}">
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                        </svg>
                        <span>Salin Teks Ayat</span>
                    </button>

                    <!-- Share -->
                    <button type="button" 
                            class="js-share-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                            data-surah="{{ $surah->nameLatin }}"
                            data-surah-num="{{ $surah->number }}"
                            data-ayah="{{ $verse->ayahNumber }}"
                            data-arabic="{{ $verse->arabicUtsmani }}"
                            data-translation="{{ $verse->translationId }}">
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                        <span>Bagikan Ayat</span>
                    </button>

                    <!-- Bookmark -->
                    <button type="button" 
                            class="js-bookmark-verse w-full text-left px-3 py-2 text-[var(--q-text)] hover:bg-[var(--q-hover)] flex items-center gap-2.5 transition-colors"
                            data-surah="{{ $surah->nameLatin }}"
                            data-surah-num="{{ $surah->number }}"
                            data-slug="{{ $surah->slug }}"
                            data-ayah="{{ $verse->ayahNumber }}">
                        <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                        <span>Bookmark Ayat</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Arabic Text -->
    <div class="font-arabic mt-0 mb-0.5 text-[var(--q-text)]">
        {{ $verse->arabicUtsmani }}
        <span class="font-arabic inline-block text-[var(--q-verse-accent)] mx-1.5 font-normal select-none text-2xl" dir="rtl">{{ $verse->getArabicAyahNumber() }}</span>
    </div>

    <!-- Latin Transliteration -->
    @if(!empty($verse->latin))
        <div class="verse-latin-text my-1">
            <div id="latin-text-{{ $surah->number }}-{{ $verse->ayahNumber }}" 
                 class="text-base font-medium text-[var(--q-verse-accent)] leading-relaxed italic line-clamp-4">
                {{ $verse->latin }}
            </div>
            @if(mb_strlen($verse->latin) > 180)
                <button type="button" 
                        class="js-expand-text text-xs font-bold text-[var(--q-verse-accent)] hover:underline mt-0.5" 
                        data-target="latin-text-{{ $surah->number }}-{{ $verse->ayahNumber }}">
                    <span>Selengkapnya...</span>
                </button>
            @endif
        </div>
    @endif

    <!-- Indonesian Translation -->
    @if(!empty($verse->translationId))
        <div class="verse-translation-text mt-1">
            <div id="trans-text-{{ $surah->number }}-{{ $verse->ayahNumber }}" 
                 class="text-base text-[var(--q-text)] leading-relaxed line-clamp-4">
                {{ $verse->translationId }}
            </div>
            @if(mb_strlen($verse->translationId) > 180)
                <button type="button" 
                        class="js-expand-text text-xs font-bold text-[var(--q-verse-accent)] hover:underline mt-0.5" 
                        data-target="trans-text-{{ $surah->number }}-{{ $verse->ayahNumber }}">
                    <span>Selengkapnya...</span>
                </button>
            @endif
        </div>
    @endif

    <!-- Tafsir Ringkas Kemenag RI Box -->
    @if(!empty($verse->tafsir))
        <div id="tafsir-{{ $surah->number }}-{{ $verse->ayahNumber }}" class="js-tafsir-box hidden mt-3 p-4 sm:p-5 rounded-2xl bg-[var(--q-surface)] border border-[var(--q-border)] shadow-md transition-all">
            <div class="flex items-center justify-between pb-2.5 mb-3 border-b border-[var(--q-border)]">
                <div class="flex items-center gap-2 text-sm font-bold text-[var(--q-verse-accent)]">
                    <svg class="w-4 h-4 text-[var(--q-verse-accent)] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Tafsir Ringkas Kemenag RI</span>
                </div>
                <span class="text-xs text-[var(--q-verse-accent)] font-bold">QS. {{ $surah->nameLatin }}: {{ $verse->ayahNumber }}</span>
            </div>
            <div id="tafsir-text-{{ $surah->number }}-{{ $verse->ayahNumber }}" 
                 class="verse-tafsir-text text-base text-[var(--q-text)] leading-relaxed font-normal whitespace-pre-line line-clamp-4">
                {!! e($verse->tafsir) !!}
            </div>
            @if(mb_strlen($verse->tafsir) > 180)
                <button type="button" 
                        class="js-expand-text inline-flex items-center gap-1 mt-2.5 text-xs font-bold text-[var(--q-verse-accent)] hover:underline" 
                        data-target="tafsir-text-{{ $surah->number }}-{{ $verse->ayahNumber }}">
                    <span>Selengkapnya...</span>
                </button>
            @endif
        </div>
    @endif
</div>
