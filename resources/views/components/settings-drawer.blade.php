<div id="quran-settings-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="js-close-settings fixed inset-0 quran-modal-backdrop"></div>

    <!-- Dialog -->
    <div class="relative w-full max-w-md bg-[var(--q-surface)] rounded-2xl shadow-2xl border border-[var(--q-border)] p-6 z-10">
        <div class="flex items-center justify-between pb-4 border-b border-[var(--q-border)] mb-4">
            <h3 class="font-bold text-lg text-[var(--q-text)]">Pengaturan Pembaca</h3>
            <button type="button" class="js-close-settings text-[var(--q-muted)] hover:text-[var(--q-text)] p-1">
                ✕
            </button>
        </div>

        <div class="space-y-5">
            <!-- Font Size Slider -->
            <div>
                <div class="flex items-center justify-between text-sm font-medium text-[var(--q-text)] mb-2">
                    <span>Ukuran Font Arab</span>
                    <span id="setting-font-size-val" class="text-emerald-600 font-bold">32px</span>
                </div>
                <input type="range" id="setting-font-size" min="22" max="54" step="2" value="32" class="w-full accent-emerald-600">
                <div class="flex justify-between text-xs text-[var(--q-muted)] mt-1">
                    <span>Kecil</span>
                    <span>Sedang</span>
                    <span>Besar</span>
                </div>
            </div>

            <!-- Toggle Latin -->
            <div class="flex items-center justify-between pt-3 border-t border-[var(--q-border)]">
                <div>
                    <div class="font-medium text-sm text-[var(--q-text)]">Tampilkan Transliterasi (Latin)</div>
                    <div class="text-xs text-[var(--q-muted)]">Membantu membaca bacaan Latin</div>
                </div>
                <input type="checkbox" id="setting-toggle-latin" checked class="w-5 h-5 accent-emerald-600 rounded">
            </div>

            <!-- Toggle Translation -->
            <div class="flex items-center justify-between pt-3 border-t border-[var(--q-border)]">
                <div>
                    <div class="font-medium text-sm text-[var(--q-text)]">Tampilkan Terjemahan Bahasa Indonesia</div>
                    <div class="text-xs text-[var(--q-muted)]">Kemenag RI</div>
                </div>
                <input type="checkbox" id="setting-toggle-translation" checked class="w-5 h-5 accent-emerald-600 rounded">
            </div>

            <!-- Toggle Tafsir -->
            <div class="flex items-center justify-between pt-3 border-t border-[var(--q-border)]">
                <div>
                    <div class="font-medium text-sm text-[var(--q-text)]">Tampilkan Tafsir Ringkas</div>
                    <div class="text-xs text-[var(--q-muted)]">Tafsir Al-Qur'an Kemenag RI</div>
                </div>
                <input type="checkbox" id="setting-toggle-tafsir" class="w-5 h-5 accent-emerald-600 rounded">
            </div>

            <!-- Choice of Qari / Reciter -->
            <div class="pt-3 border-t border-[var(--q-border)]">
                <label for="setting-reciter" class="block font-medium text-sm text-[var(--q-text)] mb-1">
                    Pilihan Qari (Murottal Al-Qur'an)
                </label>
                <div class="text-xs text-[var(--q-muted)] mb-2">Sumber audio Murottal API ASWAJA</div>
                <select id="setting-reciter" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-[var(--q-bg)] border border-[var(--q-border)] text-[var(--q-text)] focus:outline-none focus:border-emerald-600 transition-colors">
                    <option value="ar.alafasy">Mishary Rashid Alafasy (مشاري راشد العفاسي)</option>
                    <option value="ar.sudais">Abdurrahman As-Sudais (عبد الرحمن السديس)</option>
                    <option value="ar.ghamdi">Saad Al-Ghamdi (سعد الغامدي)</option>
                    <option value="ar.minshawi">Mohamed Siddiq Al-Minshawi (محمد صديق المنشاوي)</option>
                    <option value="ar.husary">Mahmoud Khalil Al-Husary (محمود خليل الحصري)</option>
                    <option value="ar.abdulbasit">Abdul Basit Abdul Samad (عبد الباسط عبد الصمد)</option>
                    <option value="ar.shatri">Abu Bakr Al-Shatri (أبو بكر الشاطري)</option>
                    <option value="ar.maher">Maher Al-Muaiqly (ماهر المعيقلي)</option>
                    <option value="ar.rifai">Hani Ar-Rifai (هاني الرفاعي)</option>
                    <option value="ar.alijaber">Ali Jaber (علي جابر)</option>
                </select>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-[var(--q-border)] text-right">
            <button type="button" class="js-close-settings w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors text-sm">
                Selesai
            </button>
        </div>
    </div>
</div>
