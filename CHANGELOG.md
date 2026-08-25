# Changelog

All notable changes to `adyatama/laravel-quran` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [2.1.1] - 2026-08-26

### Added
- **Sistem Palet Desain 6 Warna Harmonis**:
  - Light Base / Cream Sage (`#e6ece6`) sebagai latar dasar mode terang.
  - Deep Forest Emerald (`#1b594a`) untuk brand utama, header gradient, dan tombol aksi (kontras >7:1 lolos standar WCAG AAA).
  - Moss Sage Green (`#598456`) untuk tab aktif, badge kategori, dan transliterasi Latin.
  - Islamic Warm Gold (`#baae4f`) untuk kaligrafi surat, penanda nomor ayat (*verse ring*), dan ikon bookmark.
  - Light Ash Sage (`#b4c0b0`) untuk garis pembatas/divider dan border kartu.
  - Muted Slate Sage (`#7c9c8a`) untuk teks sekunder dan metadata.
- **Tombol Floating Back to Top Dinamis (*Smart Auto-Fade*)**:
  - Otomatis tersembunyi saat berada di bagian paling atas halaman (`scrollY < 300`).
  - Muncul dengan animasi transisi halus saat pengguna membaca dan scroll ke bawah.
  - Fitur cerdas *idle detection*: otomatis memudar (*fade-out*) setelah 2.5 detik berhenti scroll agar tidak menutupi ayat bacaan.
  - Reaktif kembali seketika saat pengguna melanjutkan scrolling atau hover mouse.
  - Navigasi kembali ke puncak halaman dengan *smooth scrolling*.
- **Aset Visual Layanan & Kaligrafi HD**:
  - Ikon visual 3D untuk 4 layanan utama: Al-Qur'an, Tahlil & Yasin, Wirid & Doa, dan Kitab Maulid Nabi.
  - Integrasi font kaligrafi nama surah `surah-name-v2.ttf` untuk seluruh 114 surah.
- **Redesain Modal Pencarian (*Ultra-Compact & Mobile Optimized*)**:
  - Tata letak yang dioptimalkan untuk mobile (`max-h-[85vh]` dengan header input ramping).
  - Filter pills kategori cepat (Semua, Surah, Doa, Wirid, Maulid) dengan class `.q-tab-btn`.
- **Preload Font Arab Utama (Omar)**:
  - Deklarasi `<link rel="preload">` untuk file `omar.woff2` pada `<head>` guna menjamin font `Omar` langsung aktif saat deployment di environment manapun.
- **Tombol Changelog Modal & Link Landing Page di Footer**:
  - Modal Changelog interaktif yang menampilkan riwayat pembaruan dan rilis paket.
  - Tombol tautan langsung ke Landing Page resmi paket di `https://aswaja.tama.my.id/laravel-quran`.
- **Portal Al-Qur'an 30 Juz & Layanan ASWAJA**:
  - Modul Tahlil lengkap dengan doa arwah.
  - Modul Wirid & Doa Harian terstruktur per kategori.
  - Modul Kitab Maulid Nabi Muhammad SAW (Simtudduror, Ad-Diba'i, Ad-Dhiya'ul Lami').
  - Pemutar audio murattal 10 Qari dunia dan Tafsir Kemenag RI ringkas per ayat.

### Fixed
- **Tipografi & Sambungan Huruf Arab**:
  - Menghapus aturan `word-spacing` yang sebelumnya menyebabkan celah antar-huruf (*split glyph*).
  - Mengunci `letter-spacing: 0 !important` dan `word-spacing: normal !important`.
  - Mengaktifkan fitur OpenType Ligature (`liga`, `calt`, `ccmp`, `locl`) dan `text-rendering: optimizeLegibility`.
  - Menaikkan `line-height` kaligrafi menjadi `1.45` dengan `overflow: visible` pada container kartu surah untuk mencegah pemotongan tanda harakat atas/bawah.
- **Stabilitas Tab Filter Modal Pencarian**:
  - Memperbaiki efek *flicker* klik ganda pada desktop dengan dedicated state `.q-tab-btn.is-active`.
- **Standardisasi Ikon**:
  - Mengganti seluruh karakter emoji di UI, modal, dan command installer dengan ikon SVG Lucide profesional.
- **Linter & Compatibility**:
  - Memperbaiki linter syntax error pada blade header dan menambahkan standar CSS `line-clamp: 4`.

---

## [1.0.0] - 2026-08-26
- Initial release of Laravel Quran Package.
