<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Al-Qur\'an Online | Quran NU Wajak')</title>
    <meta name="description" content="@yield('meta_description', 'Baca Al-Qur\'an 30 Juz online lengkap dengan 114 surah, teks Arab Utsmani, transliterasi Latin, terjemahan Bahasa Indonesia, Doa Harian, Wirid & Kitab Maulid Nabi.')">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph / Facebook SEO -->
    <meta property="og:site_name" content="Quran NU Wajak">
    <meta property="og:title" content="@yield('title', 'Al-Qur\'an Online | Quran NU Wajak')">
    <meta property="og:description" content="@yield('meta_description', 'Baca Al-Qur\'an 30 Juz online lengkap dengan 114 surah, teks Arab Utsmani, transliterasi Latin, terjemahan Bahasa Indonesia, Doa Harian, Wirid & Kitab Maulid Nabi.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="id_ID">
    @php($defaultOgImage = $siteOgImage ?? $siteLogo ?? asset('assets/img/logo.png'))
    <meta property="og:image" content="@yield('og_image', $defaultOgImage)">

    <!-- Twitter Card SEO -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Al-Qur\'an Online | Quran NU Wajak')">
    <meta name="twitter:description" content="@yield('meta_description', 'Baca Al-Qur\'an 30 Juz online lengkap dengan 114 surah, teks Arab Utsmani, transliterasi Latin, terjemahan Bahasa Indonesia, Doa Harian, Wirid & Kitab Maulid Nabi.')">
    <meta name="twitter:image" content="@yield('og_image', $defaultOgImage)">
    
    <script>
        (function() {
            try {
                var s = localStorage.getItem('quran_reader_settings');
                if (s && JSON.parse(s).theme === 'dark') {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>
    
    <!-- Fonts: OMAR (Arabic) via Islami API CDN + Inter (Latin UI) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Inter for UI text (same as main site) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Arabic fonts: OMAR (primary) + Amiri & Scheherazade (fallbacks) -->
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Scheherazade+New:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* OMAR & LPMQ Arabic Fonts (Local WOFF2 Binaries) */
        @font-face {
            font-family: 'LPMQ Isep Misbah';
            src: url('/vendor/quran/fonts/lpmq-isep-misbah.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Omar';
            src: url('/vendor/quran/fonts/omar.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'surah-name-v2-icon';
            src: url('/vendor/quran/fonts/surah-name-v2.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        .font-calligraphy {
            font-family: 'surah-name-v2-icon', 'Omar', 'Amiri', 'LPMQ Isep Misbah', sans-serif !important;
            font-style: normal;
            font-weight: normal;
            line-height: 1;
            direction: ltr;
            display: inline-block;
        }
    </style>

    <link rel="icon" href="{{ $siteFavicon ?? asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ $siteFavicon ?? asset('assets/img/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('vendor/quran/css/quran.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    @stack('styles')
</head>
<body class="quran-body antialiased">
    <!-- Navbar Quran PPRU 2 (Dedicated) -->
    <header class="sticky top-0 z-40 bg-[var(--q-surface)] border-b border-[var(--q-border)] shadow-xs transition-colors">
        <div class="quran-container h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('quran.home') }}" class="flex items-center space-x-3 space-x-reverse">
                @if (!empty($siteLogo) && !empty($siteLogoDark))
                    <!-- Light Mode Logo -->
                    <img src="{{ $siteLogo }}" alt="{{ $siteTitle ?? 'PPRU 2' }}"
                        class="h-8 lg:h-9 w-auto object-contain q-logo-light">
                    <!-- Dark Mode Logo -->
                    <img src="{{ $siteLogoDark }}" alt="{{ $siteTitle ?? 'PPRU 2' }}"
                        class="h-8 lg:h-9 w-auto object-contain q-logo-dark">
                @elseif (!empty($siteLogo))
                    <img src="{{ $siteLogo }}" alt="{{ $siteTitle ?? 'PPRU 2' }}"
                        class="h-8 lg:h-9 w-auto object-contain">
                @elseif (!empty($siteLogoDark))
                    <img src="{{ $siteLogoDark }}" alt="{{ $siteTitle ?? 'PPRU 2' }}"
                        class="h-8 lg:h-9 w-auto object-contain">
                @else
                    <div class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        📖
                    </div>
                @endif
            </a>

            <!-- Right Tools -->
            <div class="flex items-center gap-1.5">
                <!-- Quick Search Trigger -->
                <button type="button" class="js-open-search p-2 rounded-lg text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] transition-colors" title="Cari Surah">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Bookmarks List Trigger -->
                <button type="button" class="js-open-bookmarks p-2 rounded-lg text-[var(--q-muted)] hover:text-amber-500 hover:bg-[var(--q-hover)] transition-colors" title="Daftar Bookmark">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                </button>


                <!-- Dark Mode Toggle -->
                <button type="button" class="js-toggle-theme p-2 rounded-lg text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] transition-colors" title="Ubah Tema">
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-6">
        @yield('content')
    </main>

    <!-- Minimal Footer -->
    <footer class="mt-16 border-t border-[var(--q-border)] py-8 text-center text-sm text-[var(--q-muted)]">
        <div class="quran-container">
            <p>© {{ date('Y') }} <strong>Al-Qur'an Online {{ $siteTitle ?? 'PPRU 2' }}</strong></p>
            <p class="text-xs mt-1 text-slate-400 dark:text-slate-500">Data bersumber dari Islami API & Kemenag RI. Memudahkan tadarus dan kajian santri.</p>
        </div>
    </footer>

    <!-- Modals & Drawers -->
    @include('quran::components.search-modal')
    @include('quran::components.settings-drawer')
    @include('quran::components.share-modal')
    @include('quran::components.bookmarks-modal')
    @include('quran::components.audio-player')

    <script src="{{ asset('vendor/quran/js/quran.js') }}"></script>
    @stack('scripts')
</body>
</html>
