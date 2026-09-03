@extends('layouts.app')

@section('title', 'Dashboard Hafalan')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
            {{ __('Dashboard Hafalan') }}</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 sm:mt-0">{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Welcome Banner -->
        <div class="rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-6 text-white shadow-xl sm:p-8">
            <div class="mb-3 flex items-center space-x-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold sm:text-3xl">Assalamu'alaikum, {{ Auth::user()->name }}!</h3>
                    <p class="text-sm text-emerald-100 sm:text-base">Semangat melanjutkan perjalanan menghafal Al-Qur'an</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
            <div
                class="rounded-xl border border-gray-100 bg-white p-5 shadow-lg dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <h4 class="mb-1 text-sm text-gray-600 dark:text-gray-400">Target Hafalan</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $targetAyat }} <span
                        class="text-sm font-normal text-gray-500">ayat</span></p>
            </div>
            <div
                class="rounded-xl border border-gray-100 bg-white p-5 shadow-lg dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <h4 class="mb-1 text-sm text-gray-600 dark:text-gray-400">Tercapai Hari Ini</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $hafalanHariIni }} <span
                        class="text-sm font-normal text-gray-500">/ {{ $targetAyat }}</span></p>
                <div class="mt-2 h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                    <div class="h-2 rounded-full bg-emerald-500 transition-all duration-500"
                        style="width: {{ min(($hafalanHariIni / max($targetAyat, 1)) * 100, 100) }}%"></div>
                </div>
            </div>
            <div
                class="rounded-xl border border-gray-100 bg-white p-5 shadow-lg dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <h4 class="mb-1 text-sm text-gray-600 dark:text-gray-400">Murajaah Hari Ini</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $murajaahHariIni }} <span
                        class="text-sm font-normal text-gray-500">ayat</span></p>
            </div>
            <div
                class="rounded-xl border border-gray-100 bg-white p-5 shadow-lg dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <h4 class="mb-1 text-sm text-gray-600 dark:text-gray-400">Total Hafalan</h4>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalHafalan }} <span
                        class="text-sm font-normal text-gray-500">ayat</span></p>
            </div>
        </div>

        <!-- Action Sections -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div
                class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                    <h4 class="flex items-center text-lg font-bold text-white">Tugas Hari Ini</h4>
                </div>
                <div class="space-y-3 p-6">
                    <a href="{{ route('quran.index') }}"
                        class="group flex items-center rounded-xl border border-emerald-100 bg-emerald-50 p-4 transition hover:shadow-md dark:border-emerald-800 dark:bg-emerald-900/20">
                        <div
                            class="mr-4 flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-500 font-bold text-white">
                            1</div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 dark:text-white">Hafal Ayat Baru</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pilih surah dan ayat untuk dihafal</p>
                        </div>
                    </a>
                </div>
            </div>

            <div
                class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4">
                    <h4 class="flex items-center text-lg font-bold text-white">Murajaah</h4>
                </div>
                <div class="p-6">
                    @if ($murajaahHariIni > 0)
                        <div class="space-y-4">
                            <div class="rounded-xl border-l-4 border-amber-500 bg-amber-50 p-4 dark:bg-amber-900/20">
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $murajaahHariIni }} Ayat</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">perlu dimurajaah hari ini</p>
                            </div>
                            <a href="{{ route('murajaah.index') }}"
                                class="block w-full transform rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-3 text-center font-bold text-white shadow-lg transition hover:scale-105">Mulai
                                Murajaah Sekarang</a>
                        </div>
                    @else
                        <div class="py-8 text-center">
                            <p class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Masya Allah!</p>
                            <p class="text-gray-600 dark:text-gray-400">Tidak ada murajaah hari ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const murajaahHariIni = {{ $murajaahHariIni ?? 0 }};
        if (murajaahHariIni > 0 && "Notification" in window && Notification.permission === "granted") {
            new Notification("⏰ Pengingat Murajaah", {
                body: `Anda memiliki ${murajaahHariIni} ayat yang perlu dimurajaah hari ini.`,
                icon: "https://cdn-icons-png.flaticon.com/512/3018/3018523.png"
            });
        }
    </script>
@endpush
