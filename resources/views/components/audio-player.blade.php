<!-- Floating Sticky Bottom Audio Player Bar -->
<div id="quran-audio-player" class="fixed bottom-0 inset-x-0 z-40 hidden bg-[var(--q-surface)]/95 backdrop-blur-md border-t border-[var(--q-border)] shadow-2xl transition-all duration-300 transform translate-y-full">
    <div class="max-w-4xl mx-auto px-4 py-2.5 sm:py-3">
        <div class="flex items-center justify-between gap-3">
            
            <!-- Left Info Section -->
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shrink-0 shadow-sm animate-pulse" id="player-equalizer-icon">
                    🎵
                </div>
                <div class="min-w-0">
                    <div id="player-title" class="font-bold text-xs sm:text-sm text-[var(--q-text)] truncate">Murottal Al-Qur'an</div>
                    <div id="player-subtitle" class="text-[11px] text-[var(--q-muted)] truncate">Memutar audio...</div>
                </div>
            </div>

            <!-- Middle Audio Controls & Seekbar -->
            <div class="flex-1 max-w-md hidden sm:flex flex-col items-center gap-1">
                <div class="flex items-center gap-3">
                    <!-- Prev Ayah Button -->
                    <button type="button" id="player-btn-prev" class="p-1.5 rounded-full text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] transition-colors" title="Ayat Sebelumnya">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"/>
                        </svg>
                    </button>

                    <!-- Play/Pause Button -->
                    <button type="button" id="player-btn-play" class="w-9 h-9 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white flex items-center justify-center transition-colors shadow-sm focus:outline-none">
                        <svg id="player-icon-play" class="w-4 h-4 hidden fill-current" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        <svg id="player-icon-pause" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                        </svg>
                    </button>

                    <!-- Next Ayah Button -->
                    <button type="button" id="player-btn-next" class="p-1.5 rounded-full text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] transition-colors" title="Ayat Selanjutnya">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"/>
                        </svg>
                    </button>
                </div>

                <!-- Progress Bar & Time -->
                <div class="w-full flex items-center gap-2 text-[10px] text-[var(--q-muted)] font-mono">
                    <span id="player-time-current">00:00</span>
                    <input type="range" id="player-seekbar" min="0" max="100" value="0" step="0.1" class="w-full h-1.5 accent-emerald-600 rounded-lg cursor-pointer bg-[var(--q-border)]">
                    <span id="player-time-total">00:00</span>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-2 shrink-0">
                <!-- Mobile Play/Pause Button -->
                <button type="button" id="player-btn-play-mobile" class="sm:hidden w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow-xs">
                    <svg id="player-icon-play-m" class="w-3.5 h-3.5 hidden fill-current" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    <svg id="player-icon-pause-m" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                    </svg>
                </button>

                <!-- Open Reciter Settings Button -->
                <button type="button" class="js-open-settings p-1.5 rounded-lg text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] transition-colors text-xs font-semibold hidden md:flex items-center gap-1">
                    <span>Qari</span>
                </button>

                <!-- Close Audio Player -->
                <button type="button" id="player-btn-close" class="p-1.5 text-[var(--q-muted)] hover:text-[var(--q-text)] hover:bg-[var(--q-hover)] rounded-lg transition-colors text-base font-bold">
                    ✕
                </button>
            </div>
        </div>

        <!-- Mobile Progress Bar (Shown on small screens below controls) -->
        <div class="sm:hidden w-full flex items-center gap-2 mt-1.5 text-[10px] text-[var(--q-muted)] font-mono">
            <span id="player-time-current-m">00:00</span>
            <input type="range" id="player-seekbar-m" min="0" max="100" value="0" step="0.1" class="w-full h-1 accent-emerald-600 rounded-lg cursor-pointer bg-[var(--q-border)]">
            <span id="player-time-total-m">00:00</span>
        </div>
    </div>
</div>
