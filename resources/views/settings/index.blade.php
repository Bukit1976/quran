{{-- resources/views/settings.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengaturan')

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

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mx-auto mt-4 max-w-2xl px-4">
                <div
                    class="flex items-center gap-2 rounded-xl border border-emerald-300 bg-emerald-100 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-500/30 dark:bg-emerald-500/20 dark:text-emerald-300">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="mx-auto mt-4 max-w-2xl space-y-6 px-4">

            {{-- ==================== TAMPILAN ==================== --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                    Tampilan</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">

                    {{-- Tema Aplikasi --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Tema Aplikasi</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-tema">
                                    {{ $settings->tema_label ?? 'Mengikuti Perangkat' }}</p>
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

                    {{-- Mode Baca Qur'an --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Mode Baca Qur'an</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-mode">
                                    {{ $settings->mode_baca_label ?? 'Selalu Tanya' }}</p>
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

            {{-- ==================== ARABIC ==================== --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                    Arabic</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">

                    {{-- Jenis Penulisan Arabic --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Jenis Penulisan Arabic</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-jenis">
                                    {{ $settings->jenis_penulisan_label ?? 'IndoPak (Asia)' }}</p>
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

                    {{-- Tajwid Berwarna --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Tajwid Berwarna</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Mengaktifkan dan nonaktifkan
                                    tajwid berwarna serta penjelasannya</p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="peer sr-only" id="toggle-tajwid"
                                    {{ $settings->tajwid_berwarna ?? true ? 'checked' : '' }}
                                    onchange="toggleSetting('tajwid_berwarna', this.checked)">
                                <div
                                    class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:bg-gray-700">
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Ukuran Font Arabic --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Ukuran Font Arabic</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-font-arabic">
                                    {{ $settings->ukuran_font_arabic ?? 18 }} px</p>
                            </div>
                            <button onclick="openFontModal('arabic')"
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

            {{-- ==================== LATIN ==================== --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Latin
                    (Transliterasi)</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">

                    {{-- Aktifkan Latin --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Aktifkan Latin</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Perlihatkan latin
                                    (transliterasi) Qur'an</p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="peer sr-only" id="toggle-latin"
                                    {{ $settings->aktifkan_latin ?? true ? 'checked' : '' }}
                                    onchange="toggleSetting('aktifkan_latin', this.checked)">
                                <div
                                    class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:bg-gray-700">
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Ukuran Font Latin --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Ukuran Font Latin</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-font-latin">
                                    {{ $settings->ukuran_font_latin ?? 16 }} px</p>
                            </div>
                            <button onclick="openFontModal('latin')"
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

            {{-- ==================== TERJEMAHAN ==================== --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                    Terjemahan</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">

                    {{-- Aktifkan Terjemahan --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Aktifkan Terjemahan</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Perlihatkan terjemahan Qur'an
                                    Bahasa Indonesia</p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="peer sr-only" id="toggle-terjemahan"
                                    {{ $settings->aktifkan_terjemahan ?? true ? 'checked' : '' }}
                                    onchange="toggleSetting('aktifkan_terjemahan', this.checked)">
                                <div
                                    class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:bg-gray-700">
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Penerjemah --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Penerjemah</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-penerjemah">
                                    {{ $settings->penerjemah_label ?? 'Kemenag-RI' }}</p>
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

                    {{-- Ukuran Font Terjemahan --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Ukuran Font Terjemahan</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-font-terjemahan">
                                    {{ $settings->ukuran_font_terjemahan ?? 16 }} px</p>
                            </div>
                            <button onclick="openFontModal('terjemahan')"
                                class="text-gray-400 transition-colors hover:text-gray-600 dark:text-gray-500 dark:hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Kata Demi Kata --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Kata Demi Kata</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Aktifkan terjemahan Qur'an
                                    perkata (fitur ini masih versi beta)</p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="peer sr-only" id="toggle-kata"
                                    {{ $settings->kata_demi_kata ?? false ? 'checked' : '' }}
                                    onchange="toggleSetting('kata_demi_kata', this.checked)">
                                <div
                                    class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:bg-gray-700">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ==================== AUDIO MURATTAL ==================== --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                    Audio Murattal</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">

                    {{-- Qori Murattal --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Qori Murattal</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-qori">
                                    {{ $settings->qori_label ?? 'Mishary Rashid' }}</p>
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

                    {{-- Audio Manager --}}
                    <a href="#" onclick="alert('Fitur Audio Manager segera hadir!')"
                        class="block px-4 py-4 transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Audio Manager</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Unduh dan hapus multi select
                                    audio murattal</p>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>

            {{-- ==================== LAINNYA ==================== --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                    Lainnya</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">

                    {{-- Aksi Popup Ayat --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Aksi Popup Ayat</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="label-popup">
                                    {{ $settings->aksi_popup_label ?? 'Diklik' }}</p>
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

                    {{-- Biarkan Layar Menyala --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Biarkan Layar Menyala</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Biarkan layar tetap menyala
                                    ketika membaca Qur'an</p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="peer sr-only" id="toggle-layar"
                                    {{ $settings->biarkan_layar_menyala ?? true ? 'checked' : '' }}
                                    onchange="toggleSetting('biarkan_layar_menyala', this.checked)">
                                <div
                                    class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:bg-gray-700">
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Layar Penuh --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Layar Penuh</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Aktifkan layar penuh (tanpa
                                    notifbar)</p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="peer sr-only" id="toggle-fullscreen"
                                    {{ $settings->layar_penuh ?? false ? 'checked' : '' }}
                                    onchange="toggleSetting('layar_penuh', this.checked)">
                                <div
                                    class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:bg-gray-700">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ==================== TENTANG APLIKASI ==================== --}}
            <div>
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                    Tentang Aplikasi</h2>
                <div
                    class="divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white shadow-sm transition-colors duration-300 dark:divide-gray-800/50 dark:bg-gray-900 dark:shadow-none">

                    {{-- Premium --}}
                    <div class="px-4 py-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-500/20">
                                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Premium</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Membuat pengalaman lebih baik
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Beri Rating --}}
                    <a href="https://play.google.com/store/apps/details?id=com.hafalquran" target="_blank"
                        class="block px-4 py-4 transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-500/20">
                                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Beri Rating</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Berikan rating aplikasi ini di
                                    Play Store</p>
                            </div>
                        </div>
                    </a>

                    {{-- Informasi & Privasi --}}
                    <a href="{{ route('privacy') }}"
                        class="block px-4 py-4 transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-500/20">
                                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[15px] font-medium text-gray-900 dark:text-white">Informasi & Privasi</p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Informasi & kebijakan privasi
                                    aplikasi</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- ==================== KONTAK KAMI ==================== --}}
            <div class="py-6 text-center">
                <h2 class="mb-4 text-lg font-bold text-emerald-600 dark:text-emerald-400">Kontak Kami</h2>
                <div class="flex items-center justify-center gap-6">
                    <a href="https://instagram.com/hafalquran" target="_blank"
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                        </svg>
                    </a>
                    <a href="mailto:info@hafalquran.com"
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </a>
                    <a href="https://hafalquran.com" target="_blank"
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- ==================== MODALS ==================== --}}
        @include('settings.modals')

    </div>
@endsection

@section('scripts')
    <script>
        let currentFontField = '';
        let currentFontSize = 18;
        let fontMin = 12;
        let fontMax = 48;

        function toggleSetting(field, value) {
            fetch(`/settings/update/${field}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        value: value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) showNotif('Pengaturan disimpan!');
                })
                .catch(err => {
                    console.error('Error:', err);
                    showNotif('Gagal menyimpan pengaturan');
                });
        }

        function selectOption(field, value, labelId, label, modalId) {
            fetch(`/settings/update/${field}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        value: value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(labelId).textContent = data.label || label;
                        closeModal(modalId);
                        showNotif('Pengaturan disimpan!');
                        setTimeout(() => location.reload(), 500);
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    showNotif('Gagal menyimpan pengaturan');
                });
        }

        function openFontModal(type) {
            currentFontField = type;
            currentFontSize = parseInt(document.getElementById(`label-font-${type}`).textContent);
            fontMin = (type === 'arabic') ? 12 : 10;
            fontMax = (type === 'arabic') ? 48 : 36;

            const titles = {
                arabic: 'Ukuran Font Arabic',
                latin: 'Ukuran Font Latin',
                terjemahan: 'Ukuran Font Terjemahan'
            };
            document.getElementById('font-modal-subtitle').textContent = titles[type];
            document.getElementById('font-size-display').textContent = currentFontSize;
            openModal('modal-font');
        }

        function adjustFontSize(delta) {
            currentFontSize = Math.max(fontMin, Math.min(fontMax, currentFontSize + delta));
            document.getElementById('font-size-display').textContent = currentFontSize;
        }

        function saveFontSize() {
            const fieldMap = {
                arabic: 'ukuran_font_arabic',
                latin: 'ukuran_font_latin',
                terjemahan: 'ukuran_font_terjemahan'
            };
            const labelMap = {
                arabic: 'label-font-arabic',
                latin: 'label-font-latin',
                terjemahan: 'label-font-terjemahan'
            };

            fetch(`/settings/update/${fieldMap[currentFontField]}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        value: currentFontSize
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(labelMap[currentFontField]).textContent = data.label;
                        closeModal('modal-font');
                        showNotif('Ukuran font disimpan!');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    showNotif('Gagal menyimpan pengaturan');
                });
        }

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = '';
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

        function showNotif(message) {
            document.querySelectorAll('.toast-notification').forEach(el => el.remove());
            const notif = document.createElement('div');
            notif.className =
                'toast-notification fixed top-20 left-1/2 -translate-x-1/2 z-[100] bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg text-sm font-medium transition-all duration-300';
            notif.textContent = message;
            document.body.appendChild(notif);
            setTimeout(() => {
                notif.style.opacity = '0';
                notif.style.transform = 'translate(-50%, -20px)';
                setTimeout(() => notif.remove(), 300);
            }, 2000);
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                ['modal-tema', 'modal-mode', 'modal-jenis', 'modal-font', 'modal-penerjemah', 'modal-qori',
                    'modal-popup'
                ].forEach(modal => closeModal(modal));
            }
        });
    </script>
@endsection
