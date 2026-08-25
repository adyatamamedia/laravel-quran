# Laravel Quran Package

[![Latest Version](https://img.shields.io/badge/version-1.1.0-blue.svg)](https://github.com/adyatamamedia/laravel-quran)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/PHP-%5E8.2%20%7C%20%5E8.3%20%7C%20%5E8.4-777bb4.svg)](https://php.net)
[![Laravel Support](https://img.shields.io/badge/Laravel-10.x%20%7C%2011.x%20%7C%2012.x-ff2d20.svg)](https://laravel.com)

Package modular Laravel siap pakai untuk layanan **Al-Qur'an 30 Juz (114 Surah)**, susunan **Tahlil & Surat Yasin**, kumpulan **Wirid & Doa Maktubah**, serta **Kitab Maulid Nabi**.

Package ini dirancang **multi-project ready**, memungkinkan setiap project Laravel melakukan kustomisasi tampilan (Blade views), rute URL/subdomain, kustomisasi endpoint API, filter kategori, hingga penggantian sumber data (backend driver) secara mandiri.

---

## 📑 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Kustomisasi Backend & API](#-kustomisasi-backend--api)
  - [Level 1: Konfigurasi Endpoint & Query Filter](#level-1-konfigurasi-endpoint--query-filter)
  - [Level 2: Filter Kategori pada Service](#level-2-filter-kategori-pada-service)
  - [Level 3: Mengganti Backend Total (Driver Pattern)](#level-3-mengganti-backend-total-driver-pattern)
- [Kustomisasi Tampilan (Views & Layouts)](#-kustomisasi-tampilan-views--layouts)
- [Daftar Rute & Endpoint](#-daftar-rute--endpoint)
- [Asset & Audio Player](#-asset--audio-player)
- [Troubleshooting & Maintenance](#-troubleshooting--maintenance)
- [Lisensi](#-lisensi)

---

## 🚀 Fitur Utama

- 📖 **Al-Qur'an 30 Juz Lengkap**: Teks Arab Utsmani, transliterasi Latin, dan terjemahan resmi Bahasa Indonesia (Kemenag RI).
- 🔊 **Audio Player Qari**: Pemutar audio per ayat interaktif dan continuous audio player per surah (Misyari Rasyid).
- 🧎 **Tahlil & Surat Yasin**: Bacaan tahlil lengkap dilengkapi teks Arab, transliterasi, dan Surat Yasin interaktif.
- 🤲 **Wirid & Doa**: Kumpulan dzikir ba'da shalat maktubah, Rotib Al-Haddad, Ratib Al-Attas, Hizib, dan doa harian.
- 📗 **Kitab Maulid**: Naskah Kitab Maulid Simtudduror, Maulid Diba', Maulid Barzanji, dan Qasidah Burdah.
- 🔖 **Bookmark & Last Read**: Penyimpanan penanda ayat dan riwayat bacaan otomatis berbasis browser storage.
- 🌓 **Dark / Light Mode**: Mendukung mode gelap dan terang responsif untuk kenyamanan membaca di malam hari.
- 🔍 **Pencarian Cepat**: Modal search berbasis surah, nomor ayat, juz, atau arti terjemahan.

---

## 💻 Persyaratan Sistem

- **PHP**: `^8.2`, `^8.3`, atau `^8.4`
- **Laravel**: `^10.0`, `^11.0`, atau `^12.0`
- Ekstensi PHP: `cURL`, `JSON`, `Mbstring`

---

## 📦 Instalasi

### 1. Tambahkan VCS Repository di `composer.json` Project Anda

Karena package ini berada di repository GitHub private, tambahkan entri `repositories` pada file `composer.json` di project target:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/adyatamamedia/laravel-quran.git"
    }
]
```

### 2. Install Package via Composer

Jalankan perintah berikut di terminal:

```bash
composer require adyatama/laravel-quran
```

### 3. Jalankan Artisan Install

```bash
php artisan quran:install
```

Perintah di atas secara otomatis akan:
- Mem-publish file konfigurasi ke `config/quran.php`.
- Mem-publish asset CSS & JS player ke `public/vendor/quran/`.
- Mem-publish file font kaligrafi (LPMQ & Omar) ke `public/vendor/quran/fonts/`.
- Mem-publish salinan views ke `resources/views/vendor/quran/`.
- Mengaktifkan rute Al-Qur'an di `/quran`.

---

## ⚙️ Konfigurasi

Setelah instalasi, file konfigurasi tersedia di `config/quran.php`. Anda dapat menyesuaikannya langsung atau melalui file `.env`:

```env
# Mode Rute: 'prefix' (misal: domain.com/quran) atau 'domain' (misal: quran.domain.com)
QURAN_ROUTING_MODE=prefix
QURAN_ROUTE_PREFIX=quran
QURAN_DOMAIN=

# Konfigurasi Backend & Islami API
ISLAMI_API_URL=https://aswaja.tama.my.id/api/v1
ISLAMI_API_KEY=
ISLAMI_API_CACHE=true
ISLAMI_API_TIMEOUT=10
QURAN_SERVICE_CLASS=Adyatama\Quran\Services\IslamiApi\QuranService
QURAN_CONTENT_SERVICE_CLASS=Adyatama\Quran\Services\IslamiApi\ContentService
```

---

## 🔌 Kustomisasi Backend & API

Package ini dirancang berbasis interface (`QuranServiceInterface`), sehingga Anda memiliki kebebasan penuh mengatur sumber data backend di setiap project.

### Level 1: Konfigurasi Endpoint & Query Filter

Anda dapat menyesuaikan endpoint path, default query parameters (kategori/sumber), serta custom HTTP headers langsung di `config/quran.php`:

```php
'api' => [
    'url' => env('ISLAMI_API_URL', 'https://api-khusus.domain.com/v1'),
    
    // Custom Endpoint per modul
    'endpoints' => [
        'surahs' => 'v1/quran/surahs',
        'surah'  => 'v1/quran/surahs/{number}',
        'tahlil' => 'v1/tahlil-custom',
        'wirid'  => 'v1/wirid-pesantren',
        'maulid' => 'v1/kitab-maulid',
    ],

    // Default Query Parameters (otomatis dikirim ke API)
    'default_query' => [
        'category' => env('QURAN_API_CATEGORY', 'santri_madin'),
        'source'   => 'kemenag',
        'lang'     => 'id',
    ],

    // Custom Headers (API Key, Bearer Token, Tenant ID)
    'headers' => [
        'X-Tenant-ID'   => env('QURAN_TENANT_ID', 'pesantren-01'),
        'Authorization' => 'Bearer ' . env('QURAN_API_TOKEN'),
    ],
],
```

Semua request bawaan menggunakan path dari `endpoints`, menggabungkan
`default_query`, dan mengirim `headers`. Parameter runtime akan menimpa nilai
default dengan key yang sama.

### Level 2: Filter Kategori pada Service

Di controller atau logic project Anda, Anda dapat memanggil method dengan filter kategori dinamis:

```php
use Adyatama\Quran\Contracts\QuranServiceInterface;

class KajianController extends Controller
{
    public function index(QuranServiceInterface $quran)
    {
        // Mengambil surah dengan filter kategori tertentu
        $surahs = $quran->getSurahs([
            'category' => 'juz_amma',
            'type'     => 'makkiyah'
        ]);

        return view('pages.kajian', compact('surahs'));
    }
}
```

### Level 3: Mengganti Backend Total (Driver Pattern)

Jika project tertentu ingin menggunakan database lokal (MySQL/PostgreSQL) atau sistem API internal sendiri:

1. Buat class implementasi di project Anda:
   ```php
   namespace App\Services;

   use Adyatama\Quran\Contracts\QuranServiceInterface;

   class MyLocalDatabaseQuranService implements QuranServiceInterface
   {
       public function getSurahs(array $filters = []): array
       {
           return \App\Models\Surah::where($filters)->get()->toArray();
       }

       public function getSurah(int|string $number, array $params = []): ?\Adyatama\Quran\Data\SurahData
       {
           return \App\Models\Surah::with('verses')->where('number', $number)->first();
       }

       // ... implementasikan method lainnya
   }
   ```

2. Daftarkan di `app/Providers/AppServiceProvider.php`:
   ```php
   use Adyatama\Quran\Contracts\QuranServiceInterface;
   use App\Services\MyLocalDatabaseQuranService;

   public function register(): void
   {
       $this->app->bind(QuranServiceInterface::class, MyLocalDatabaseQuranService::class);
   }
   ```
   *Controller Qur’an menggunakan `QuranServiceInterface`, sehingga driver yang hanya mengimplementasikan interface tetap dapat di-resolve.*

Untuk mengganti layanan Tahlil, Wirid, Doa, dan Maulid, implementasikan
`Adyatama\Quran\Contracts\ContentServiceInterface`, lalu ubah
`QURAN_CONTENT_SERVICE_CLASS` atau bind interface tersebut pada service provider
project Anda.

---

## 🎨 Kustomisasi Tampilan (Views & Layouts)

Untuk mengubah tampilan halaman Al-Qur'an agar menyatu dengan tema website Anda:

```bash
php artisan vendor:publish --tag=quran-views
```

File Blade akan disalin ke direktori:
```text
resources/views/vendor/quran/
├── index.blade.php              # Beranda 114 Surah
├── show.blade.php               # Reader Surah & Ayat
├── search.blade.php             # Hasil Pencarian
├── tahlil-yasin.blade.php       # Halaman Tahlil & Yasin
├── wirid-doa.blade.php          # Halaman Wirid & Doa Maktubah
├── maulid.blade.php             # Halaman Kitab Maulid
├── layouts/
│   └── quran.blade.php          # Master Layout (Header, Footer, Dark Mode)
└── components/
    ├── audio-player.blade.php   # Pemutar Audio Sticky
    ├── bookmarks-modal.blade.php# Modal Penanda Ayat
    ├── search-modal.blade.php   # Modal Quick Search
    ├── settings-drawer.blade.php# Pengaturan Ukuran Font Arab
    └── verse-item.blade.php     # Komponen Render Per-Ayat
```

---

## 🌐 Daftar Rute & Endpoint

| Metode | Endpoint URL | Nama Route (`route()`) | Deskripsi |
| :--- | :--- | :--- | :--- |
| `GET` | `/quran` | `quran.home` | Beranda daftar 114 Surah & quick nav |
| `GET` | `/quran/{surahSlug}` | `quran.surah.show` | Reader Surah (teks Arab, Latin, terjemahan, audio) |
| `GET` | `/quran/{surahSlug}/{ayah}` | `quran.verse.show` | Halaman detail per ayat tunggal |
| `GET` | `/quran/search` | `quran.search` | Halaman pencarian surah & ayat |
| `GET` | `/quran/tahlil-yasin` | `quran.tahlil` | Panduan Tahlil & Surat Yasin |
| `GET` | `/quran/wirid-doa/{slug?}` | `quran.wirid` | Wirid ba'da shalat & doa harian |
| `GET` | `/quran/maulid` | `quran.maulid` | Kumpulan naskah Kitab Maulid Nabi |

---

## 🔊 Asset & Audio Player

- **CSS & JS**: Diposisikan di `public/vendor/quran/` tanpa memerlukan compile Vite tambahan.
- **Font Kaligrafi**: Font Arab `LPMQ Isep Misbah` dan `Omar` disertakan otomatis untuk rendering kaligrafi Utsmani yang rapi di semua perangkat.
- **Audio Reciter**: Menggunakan streaming audio high-quality bersumber dari CDN resmi Islami API.

---

## 🛠️ Troubleshooting & Maintenance

- **Memperbarui Versi Package**:
  ```bash
  composer update adyatama/laravel-quran
  ```
- **Membersihkan Cache API Al-Qur'an**:
  ```bash
  php artisan cache:clear
  ```
- **Memperbarui Asset CSS/JS Terbaru**:
  ```bash
  php artisan vendor:publish --tag=quran-assets --force
  ```

---

## 📄 Lisensi

Package ini dirilis di bawah lisensi [MIT License](LICENSE).  
Dikembangkan dan dikelola oleh **[Adyatama Media](https://github.com/adyatamamedia)**.
