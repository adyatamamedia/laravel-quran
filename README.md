# Laravel Quran Package

[![Latest Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com/adyatamamedia/laravel-quran)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Package modular Laravel untuk membaca **Al-Qur'an 30 Juz (114 Surah)**, susunan **Tahlil & Surat Yasin**, kumpulan **Wirid & Doa Maktubah**, serta **Kitab Maulid Nabi**.

Menggunakan sumber data terpusat dari **Islami API** (`https://aswaja.tama.my.id/api/v1`) dengan sistem **multi-tier caching** dan **offline fallback** agar performa sangat cepat dan tahan downtime.

---

## 🚀 Fitur Utama

- 📖 **Al-Qur'an 30 Juz Lengkap**: Teks Arab Utsmani, transliterasi Latin, dan terjemahan resmi Kemenag RI.
- 🔊 **Audio Player Qari**: Pemutar audio per ayat dan continuous play per surah.
- 🧎 **Tahlil & Yasin**: Susunan doa dan bacaan tahlil lengkap beserta Surat Yasin interaktif.
- 🤲 **Wirid & Doa**: Kumpulan wirid ba'da shalat fardhu, rotib, hisib, dan doa harian.
- 📗 **Kitab Maulid**: Naskah Maulid Simtudduror, Diba', Barzanji, dll.
- 🔖 **Bookmark & Last Read**: Penyimpanan penanda ayat dan riwayat bacaan otomatis (LocalStorage).
- 🌓 **Dark Mode Support**: Mode gelap dan terang yang nyaman untuk membaca di malam hari.
- 🔍 **Pencarian Cepat**: Modal search untuk mencari surah, juz, atau nomor ayat.

---

## 📦 Instalasi

### 1. Tambahkan Repository ke `composer.json` Project Anda

Karena ini adalah private repository, tambahkan bagian `repositories` di `composer.json` project Laravel Anda:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/adyatamamedia/laravel-quran.git"
    }
]
```

### 2. Install via Composer

Jalankan perintah berikut di terminal:

```bash
composer require adyatama/laravel-quran
```

### 3. Jalankan Command Installasi

```bash
php artisan quran:install
```

Perintah ini akan secara otomatis mem-publish:
- File konfigurasi ke `config/quran.php`
- Asset CSS & JS ke `public/vendor/quran/`
- Asset Font Arab (LPMQ & Omar) ke `public/vendor/quran/fonts/`

---

## ⚙️ Konfigurasi (`config/quran.php`)

Anda dapat menyesuaikan preferensi URL dan fitur pada file `config/quran.php`:

```php
return [
    // Mode URL: 'prefix' (misal: yourdomain.com/quran) atau 'domain' (misal: quran.yourdomain.com)
    'routing_mode' => env('QURAN_ROUTING_MODE', 'prefix'),
    'prefix'       => env('QURAN_ROUTE_PREFIX', 'quran'),
    'domain'       => env('QURAN_DOMAIN', null),
    'middleware'   => ['web'],

    // Konfigurasi Islami API & Caching
    'api' => [
        'url'             => env('ISLAMI_API_URL', 'https://aswaja.tama.my.id/api/v1'),
        'key'             => env('ISLAMI_API_KEY', ''),
        'timeout'         => 10,
        'cache_enabled'   => true,
    ],

    // Toggle Fitur
    'features' => [
        'tahlil' => true,
        'wirid'  => true,
        'maulid' => true,
        'audio'  => true,
        'tafsir' => true,
    ],
];
```

---

## 🌐 Endpoint Rute yang Tersedia

Secara default, rute berikut akan langsung aktif:

| Endpoint | Nama Route | Deskripsi |
| :--- | :--- | :--- |
| `GET /quran` | `quran.home` | Beranda daftar 114 Surah & quick search |
| `GET /quran/{surahSlug}` | `quran.surah.show` | Reader ayat, terjemahan, tafsir & audio |
| `GET /quran/{surahSlug}/{ayah}` | `quran.verse.show` | Halaman detail per ayat tunggal |
| `GET /quran/search` | `quran.search` | Pencarian surah & ayat |
| `GET /quran/tahlil-yasin` | `quran.tahlil` | Panduan Tahlil & Surat Yasin |
| `GET /quran/wirid-doa/{slug?}` | `quran.wirid` | Dzikir, wirid shalat & doa harian |
| `GET /quran/maulid` | `quran.maulid` | Kumpulan naskah Kitab Maulid |

---

## 🎨 Kustomisasi Tampilan (Views)

Jika Anda ingin memodifikasi tampilan Blade, jalankan:

```bash
php artisan vendor:publish --tag=quran-views
```

File view akan disalin ke `resources/views/vendor/quran/` dan siap Anda edit sesuai tema website.

---

## 📄 Lisensi

Dikembangkan oleh **Adyatama Media**. Lisensi [MIT](LICENSE).
