@extends('quran::layouts.quran')

@section('title', 'QS. ' . $surah->nameLatin . ' (' . $surah->nameArabic . ') - ' . $surah->translatedName)
@section('meta_description', 'Baca Surat ' . $surah->nameLatin . ' (' . $surah->translatedName . ') ' . $surah->ayahCount . ' ayat lengkap dengan teks Arab Utsmani, transliterasi Latin, arti bahasa Indonesia, dan audio tilawah.')

@section('structured_data')
<script type="application/ld+json">
{
  "{{ '@' }}context": "https://schema.org",
  "{{ '@' }}type": "Chapter",
  "name": "Surah {{ $surah->nameLatin }} ({{ $surah->nameArabic }})",
  "headline": "Surah {{ $surah->nameLatin }} - {{ $surah->translatedName }}",
  "description": "Baca Surah {{ $surah->nameLatin }} ({{ $surah->translatedName }}) {{ $surah->ayahCount }} ayat lengkap teks Arab, latin, dan terjemahan bahasa Indonesia.",
  "inLanguage": ["ar", "id"],
  "numberOfPages": "{{ $surah->ayahCount }} Ayat",
  "isPartOf": {
    "{{ '@' }}type": "Book",
    "name": "Al-Qur'an Al-Karim"
  }
}
</script>
@endsection

@section('content')
<!-- Reader Top Toolbar (Full Width Edge-to-Edge, Flush to Navbar) -->
<div class="sticky top-16 z-30 -mt-6 bg-[var(--q-surface)]/95 backdrop-blur-md py-2.5 mb-6 border-b border-[var(--q-border)] transition-colors">
    <div class="quran-container flex flex-wrap items-center justify-between gap-3">
            <!-- Left: Back & Surah Navigation -->
            <div class="flex items-center gap-2">
                <a href="{{ route('quran.home') }}" 
                   class="h-9 w-9 flex items-center justify-center rounded-lg bg-[var(--q-hover)] text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-border)]/50 transition-colors shrink-0" 
                   title="Kembali ke Daftar Surah">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>

                @if($prevSurah)
                    <a href="{{ route('quran.surah.show', ['surahSlug' => $prevSurah['slug']]) }}" 
                       class="h-9 px-3 flex items-center rounded-lg bg-[var(--q-hover)] text-xs font-semibold text-[var(--q-text)] hover:text-emerald-600 hover:bg-[var(--q-border)]/50 transition-colors shrink-0"
                       title="Surah Sebelumnya: {{ $prevSurah['latin'] }}">
                        ← {{ $prevSurah['latin'] }}
                    </a>
                @endif

                @if($nextSurah)
                    <a href="{{ route('quran.surah.show', ['surahSlug' => $nextSurah['slug']]) }}" 
                       class="h-9 px-3 flex items-center rounded-lg bg-[var(--q-hover)] text-xs font-semibold text-[var(--q-text)] hover:text-emerald-600 hover:bg-[var(--q-border)]/50 transition-colors shrink-0"
                       title="Surah Selanjutnya: {{ $nextSurah['latin'] }}">
                        {{ $nextSurah['latin'] }} →
                    </a>
                @endif
            </div>

            <!-- Right: Surah/Ayah Selectors & Settings -->
            <div class="flex items-center gap-2">
                <!-- Surah Select Dropdown -->
                <div class="relative flex items-center">
                    <select onchange="window.location.href=this.value" 
                            class="h-9 pl-3 pr-7 rounded-lg bg-[var(--q-hover)] border border-[var(--q-border)] text-xs font-bold text-[var(--q-text)] focus:outline-hidden focus:ring-1 focus:ring-emerald-500 appearance-none cursor-pointer max-w-[140px] sm:max-w-[210px] truncate">
                        @foreach($allSurahs as $num => $s)
                            <option value="{{ route('quran.surah.show', ['surahSlug' => $s['slug']]) }}" {{ $num === $surah->number ? 'selected' : '' }}>
                                {{ $num }}. {{ $s['latin'] }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="w-3.5 h-3.5 absolute right-2.5 pointer-events-none text-[var(--q-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>

                <!-- Ayah Select Dropdown -->
                @if($surah->versesCount > 0)
                    <div class="relative flex items-center">
                        <select onchange="const el = document.getElementById('ayah-' + this.value); if(el) el.scrollIntoView({behavior: 'smooth', block: 'center'});" 
                                class="h-9 pl-3 pr-7 rounded-lg bg-[var(--q-hover)] border border-[var(--q-border)] text-xs font-semibold text-[var(--q-text)] focus:outline-hidden focus:ring-1 focus:ring-emerald-500 appearance-none cursor-pointer">
                            <option value="">Ayat...</option>
                            @for($i = 1; $i <= $surah->versesCount; $i++)
                                <option value="{{ $i }}" {{ isset($targetAyah) && $targetAyah == $i ? 'selected' : '' }}>
                                    Ayat {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <svg class="w-3.5 h-3.5 absolute right-2.5 pointer-events-none text-[var(--q-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                @endif

                <!-- Settings Drawer Button -->
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

    <!-- Surah Header Card -->
    <div class="quran-card p-6 sm:p-8 text-center mb-8 relative overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-950 to-slate-950 text-white rounded-2xl shadow-xl border border-emerald-800/50">
        <!-- Pattern Accent Overlay -->
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>

        <!-- Calligraphy Surah Title (Gold) -->
        <div class="font-calligraphy text-6xl sm:text-7xl text-amber-300 mb-3 drop-shadow-md relative z-10" title="{{ $surah->nameArabic }}">
            {{ $surah->calligraphyGlyph }}
        </div>

        <!-- Latin Name (White) -->
        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight relative z-10">
            Surat {{ $surah->nameLatin }}
        </h1>

        <!-- Subtitle & Badges -->
        <div class="flex flex-wrap items-center justify-center gap-2 text-xs text-emerald-100/90 mt-2 relative z-10 font-medium">
            <span>"{{ $surah->translatedName }}"</span>
            <span>·</span>
            <span class="px-2.5 py-0.5 rounded-full bg-emerald-800/80 text-amber-300 font-semibold border border-emerald-700/60 shadow-xs">
                {{ $surah->revelationType }}
            </span>
            <span>·</span>
            <span>{{ $surah->versesCount }} Ayat</span>
        </div>

        <!-- Surah Audio Player Button -->
        @if(!empty($surah->audioUrl))
            <div class="mt-4 relative z-10 flex justify-center">
                <button type="button" 
                        class="js-play-surah-audio inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs shadow-md transition-all transform hover:scale-105"
                        data-audio="{{ $surah->audioUrl }}"
                        data-surah-num="{{ $surah->number }}"
                        data-surah-name="{{ $surah->nameLatin }}"
                        data-total-verses="{{ $surah->versesCount }}"
                        data-title="Surat {{ $surah->nameLatin }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"></path>
                    </svg>
                    <span>Putar Audio Surah</span>
                </button>
            </div>
        @endif

        <!-- Basmallah -->
        @if($surah->number !== 9 && $surah->number !== 1)
            <div class="font-arabic !text-center text-2xl sm:text-3xl text-amber-200/90 my-6 pt-5 border-t border-emerald-800/60 relative z-10 drop-shadow-xs">
                بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ
            </div>
        @endif
    </div>

    <!-- Verses Container -->
    <div class="space-y-2">
        @if(!empty($surah->verses))
            @foreach($surah->verses as $verse)
                @include('quran::components.verse-item', ['verse' => $verse, 'surah' => $surah])
            @endforeach
        @else
            <div class="text-center py-12 text-[var(--q-muted)]">
                <p class="text-base font-semibold">Teks ayat belum dapat dimuat saat ini.</p>
                <p class="text-xs mt-1">Silakan coba muat ulang halaman beberapa saat lagi.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
@if(isset($targetAyah) && $targetAyah > 0)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var targetEl = document.getElementById('ayah-{{ $targetAyah }}');
            if (targetEl) {
                targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                targetEl.classList.add('bg-emerald-500/10');
            }
        }, 300);
    });
</script>
@endif
@endpush
