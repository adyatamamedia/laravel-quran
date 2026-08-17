@extends('quran::layouts.quran')

@section('title', 'Al-Qur\'an 30 Juz Online & Kumpulan Doa ASWAJA | Quran NU Wajak')
@section('meta_description', 'Baca Al-Qur\'an 30 Juz online lengkap 114 surah, teks Arab Utsmani, transliterasi Latin, terjemahan Indonesia, serta kumpulan Doa Harian, Dzikir Wirid & Kitab Maulid Nabi.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-2">
    <!-- Service Navigation Card (Centered with Big Icons) -->
    <div class="quran-card p-5 sm:p-7 rounded-3xl mb-6 shadow-xs">
        <div class="grid grid-cols-4 gap-2 sm:gap-6 text-center max-w-2xl mx-auto">
            <!-- Al-Quran -->
            <a href="{{ route('quran.home') }}" class="flex flex-col items-center group">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full q-service-badge-quran flex items-center justify-center text-2xl sm:text-3xl shadow-xs mb-2">
                    📖
                </div>
                <span class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-emerald-600 transition-colors">Al-Quran</span>
            </a>

            <!-- Tahlil & Yasin -->
            <a href="{{ route('quran.tahlil') }}" class="flex flex-col items-center group">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full q-service-badge-tahlil flex items-center justify-center text-2xl sm:text-3xl shadow-xs mb-2">
                    🧎
                </div>
                <span class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-amber-600 transition-colors">Tahlil & Yasin</span>
            </a>

            <!-- Wirid & Doa -->
            <a href="{{ route('quran.wirid') }}" class="flex flex-col items-center group">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full q-service-badge-wirid flex items-center justify-center text-2xl sm:text-3xl shadow-xs mb-2">
                    🤲
                </div>
                <span class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-teal-600 transition-colors">Wirid & Doa</span>
            </a>

            <!-- Maulid -->
            <a href="{{ route('quran.maulid') }}" class="flex flex-col items-center group">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full q-service-badge-maulid flex items-center justify-center text-2xl sm:text-3xl shadow-xs mb-2">
                    📗
                </div>
                <span class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-indigo-600 transition-colors">Maulid</span>
            </a>
        </div>
    </div>

    <!-- Centered Popular Surah Pills -->
    <div class="flex flex-wrap items-center justify-center gap-2.5 mb-8">
        @foreach($popularSurahs as $pop)
            <a href="{{ !empty($pop['isVerse']) ? url($pop['slug']) : route('quran.surah.show', ['surahSlug' => $pop['slug']]) }}" 
               class="px-4 py-2 rounded-full bg-emerald-100/90 dark:bg-emerald-950/70 text-emerald-900 dark:text-emerald-300 font-semibold text-xs hover:bg-emerald-600 hover:text-white transition-all shadow-2xs border border-emerald-200/60 dark:border-emerald-800/60">
                {{ $pop['name'] }}
            </a>
        @endforeach
    </div>

    <!-- Last Read Container -->
    <div id="quran-last-read-container" class="mb-8"></div>



    <!-- Surahs Grid (114 Surahs - 3 Columns on Desktop) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach($surahs as $surah)
            <a href="{{ route('quran.surah.show', ['surahSlug' => $surah->slug]) }}" 
               class="quran-card quran-card-hover p-4 flex items-center justify-between group transition-all">
                <div class="flex items-center gap-3.5">
                    <!-- Surah Number Box -->
                    <div class="w-10 h-10 rounded-xl bg-[var(--q-hover)] group-hover:bg-emerald-600 group-hover:text-white text-[var(--q-text)] font-bold text-sm flex items-center justify-center transition-colors">
                        {{ $surah->number }}
                    </div>

                    <!-- Surah Details -->
                    <div>
                        <div class="font-bold text-sm text-[var(--q-text)] group-hover:text-emerald-600 transition-colors">
                            {{ $surah->nameLatin }}
                        </div>
                        <div class="text-xs text-[var(--q-muted)]">
                            {{ $surah->translatedName }} · <span class="font-medium">{{ $surah->versesCount }} Ayat</span>
                        </div>
                    </div>
                </div>

                <!-- Arabic Calligraphy Name -->
                <div class="font-calligraphy text-3xl text-emerald-900 dark:text-emerald-300 group-hover:scale-105 transition-transform" title="{{ $surah->nameArabic }}">
                    {{ $surah->calligraphyGlyph }}
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
