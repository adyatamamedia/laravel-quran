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

    $siteTitleText = $siteTitle ?? ($settings['site_title'] ?? ($settings['site_name'] ?? (config('quran.site_title') ?? (config('app.name') && config('app.name') !== 'Laravel' ? config('app.name') : 'Quran Laravel Pack'))));
    $siteTaglineText = $siteTagline ?? ($settings['site_tagline'] ?? ($settings['site_description'] ?? 'Portal Al-Qur\'an 30 Juz online lengkap dengan 114 surah, transliterasi Latin, terjemahan Kemenag RI, Tahlil, Wirid & Doa Harian, serta Kitab Maulid Nabi Muhammad SAW.'));
    
    $siteFaviconUrl = $resolveMediaUrl($siteFavicon ?? ($settings['site_favicon'] ?? null)) ?? asset('assets/img/favicon.png');
    $siteKeywordsText = $siteKeywords ?? ($settings['site_keywords'] ?? ($settings['meta_keywords'] ?? 'Quran Online, Al-Quran 30 Juz, Terjemahan Quran, Baca Quran, Tahlil Yasin, Doa Harian, Wirid, Kitab Maulid'));
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "Al-Qur'an 30 Juz Online & Terjemahan") | {{ $siteTitleText }}</title>
    <meta name="description" content="@yield('meta_description', $siteTaglineText)">
    <meta name="keywords" content="@yield('meta_keywords', $siteKeywordsText)">
    <meta name="author" content="{{ $siteTitleText }}">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    
    <!-- Open Graph / Facebook SEO -->
    <meta property="og:site_name" content="{{ $siteTitleText }}">
    <meta property="og:title" content="@yield('title', 'Al-Qur\'an Online') | {{ $siteTitleText }}">
    <meta property="og:description" content="@yield('meta_description', $siteTaglineText)">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="id_ID">
    @php($defaultOgImage = $resolveMediaUrl($siteOgImage ?? ($settings['og_image'] ?? null)) ?? $logoLight ?? asset('assets/img/logo.png'))
    <meta property="og:image" content="@yield('og_image', $defaultOgImage)">

    <!-- Twitter Card SEO -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Al-Qur\'an Online') | {{ $siteTitleText }}">
    <meta name="twitter:description" content="@yield('meta_description', $siteTaglineText)">
    <meta name="twitter:image" content="@yield('og_image', $defaultOgImage)">
    
    <!-- JSON-LD Structured Data Schema -->
    <script type="application/ld+json">
    {
      "{{ '@' }}context": "https://schema.org",
      "@type": "WebSite",
      "name": "{{ $siteTitleText }} - Al-Qur'an Online",
      "url": "{{ url('/') }}",
      "description": "{{ $siteTaglineText }}",
      "inLanguage": "id-ID",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "{{ route('quran.search') }}?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
    </script>
    @yield('structured_data')

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
    
    <!-- Preload Primary Arabic Font (Omar) for Instant Rendering on Deploy -->
    <link rel="preload" href="{{ asset('vendor/quran/fonts/omar.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('vendor/quran/fonts/surah-name-v2.ttf') }}" as="font" type="font/ttf" crossorigin>

    <!-- Inter for UI text -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Arabic fonts: Amiri & Scheherazade (fallbacks) -->
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Scheherazade+New:wght@400;700&display=swap" rel="stylesheet">
    
    <link rel="icon" href="{{ $siteFaviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $siteFaviconUrl }}">

    <link rel="stylesheet" href="{{ asset('vendor/quran/css/quran.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        quran: {
                            base: '#e6ece6',
                            emerald: '#1b594a',
                            sage: '#598456',
                            gold: '#baae4f',
                            ash: '#b4c0b0',
                            slate: '#7c9c8a',
                        },
                        emerald: {
                            50: '#f0f5f1',
                            100: '#e1ebe4',
                            200: '#c5d8cb',
                            300: '#9dbfa6',
                            400: '#72a37d',
                            500: '#598456',
                            600: '#1b594a',
                            700: '#15483b',
                            800: '#113a30',
                            900: '#0e2f27',
                            950: '#081c17',
                        },
                        amber: {
                            300: '#e2d788',
                            400: '#baae4f',
                            500: '#baae4f',
                            600: '#968b37',
                        }
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="quran-body antialiased flex flex-col min-h-screen">
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
                        <div class="w-8 h-8 rounded-xl bg-[#1b594a] flex items-center justify-center text-white font-bold text-base shadow-xs">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-sm text-[var(--q-text)]">{{ $siteTitleText }}</span>
                    </div>
                @endif
            </a>

            <!-- Right Tools -->
            <div class="flex items-center gap-1.5">
                <!-- Quick Search Trigger -->
                <button type="button" class="js-open-search p-2 rounded-lg text-[var(--q-muted)] hover:text-[#1b594a] dark:hover:text-[#baae4f] hover:bg-[#598456]/15 transition-colors" title="Cari Surah">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Bookmarks List Trigger -->
                <button type="button" class="js-open-bookmarks p-2 rounded-lg text-[var(--q-muted)] hover:text-[#baae4f] hover:bg-[#598456]/15 transition-colors" title="Daftar Bookmark">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                </button>

                <!-- Dark Mode Toggle -->
                <button type="button" class="js-toggle-theme p-2 rounded-lg text-[var(--q-muted)] hover:text-[#1b594a] dark:hover:text-[#baae4f] hover:bg-[#598456]/15 transition-colors" title="Ubah Tema">
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
    <main class="flex-grow py-6">
        @yield('content')
    </main>

    <!-- Dynamic Responsive Footer -->
    <footer class="mt-16 bg-[var(--q-surface)] border-t border-[var(--q-border)] text-[var(--q-muted)] transition-colors">
        <div class="quran-container py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Col 1: Brand & Tagline -->
                <div class="md:col-span-2 space-y-3">
                    <a href="{{ route('quran.home') }}" class="inline-flex items-center gap-3">
                        @if (!empty($logoLight) && !empty($logoDark))
                            <img src="{{ $logoLight }}" alt="{{ $siteTitleText }}" class="h-8 lg:h-9 w-auto object-contain q-logo-light">
                            <img src="{{ $logoDark }}" alt="{{ $siteTitleText }}" class="h-8 lg:h-9 w-auto object-contain q-logo-dark">
                        @elseif (!empty($logoLight))
                            <img src="{{ $logoLight }}" alt="{{ $siteTitleText }}" class="h-8 lg:h-9 w-auto object-contain">
                        @elseif (!empty($logoDark))
                            <img src="{{ $logoDark }}" alt="{{ $siteTitleText }}" class="h-8 lg:h-9 w-auto object-contain">
                        @else
                            <div class="w-8 h-8 rounded-xl bg-[#1b594a] flex items-center justify-center text-white font-bold text-base shadow-xs">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-base text-[var(--q-text)]">{{ $siteTitleText }}</span>
                        @endif
                    </a>
                    <p class="text-xs sm:text-sm text-[var(--q-muted)] leading-relaxed max-w-md">
                        {{ $siteTaglineText }}
                    </p>
                </div>

                <!-- Col 2: Layanan Quran -->
                <div>
                    <h3 class="font-semibold text-xs uppercase tracking-wider text-[var(--q-text)] mb-3">Layanan Islami</h3>
                    <ul class="space-y-2 text-xs sm:text-sm">
                        <li>
                            <a href="{{ route('quran.home') }}" class="hover:text-[#598456] transition-colors">Al-Qur'an 30 Juz</a>
                        </li>
                        <li>
                            <a href="{{ route('quran.tahlil') }}" class="hover:text-[#598456] transition-colors">Tahlil & Yasin</a>
                        </li>
                        <li>
                            <a href="{{ route('quran.wirid') }}" class="hover:text-[#598456] transition-colors">Wirid & Doa Harian</a>
                        </li>
                        <li>
                            <a href="{{ route('quran.maulid') }}" class="hover:text-[#598456] transition-colors">Kitab Maulid Nabi</a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Surah Populer -->
                <div>
                    <h3 class="font-semibold text-xs uppercase tracking-wider text-[var(--q-text)] mb-3">Surah Populer</h3>
                    <ul class="space-y-2 text-xs sm:text-sm">
                        <li>
                            <a href="{{ route('quran.surah.show', ['surahSlug' => 'al-kahf']) }}" class="hover:text-[#598456] transition-colors">Surah Al-Kahf</a>
                        </li>
                        <li>
                            <a href="{{ route('quran.surah.show', ['surahSlug' => 'al-mulk']) }}" class="hover:text-[#598456] transition-colors">Surah Al-Mulk</a>
                        </li>
                        <li>
                            <a href="{{ route('quran.surah.show', ['surahSlug' => 'ar-rahman']) }}" class="hover:text-[#598456] transition-colors">Surah Ar-Rahman</a>
                        </li>
                        <li>
                            <a href="{{ route('quran.surah.show', ['surahSlug' => 'al-waqiah']) }}" class="hover:text-[#598456] transition-colors">Surah Al-Waqi'ah</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright, Action Buttons & Details -->
            <div class="pt-6 border-t border-[var(--q-border)] flex flex-col md:flex-row items-center justify-between gap-4 text-xs">
                <!-- Copyright -->
                <p class="text-center md:text-left">&copy; {{ date('Y') }} <span class="font-semibold text-[var(--q-text)]">{{ $siteTitleText }}</span>. All rights reserved.</p>

                <!-- Footer Action Buttons (Changelog & Landing Page) -->
                <div class="flex flex-wrap items-center justify-center gap-2.5">
                    <button type="button" class="js-open-changelog inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-[var(--q-border)] bg-[var(--q-surface-card)] hover:bg-[#598456]/15 hover:border-[#598456] text-[var(--q-text)] text-xs font-semibold shadow-xs transition-colors" title="Lihat Riwayat Pembaruan">
                        <svg class="w-3.5 h-3.5 text-[#1b594a] dark:text-[#baae4f]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        <span>Changelog</span>
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-[#1b594a] text-white">v2.1.1</span>
                    </button>

                    <a href="https://aswaja.tama.my.id/laravel-quran" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#1b594a] hover:bg-[#13463a] text-white text-xs font-semibold shadow-xs transition-colors" title="Buka Landing Page Package">
                        <span>Landing Page Paket</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" y1="14" x2="21" y2="3"></line>
                        </svg>
                    </a>
                </div>

                <!-- Attribution -->
                <div class="flex items-center gap-1 text-xs text-[var(--q-muted)]">
                    <span>Build &amp; Developed with</span>
                    <svg class="w-4 h-4 text-red-500 fill-red-500 shrink-0" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                    </svg>
                    <span>by. <a href="https://adyatama.id" target="_blank" rel="noopener" class="font-semibold text-[var(--q-text)] hover:text-[#598456] transition-colors">AdyatamaTECH</a></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Quick Search Modal Component -->
    @include('quran::components.search-modal')

    <!-- Bookmarks Modal Component -->
    @include('quran::components.bookmarks-modal')

    <!-- Reader Settings Drawer Component -->
    @include('quran::components.settings-drawer')

    <!-- Changelog Modal Component -->
    @include('quran::components.changelog-modal')

    <!-- Floating Global Audio Player Component -->
    @include('quran::components.audio-player')

    <!-- Dynamic Back to Top Button -->
    <button type="button" 
            id="quran-back-to-top" 
            class="fixed bottom-6 right-6 z-40 p-3 rounded-full bg-[#1b594a]/90 hover:bg-[#13463a] text-white shadow-2xl border border-[#baae4f]/50 backdrop-blur-md transition-all duration-300 transform translate-y-8 opacity-0 pointer-events-none hover:scale-110 active:scale-95 group" 
            title="Kembali ke atas"
            aria-label="Kembali ke atas">
        <svg class="w-5 h-5 transition-transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M18 15l-6-6-6 6"/>
        </svg>
    </button>

    <!-- Quran Core JS -->
    <script src="{{ asset('vendor/quran/js/quran.js') }}"></script>
    @stack('scripts')
</body>
</html>
