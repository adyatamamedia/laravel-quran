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
                        <span id="changelog-latest-badge" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#1b594a] text-white">v2.1.1</span>
                    </div>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <p id="changelog-status-text" class="text-[11px] text-[var(--q-muted)]">Tersinkron langsung dari GitHub Releases</p>
                    </div>
                </div>
            </div>
            <button type="button" class="js-close-changelog text-[var(--q-muted)] hover:text-[var(--q-text)] p-1 rounded-lg hover:bg-[var(--q-hover)] transition-colors" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Changelog Content Body (Scrollable & Dynamic from GitHub) -->
        <div id="changelog-releases-list" class="overflow-y-auto py-3 space-y-4 text-xs pr-1 flex-1">
            <!-- Loading Skeleton State -->
            <div id="changelog-loading-skeleton" class="space-y-3 py-2">
                <div class="p-3.5 rounded-xl bg-[var(--q-hover)]/40 border border-[var(--q-border)] space-y-2 animate-pulse">
                    <div class="h-4 bg-[var(--q-border)] rounded w-1/3"></div>
                    <div class="h-3 bg-[var(--q-border)]/60 rounded w-full"></div>
                    <div class="h-3 bg-[var(--q-border)]/60 rounded w-4/5"></div>
                </div>
                <div class="p-3.5 rounded-xl bg-[var(--q-hover)]/20 border border-[var(--q-border)] space-y-2 animate-pulse">
                    <div class="h-4 bg-[var(--q-border)]/80 rounded w-1/4"></div>
                    <div class="h-3 bg-[var(--q-border)]/40 rounded w-3/4"></div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="pt-3 border-t border-[var(--q-border)] flex items-center justify-between gap-2 shrink-0">
            <div class="flex items-center gap-2">
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

                <a href="https://github.com/adyatamamedia/laravel-quran/releases" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="hidden sm:inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-[var(--q-border)] hover:bg-[var(--q-hover)] text-[var(--q-muted)] hover:text-[var(--q-text)] text-xs font-medium transition-colors" title="Lihat di GitHub">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                    </svg>
                    <span>GitHub</span>
                </a>
            </div>

            <button type="button" class="js-close-changelog px-3.5 py-1.5 rounded-lg bg-[var(--q-hover)] text-[var(--q-text)] hover:bg-[var(--q-border)]/50 text-xs font-semibold transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>
