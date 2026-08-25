@section('robots', 'noindex, follow')
@extends('quran::layouts.quran')

@section('title', 'Pencarian Surah: ' . $query)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-2">
    <div class="mb-6">
        <a href="{{ route('quran.home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#1b594a] dark:text-[#598456] hover:underline">
            <span>← Kembali ke Beranda Quran</span>
        </a>
        <h1 class="text-xl font-bold text-[var(--q-text)] mt-2">
            Hasil Pencarian: "<span class="text-[#1b594a] dark:text-[#baae4f]">{{ $query }}</span>"
        </h1>
        <p class="text-xs text-[var(--q-muted)]">Ditemukan {{ count($results) }} surah</p>
    </div>

    @if(count($results) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($results as $surah)
                <a href="{{ route('quran.surah.show', ['surahSlug' => $surah->slug]) }}" 
                   class="quran-card quran-card-hover p-4 flex items-center justify-between group">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-[var(--q-hover)] group-hover:bg-[#1b594a] group-hover:text-white dark:group-hover:bg-[#598456] text-[var(--q-text)] font-bold text-sm flex items-center justify-center transition-colors">
                            {{ $surah->number }}
                        </div>
                        <div>
                            <div class="font-bold text-sm text-[var(--q-text)] group-hover:text-[#598456] dark:group-hover:text-[#e0d68f] transition-colors">
                                {{ $surah->nameLatin }}
                            </div>
                            <div class="text-xs text-[var(--q-muted)]">
                                {{ $surah->translatedName }} · {{ $surah->versesCount }} Ayat
                            </div>
                        </div>
                    </div>
                    <div class="font-calligraphy text-3xl text-[#1b594a] dark:text-[#baae4f] group-hover:text-[#baae4f] transition-colors" title="{{ $surah->nameArabic }}">
                        {{ $surah->calligraphyGlyph }}
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="quran-card p-12 text-center text-[var(--q-muted)]">
            <p class="text-base font-semibold text-[var(--q-text)]">Surah tidak ditemukan</p>
            <p class="text-xs mt-1">Coba kata kunci lain atau cari berdasarkan nomor surah.</p>
        </div>
    @endif
</div>
@endsection
