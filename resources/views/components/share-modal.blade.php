<div id="quran-share-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="js-close-share fixed inset-0 quran-modal-backdrop"></div>

    <!-- Dialog Card -->
    <div class="relative w-full max-w-lg bg-[var(--q-surface)] rounded-2xl shadow-2xl border border-[var(--q-border)] p-6 z-10">
        <!-- Header -->
        <div class="flex items-center justify-between pb-3.5 border-b border-[var(--q-border)] mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                    </svg>
                </div>
                <div>
                    <h3 id="share-modal-title" class="font-bold text-base text-[var(--q-text)] leading-tight">Bagikan Ayat</h3>
                    <p id="share-modal-subtitle" class="text-xs text-[var(--q-muted)]">QS. Al-Qur'an Digital</p>
                </div>
            </div>
            <button type="button" class="js-close-share text-[var(--q-muted)] hover:text-[var(--q-text)] p-1 text-lg font-bold">
                ✕
            </button>
        </div>

        <!-- Preview Text Box -->
        <div class="mb-5">
            <label class="block text-xs font-semibold text-[var(--q-muted)] mb-1.5">Teks yang akan dibagikan:</label>
            <div id="share-modal-preview" class="p-3.5 rounded-xl bg-[var(--q-bg)] border border-[var(--q-border)] text-xs text-[var(--q-text)] whitespace-pre-line leading-relaxed max-h-48 overflow-y-auto select-all">
                ...
            </div>
        </div>

        <!-- Share Options Grid -->
        <div class="space-y-3">
            <div class="grid grid-cols-3 gap-2.5">
                <!-- WhatsApp -->
                <a id="share-btn-wa" href="#" target="_blank" rel="noopener" class="flex flex-col items-center justify-center p-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white transition-all shadow-sm group">
                    <svg class="w-6 h-6 mb-1 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.147 4.19 4.226-1.109z"/>
                    </svg>
                    <span class="text-[11px] font-bold">WhatsApp</span>
                </a>

                <!-- Facebook -->
                <a id="share-btn-fb" href="#" target="_blank" rel="noopener" class="flex flex-col items-center justify-center p-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition-all shadow-sm group">
                    <svg class="w-6 h-6 mb-1 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    <span class="text-[11px] font-bold">Facebook</span>
                </a>

                <!-- X (Twitter) -->
                <a id="share-btn-x" href="#" target="_blank" rel="noopener" class="flex flex-col items-center justify-center p-3 rounded-xl bg-slate-900 dark:bg-slate-950 border border-slate-700 dark:border-slate-700 hover:bg-black dark:hover:bg-slate-900 text-white transition-all shadow-sm group">
                    <svg class="w-5 h-5 mb-1.5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                    <span class="text-[11px] font-bold">Twitter / X</span>
                </a>
            </div>

            <!-- Native Mobile Share Button (Shown if supported) -->
            <button type="button" id="share-btn-native" class="hidden w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors text-xs flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
                <span>Buka Menu Bagikan HP</span>
            </button>

            <!-- Copy Text Button -->
            <button type="button" id="share-btn-copy" class="w-full py-2.5 px-4 bg-[var(--q-bg)] hover:bg-[var(--q-hover)] text-[var(--q-text)] border border-[var(--q-border)] font-semibold rounded-xl transition-colors text-xs flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <span id="share-btn-copy-text">Salin Teks ke Clipboard</span>
            </button>
        </div>
    </div>
</div>
