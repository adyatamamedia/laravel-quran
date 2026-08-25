<div id="quran-changelog-modal" class="fixed inset-0 z-50 hidden flex items-start justify-center pt-8 sm:pt-16 px-4">
    <!-- Backdrop -->
    <div class="js-close-changelog fixed inset-0 quran-modal-backdrop"></div>

    <!-- Modal Card -->
    <div class="relative w-full max-w-lg bg-[var(--q-surface)] rounded-2xl shadow-2xl border border-[var(--q-border)] p-5 z-10 flex flex-col max-h-[85vh]">
        <!-- Header -->
        <div class="flex items-center justify-between pb-3.5 border-b border-[var(--q-border)] shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-[#1b594a] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-sm sm:text-base text-[var(--q-text)] leading-tight">Changelog Paket</h3>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#1b594a] text-white">v2.1.1</span>
                    </div>
                    <p class="text-[11px] text-[var(--q-muted)]">Riwayat pembaruan & rilis Laravel Quran</p>
                </div>
            </div>
            <button type="button" class="js-close-changelog text-[var(--q-muted)] hover:text-[var(--q-text)] p-1 rounded-lg hover:bg-[var(--q-hover)] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Changelog Content Body (Scrollable) -->
        <div class="overflow-y-auto py-3 space-y-4 text-xs pr-1 flex-1">
            <!-- Release v2.1.1 -->
            <div class="p-3.5 rounded-xl bg-[var(--q-hover)]/60 border border-[var(--q-border)] space-y-2.5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-sm text-[var(--q-text)]">Versi 2.1.1</span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-[#598456]/20 text-[#1b594a] dark:text-[#baae4f]">Terbaru</span>
                    </div>
                    <span class="text-[10px] text-[var(--q-muted)]">26 Agustus 2026</span>
                </div>

                <!-- Added List -->
                <div>
                    <span class="inline-block font-bold text-[10px] uppercase tracking-wider text-emerald-700 dark:text-emerald-400 mb-1">
                        ✨ Fitur Baru & Desain:
                    </span>
                    <ul class="list-disc list-inside space-y-1 text-[var(--q-text)] text-[11px] leading-relaxed">
                        <li><strong>Tombol Back to Top Cerdas:</strong> Auto-hide di puncak halaman & auto-fade saat idle membaca.</li>
                        <li><strong>Sistem Palet 6 Warna Kustom:</strong> Desain harmonis dengan rasio kontras WCAG AAA & mode gelap.</li>
                        <li><strong>Aset Visual 3D & Kaligrafi HD:</strong> Ikon 3D untuk 4 layanan utama dan kaligrafi surat.</li>
                        <li><strong>Redesain Modal Search Compact:</strong> Pencarian instan yang super ringkas dan responsif di mobile.</li>
                        <li><strong>Preload Font Arab (Omar):</strong> Jaminan font Omar langsung termuat saat pertama kali diakses.</li>
                        <li><strong>Portal Lengkap:</strong> Al-Qur'an 30 Juz, Tahlil, Yasin, Wirid, Doa Harian, dan Kitab Maulid Nabi.</li>
                    </ul>
                </div>

                <!-- Fixed List -->
                <div>
                    <span class="inline-block font-bold text-[10px] uppercase tracking-wider text-amber-700 dark:text-amber-400 mb-1">
                        🛠️ Perbaikan & Stabilitas:
                    </span>
                    <ul class="list-disc list-inside space-y-1 text-[var(--q-text)] text-[11px] leading-relaxed">
                        <li>Perbaikan kesinambungan huruf Arab dan line-height kaligrafi agar tidak terpotong.</li>
                        <li>Eliminasi flicker tombol filter search modal di layar desktop.</li>
                        <li>Standardisasi seluruh icon menggunakan SVG Lucide tanpa emoji.</li>
                    </ul>
                </div>
            </div>

            <!-- Release v1.0.0 -->
            <div class="p-3.5 rounded-xl bg-[var(--q-hover)]/30 border border-[var(--q-border)] space-y-1.5 opacity-80">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-xs text-[var(--q-text)]">Versi 1.0.0</span>
                    <span class="text-[10px] text-[var(--q-muted)]">26 Agustus 2026</span>
                </div>
                <p class="text-[11px] text-[var(--q-muted)]">Rilis stabil awal paket Laravel Quran.</p>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="pt-3 border-t border-[var(--q-border)] flex items-center justify-between gap-2 shrink-0">
            <a href="https://aswaja.tama.my.id/laravel-quran" 
               target="_blank" 
               rel="noopener noreferrer"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#1b594a] hover:bg-[#13463a] text-white text-xs font-semibold shadow-xs transition-colors">
                <span>Landing Page Paket</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" y1="14" x2="21" y2="3"></line>
                </svg>
            </a>

            <button type="button" class="js-close-changelog px-3.5 py-1.5 rounded-lg bg-[var(--q-hover)] text-[var(--q-text)] hover:bg-[var(--q-border)]/50 text-xs font-semibold transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>
