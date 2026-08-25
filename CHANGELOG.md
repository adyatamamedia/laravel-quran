# Changelog

All notable changes to `adyatama/laravel-quran` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.0.0] - 2026-08-26

### Added
- **Portal Al-Qur'an 30 Juz Lengkap**: 114 surah dengan teks Arab Utsmani, transliterasi Latin, dan terjemahan resmi Kemenag RI.
- **Modul Tahlil & Yasin**: Rangkaian bacaan Tahlil lengkap, doa arwah, serta pembaca Surat Yasin interaktif.
- **Wirid & Doa Harian**: Kumpulan doa keseharian berdasarkan kategori (rezeki, kesehatan, perlindungan, dll.) serta koleksi wirid/hizib/ratib para ulama ASWAJA.
- **Kitab Maulid Nabi Muhammad SAW**: Teks lengkap Maulid Simtudduror, Maulid Ad-Diba'i, dan Maulid Ad-Dhiya'ul Lami'.
- **Pemutar Audio Murattal Global & Per-Ayat**: Pemutar audio sticky bar dengan pilihan 10 Qari ternama dunia (Misyari Rasyid, As-Sudais, Al-Ghamdi, Minshawi, Husary, Abdul Basit, dll.).
- **Tafsir Kemenag RI**: Penjelasan tafsir ringkas per ayat yang dapat dibuka-tutup.
- **Pencarian Cepat Multi-Kategori (*Compact & Mobile Friendly*)**: Modal pencarian instan untuk Surah, Doa, Wirid, dan Kitab Maulid.
- **Sistem Bookmark & Terakhir Dibaca (*Last Read*)**: Penyimpanan bookmark ayat dan penanda bacaan terakhir otomatis berbasis browser `localStorage`.
- **Pengaturan Tampilan Pembaca (*Settings Drawer*)**: Slider ukuran font Arab, toggle transliterasi Latin, toggle terjemahan, dan pemilihan Qari murattal.
- **Sistem Tema 6 Warna Palet Kustom**: Harmonisasi warna desain UI (`#e6ece6`, `#1b594a`, `#598456`, `#baae4f`, `#b4c0b0`, `#7c9c8a`) dengan standar kontras WCAG AAA dan Dark Mode.
- **Aset Ikon Layanan & Kaligrafi**: Ikon visual 3D untuk Al-Quran, Tahlil, Wirid, Maulid, serta font kaligrafi nama surah.
- **Artisan Installer**: Command `php artisan quran:install` untuk mempublish konfigurasi, views, dan aset statis sekali jalan.

### Fixed
- Optimasi tipografi dan *line-height* font kaligrafi serta huruf Arab untuk mencegah pemotongan glyph (*clipping*) dan menjaga kesinambungan harakat.
- Mengeliminasi efek *flicker* klik ganda pada tab filter modal pencarian di desktop dengan class `.q-tab-btn`.
- Penggantian seluruh karakter emoji dengan ikon vektor SVG Lucide yang konsisten dan profesional.

---
