@php
    $resolveMediaUrl = function($path) {
        if (empty($path)) return null;
        if (is_string($path) && (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//'))) {
            return $path;
        }
        if (function_exists('media_url')) {
            $media = media_url($path);
            if ($media) return $media;
        }
        if (str_starts_with($path, 'uploads/') && !file_exists(public_path($path))) {
            return url('media/' . $path);
        }
        return asset($path);
    };

    $logoLight = $resolveMediaUrl($siteLogo ?? ($settings['site_logo'] ?? null));
    $logoDark = $resolveMediaUrl($siteLogoDark ?? ($settings['site_logo_dark'] ?? null));

    $siteTitleText = $siteTitle ?? ($settings['site_title'] ?? ($settings['site_name'] ?? config('app.name', 'Al-Qur\'an Online')));
    
    $siteFaviconUrl = $resolveMediaUrl($siteFavicon ?? ($settings['site_favicon'] ?? null)) ?? asset('assets/img/favicon.png');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Al-Qur\'an Online | ' . $siteTitleText)</title>
    <meta name="description" content="@yield('meta_description', 'Baca Al-Qur\'an 30 Juz online lengkap dengan 114 surah, teks Arab Utsmani, transliterasi Latin, terjemahan Bahasa Indonesia, Doa Harian, Wirid & Kitab Maulid Nabi.')">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph / Facebook SEO -->
    <meta property="og:site_name" content="{{ $siteTitleText }}">
    <meta property="og:title" content="@yield('title', 'Al-Qur\'an Online | ' . $siteTitleText)">
    <meta property="og:description" content="@yield('meta_description', 'Baca Al-Qur\'an 30 Juz online lengkap dengan 114 surah, teks Arab Utsmani, transliterasi Latin, terjemahan Bahasa Indonesia, Doa Harian, Wirid & Kitab Maulid Nabi.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="id_ID">
    @php($defaultOgImage = $resolveMediaUrl($siteOgImage ?? ($settings['og_image'] ?? null)) ?? $logoLight ?? asset('assets/img/logo.png'))
    <meta property="og:image" content="@yield('og_image', $defaultOgImage)">

    <!-- Twitter Card SEO -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Al-Qur\'an Online | ' . $siteTitleText)">
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

    <link rel="icon" href="{{ $siteFaviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $siteFaviconUrl }}">

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
    <!-- Navbar Quran (Adaptive Logo & Title) -->
    <header class="sticky top-0 z-40 bg-[var(--q-surface)] border-b border-[var(--q-border)] shadow-xs transition-colors">
        <div class="quran-container h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('quran.home') }}" class="flex items-center space-x-3">
                @if (!empty($logoLight) && !empty($logoDark))
                    <!-- Light Mode Logo -->
                    <img src="{{ $logoLight }}" alt="{{ $siteTitleText }}"
                        class="h-8 lg:h-9 w-auto object-contain q-logo-light">
                    <!-- Dark Mode Logo -->
                    <img src="{{ $logoDark }}" alt="{{ $siteTitleText }}"
                        class="h-8 lg:h-9 w-auto object-contain q-logo-dark">
                @elseif (!empty($logoLight))
                    <img src="{{ $logoLight }}" alt="{{ $siteTitleText }}"
                        class="h-8 lg:h-9 w-auto object-contain">
                @elseif (!empty($logoDark))
                    <img src="{{ $logoDark }}" alt="{{ $siteTitleText }}"
                        class="h-8 lg:h-9 w-auto object-contain">
                @else
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-bold text-base shadow-xs">
                            📖
                        </div>
                        <span class="font-bold text-sm text-[var(--q-text)]">{{ $siteTitleText }}</span>
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

    <!-- Main Content Injection -->
    <main class="min-h-[calc(100vh-8rem)] py-6">
        @yield('content')
    </main>

    <!-- Quick Search Modal Component -->
    @include('quran::components.search-modal')

    <!-- Bookmarks Modal Component -->
    @include('quran::components.bookmarks-modal')

    <!-- Reader Settings Drawer Component -->
    @include('quran::components.settings-drawer')

    <!-- Floating Global Audio Player Component -->
    @include('quran::components.audio-player')

    <!-- Quran Core JS -->
    <script src="{{ asset('vendor/quran/js/quran.js') }}"></script>
    @stack('scripts')
</body>
</html>