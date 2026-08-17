<!-- Bookmarks List Modal -->
<div id="quran-bookmarks-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="js-close-bookmarks fixed inset-0 quran-modal-backdrop"></div>

    <!-- Dialog Card -->
    <div class="relative w-full max-w-md bg-[var(--q-surface)] rounded-2xl shadow-2xl border border-[var(--q-border)] p-6 z-10">
        <!-- Header -->
        <div class="flex items-center justify-between pb-3.5 border-b border-[var(--q-border)] mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 font-bold">
                    ⭐️
                </div>
                <div>
                    <h3 class="font-bold text-base text-[var(--q-text)] leading-tight">Daftar Bookmark</h3>
                    <p class="text-xs text-[var(--q-muted)]">Ayat yang Anda tandai</p>
                </div>
            </div>
            <button type="button" class="js-close-bookmarks text-[var(--q-muted)] hover:text-[var(--q-text)] p-1 text-lg font-bold">
                ✕
            </button>
        </div>

        <!-- Bookmarks List Container -->
        <div id="bookmarks-modal-list" class="space-y-2 max-h-80 overflow-y-auto pr-1">
            <div class="text-center py-8 text-[var(--q-muted)] text-xs">
                Belum ada ayat yang ditandai ke Bookmark.
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-5 pt-3.5 border-t border-[var(--q-border)] text-right">
            <button type="button" class="js-close-bookmarks w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors text-xs">
                Tutup
            </button>
        </div>
    </div>
</div>
