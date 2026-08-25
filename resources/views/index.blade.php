@extends('quran::layouts.quran')

@section('title', 'Al-Qur\'an Online 30 Juz & Kumpulan Doa ASWAJA')
@section('meta_description', 'Baca Al-Qur\'an 30 Juz online lengkap 114 surah, teks Arab Utsmani, transliterasi Latin, terjemahan Indonesia, serta kumpulan Doa Harian, Dzikir Wirid & Kitab Maulid Nabi.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-2">
    <!-- Service Navigation Card (Centered with Big Icons) -->
    <div class="quran-card p-5 sm:p-7 rounded-3xl mb-6 shadow-xs">
        <div class="grid grid-cols-4 gap-2 sm:gap-6 text-center max-w-2xl mx-auto">
            <!-- Al-Quran -->
            <a href="{{ route('quran.home') }}" class="flex flex-col items-center group">
                <div class="w-16 h-16 sm:w-20 sm:h-20 flex items-center justify-center mb-2">
                    <img src="{{ asset('vendor/quran/images/quran.png') }}" alt="Al-Quran" class="w-full h-full object-contain drop-shadow-md">
                </div>
                <span class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-[#598456] dark:group-hover:text-[#e0d68f] transition-colors">Al-Quran</span>
            </a>

            <!-- Tahlil & Yasin -->
            <a href="{{ route('quran.tahlil') }}" class="flex flex-col items-center group">
                <div class="w-16 h-16 sm:w-20 sm:h-20 flex items-center justify-center mb-2">
                    <img src="{{ asset('vendor/quran/images/tahlil.png') }}" alt="Tahlil & Yasin" class="w-full h-full object-contain drop-shadow-md">
                </div>
                <span class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-[#598456] dark:group-hover:text-[#e0d68f] transition-colors">Tahlil & Yasin</span>
            </a>

            <!-- Wirid & Doa -->
            <a href="{{ route('quran.wirid') }}" class="flex flex-col items-center group">
                <div class="w-16 h-16 sm:w-20 sm:h-20 flex items-center justify-center mb-2">
                    <img src="{{ asset('vendor/quran/images/wirid.png') }}" alt="Wirid & Doa" class="w-full h-full object-contain drop-shadow-md">
                </div>
                <span class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-[#598456] dark:group-hover:text-[#e0d68f] transition-colors">Wirid & Doa</span>
            </a>

            <!-- Maulid -->
            <a href="{{ route('quran.maulid') }}" class="flex flex-col items-center group">
                <div class="w-16 h-16 sm:w-20 sm:h-20 flex items-center justify-center mb-2">
                    <img src="{{ asset('vendor/quran/images/maulid.png') }}" alt="Maulid" class="w-full h-full object-contain drop-shadow-md">
                </div>
                <span class="font-bold text-xs sm:text-sm text-[var(--q-text)] group-hover:text-[#598456] dark:group-hover:text-[#e0d68f] transition-colors">Maulid</span>
            </a>
        </div>
    </div>

    <!-- Centered Popular Surah Pills -->
    <div class="flex flex-wrap items-center justify-center gap-2.5 mb-8">
        @foreach($popularSurahs as $pop)
            <a href="{{ !empty($pop['isVerse']) ? url($pop['slug']) : route('quran.surah.show', ['surahSlug' => $pop['slug']]) }}" 
               class="px-4 py-2 rounded-full bg-[var(--q-surface)] text-[var(--q-text)] dark:text-[#e6ece6] font-semibold text-xs hover:bg-[#1b594a] hover:text-white dark:hover:bg-[#598456] transition-all shadow-2xs border border-[var(--q-border)]">
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
                    <div class="w-10 h-10 rounded-xl bg-[var(--q-hover)] group-hover:bg-[#1b594a] group-hover:text-white dark:group-hover:bg-[#598456] text-[var(--q-text)] font-bold text-sm flex items-center justify-center transition-colors">
                        {{ $surah->number }}
                    </div>

                    <!-- Surah Details -->
                    <div>
                        <div class="font-bold text-sm text-[var(--q-text)] group-hover:text-[#598456] dark:group-hover:text-[#e0d68f] transition-colors">
                            {{ $surah->nameLatin }}
                        </div>
                        <div class="text-xs text-[var(--q-muted)]">
                            {{ $surah->translatedName }} · <span class="font-medium">{{ $surah->versesCount }} Ayat</span>
                        </div>
                    </div>
                </div>

                <!-- Arabic Calligraphy Name -->
                <div class="font-calligraphy text-3xl text-[#1b594a] dark:text-[#baae4f] group-hover:text-[#baae4f] group-hover:scale-105 transition-all" title="{{ $surah->nameArabic }}">
                    {{ $surah->calligraphyGlyph }}
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
