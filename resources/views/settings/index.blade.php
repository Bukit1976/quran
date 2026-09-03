@extends('layouts.app')

@section('title', 'Pengaturan')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
        {{ __('Pengaturan') }}
    </h2>
@endsection

@section('content')
    <div
        class="min-h-screen bg-gray-50 pb-24 text-gray-900 transition-colors duration-300 dark:bg-gray-950 dark:text-gray-100">
        {{-- Header --}}
        <div
            class="sticky top-0 z-30 border-b border-gray-200 bg-white/95 backdrop-blur-md transition-colors duration-300 dark:border-gray-800/50 dark:bg-gray-950/95">
            <div class="mx-auto flex max-w-2xl items-center gap-4 px-4 py-4">
                <button onclick="window.history.back()"
                    class="text-gray-600 transition-colors hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">Pengaturan</h1>
            </div>
        </div>

        <div class="mx-auto mt-4 max-w-2xl space-y-6 px-4">
            {{-- TAMPILAN --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                    Tampilan</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Tema Aplikasi</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-tema">
                                    {{ $settings->getTemaLabel() ?? 'Mengikuti Perangkat' }}</p>
                            </div>
                            <button onclick="openThemeModal()"
                                class="text-gray-400 transition-colors hover:text-gray-600 dark:text-gray-500 dark:hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Mode Baca Qur'an</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-mode">
                                    {{ $settings->getModeBacaLabel() ?? 'Selalu Tanya' }}</p>
                            </div>
                            <button onclick="openModeModal()"
                                class="text-gray-400 transition-colors hover:text-gray-600 dark:text-gray-500 dark:hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ARABIC --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                    Arabic</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Jenis Penulisan Arabic</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-jenis">
                                    {{ $settings->getJenisPenulisanLabel() ?? 'IndoPak (Asia)' }}</p>
                            </div>
                            <button onclick="openJenisModal()"
                                class="text-gray-400 transition-colors hover:text-gray-600 dark:text-gray-500 dark:hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Tajwid Berwarna</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Mengaktifkan tajwid berwarna</p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="setting-toggle peer sr-only" id="toggle-tajwid_berwarna"
                                    {{ $settings->tajwid_berwarna ? 'checked' : '' }}>
                                <div
                                    class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:bg-gray-700">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Ukuran Font Arabic</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-ukuran_font_arabic">
                                    {{ $settings->ukuran_font_arabic ?? 18 }} px</p>
                            </div>
                            <button onclick="openFontModal('ukuran_font_arabic')"
                                class="text-gray-400 transition-colors hover:text-gray-600 dark:text-gray-500 dark:hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- LATIN --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Latin
                    (Transliterasi)</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Aktifkan Latin</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Perlihatkan latin (transliterasi)
                                </p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="setting-toggle peer sr-only" id="toggle-aktifkan_latin"
                                    {{ $settings->aktifkan_latin ? 'checked' : '' }}>
                                <div
                                    class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:bg-gray-700">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Ukuran Font Latin</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-ukuran_font_latin">
                                    {{ $settings->ukuran_font_latin ?? 16 }} px</p>
                            </div>
                            <button onclick="openFontModal('ukuran_font_latin')"
                                class="text-gray-400 transition-colors hover:text-gray-600 dark:text-gray-500 dark:hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TERJEMAHAN --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                    Terjemahan</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Aktifkan Terjemahan</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Perlihatkan terjemahan Bahasa
                                    Indonesia</p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="setting-toggle peer sr-only"
                                    id="toggle-aktifkan_terjemahan" {{ $settings->aktifkan_terjemahan ? 'checked' : '' }}>
                                <div
                                    class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:bg-gray-700">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Penerjemah</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-penerjemah">
                                    {{ $settings->getPenerjemahLabel() ?? 'Kemenag-RI' }}</p>
                            </div>
                            <button onclick="openPenerjemahModal()"
                                class="text-gray-400 transition-colors hover:text-gray-600 dark:text-gray-500 dark:hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Ukuran Font Terjemahan</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400"
                                    id="label-ukuran_font_terjemahan">{{ $settings->ukuran_font_terjemahan ?? 16 }} px</p>
                            </div>
                            <button onclick="openFontModal('ukuran_font_terjemahan')"
                                class="text-gray-400 transition-colors hover:text-gray-600 dark:text-gray-500 dark:hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- AUDIO MURATTAL --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                    Audio Murattal</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Qori Murattal</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-qori">
                                    {{ $settings->getQoriLabel() ?? 'Mishary Rashid' }}</p>
                            </div>
                            <button onclick="openQoriModal()"
                                class="text-gray-400 transition-colors hover:text-gray-600 dark:text-gray-500 dark:hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- LAINNYA --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                    Lainnya</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Aksi Popup Ayat</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-popup">
                                    {{ $settings->getAksiPopupLabel() ?? 'Diklik' }}</p>
                            </div>
                            <button onclick="openPopupModal()"
                                class="text-gray-400 transition-colors hover:text-gray-600 dark:text-gray-500 dark:hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Biarkan Layar Menyala</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Layar tetap menyala saat membaca
                                </p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="setting-toggle peer sr-only"
                                    id="toggle-biarkan_layar_menyala"
                                    {{ $settings->biarkan_layar_menyala ? 'checked' : '' }}>
                                <div
                                    class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:bg-gray-700">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ==================== MODALS ==================== --}}
            @include('settings.modals')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentFontField = '';
        let currentFontSize = 18;
        const fontMin = 12,
            fontMax = 48;

        document.addEventListener('DOMContentLoaded', () => {
            // 1. Auto-binding untuk semua checkbox dengan class 'setting-toggle'
            document.querySelectorAll('input.setting-toggle').forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const field = this.id.replace('toggle-', '');
                    const value = this.checked;

                    fetch('/pengaturan/toggle', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')?.content || '',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                field: field,
                                value: value
                            })
                        })
                        .then(res => {
                            if (!res.ok) throw new Error('Network response was not ok');
                            return res.json();
                        })
                        .then(data => {
                            if (data.success) {
                                showNotif(data.message || 'Pengaturan berhasil disimpan!');
                            } else {
                                this.checked = !value;
                                showNotif(data.message || 'Gagal menyimpan pengaturan.');
                            }
                        })
                        .catch(err => {
                            console.error('Toggle Error:', err);
                            this.checked = !value;
                            showNotif('Gagal terhubung ke server.');
                        });
                });
            });
        });

        // 2. Select Option Handler
        function selectOption(field, value, labelId, label, modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.querySelectorAll('.option-button').forEach(btn => {
                    const btnValue = btn.getAttribute('data-value');
                    const flexDiv = btn.querySelector('.flex');

                    if (btnValue === value) {
                        btn.classList.remove('text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-100',
                            'dark:hover:bg-gray-800');
                        btn.classList.add('bg-emerald-100', 'dark:bg-emerald-900/50', 'text-emerald-700',
                            'dark:text-emerald-200');
                        if (flexDiv && !flexDiv.querySelector('svg')) {
                            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                            svg.className = 'h-5 w-5 text-emerald-500';
                            svg.setAttribute('fill', 'none');
                            svg.setAttribute('stroke', 'currentColor');
                            svg.setAttribute('viewBox', '0 0 24 24');
                            svg.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
                            flexDiv.appendChild(svg);
                        }
                    } else {
                        btn.classList.remove('bg-emerald-100', 'dark:bg-emerald-900/50', 'text-emerald-700',
                            'dark:text-emerald-200');
                        btn.classList.add('text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-100',
                            'dark:hover:bg-gray-800');
                        const svg = flexDiv?.querySelector('svg');
                        if (svg) svg.remove();
                    }
                });
            }

            fetch('/pengaturan/select', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        field: field,
                        value: value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const labelElement = document.getElementById(labelId);
                        if (labelElement) labelElement.textContent = data.label || label;
                        setTimeout(() => {
                            closeModal(modalId);
                            showNotif(data.message || 'Pengaturan berhasil disimpan!');
                        }, 300);
                    }
                })
                .catch(err => {
                    console.error('Select Error:', err);
                    showNotif('Gagal terhubung ke server.');
                });
        }

        // 3. Font Size Handler
        function openFontModal(field) {
            currentFontField = field;
            const labelEl = document.getElementById(`label-${field}`);
            currentFontSize = labelEl ? parseInt(labelEl.textContent) : 18;

            const titles = {
                'ukuran_font_arabic': 'Ukuran Font Arabic',
                'ukuran_font_latin': 'Ukuran Font Latin',
                'ukuran_font_terjemahan': 'Ukuran Font Terjemahan'
            };

            const subtitleEl = document.getElementById('font-modal-subtitle');
            const displayEl = document.getElementById('font-size-display');
            if (subtitleEl) subtitleEl.textContent = titles[field] || 'Ukuran Font';
            if (displayEl) displayEl.textContent = currentFontSize;
            openModal('modal-font');
        }

        function adjustFontSize(delta) {
            currentFontSize = Math.max(fontMin, Math.min(fontMax, currentFontSize + delta));
            const displayEl = document.getElementById('font-size-display');
            if (displayEl) displayEl.textContent = currentFontSize;
        }

        function saveFontSize() {
            fetch('/pengaturan/font-size', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        field: currentFontField,
                        value: currentFontSize
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const labelEl = document.getElementById(`label-${currentFontField}`);
                        if (labelEl) labelEl.textContent = data.value;
                        closeModal('modal-font');
                        showNotif(data.message || 'Ukuran font berhasil disimpan!');
                    }
                })
                .catch(err => {
                    console.error('Font Error:', err);
                    showNotif('Gagal terhubung ke server.');
                });
        }

        // 4. Modal Utilities
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        function openThemeModal() {
            openModal('modal-tema');
        }

        function openModeModal() {
            openModal('modal-mode');
        }

        function openJenisModal() {
            openModal('modal-jenis');
        }

        function openPenerjemahModal() {
            openModal('modal-penerjemah');
        }

        function openQoriModal() {
            openModal('modal-qori');
        }

        function openPopupModal() {
            openModal('modal-popup');
        }

        // 5. Notification System
        function showNotif(message) {
            document.querySelectorAll('.toast-notification').forEach(el => el.remove());
            const notif = document.createElement('div');
            notif.className =
                'toast-notification fixed top-20 left-1/2 -translate-x-1/2 z-[100] bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg text-sm font-medium transition-all duration-300 opacity-0 -translate-y-4';
            notif.textContent = message;
            document.body.appendChild(notif);

            requestAnimationFrame(() => {
                notif.classList.remove('opacity-0', '-translate-y-4');
            });

            setTimeout(() => {
                notif.classList.add('opacity-0', '-translate-y-4');
                setTimeout(() => notif.remove(), 300);
            }, 2500);
        }

        // 6. Keyboard Handler
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                ['modal-tema', 'modal-mode', 'modal-jenis', 'modal-font', 'modal-penerjemah', 'modal-qori',
                    'modal-popup'
                ]
                .forEach(modalId => closeModal(modalId));
            }
        });
    </script>
@endpush
