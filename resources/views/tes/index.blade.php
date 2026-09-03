@extends('layouts.app')

@section('title', 'Uji Hafalan')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 sm:text-2xl">Uji Hafalan Anda</h2>
@endsection

@section('content')
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <a href="{{ route('tes.mulai', 'lanjutkan_ayat') }}"
            class="group rounded-xl border border-gray-200 bg-white p-6 shadow-lg transition hover:-translate-y-1 hover:shadow-xl dark:border-gray-700 dark:bg-gray-800">
            <div
                class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 transition group-hover:scale-110 dark:bg-blue-900">
                <span class="text-2xl">📝</span>
            </div>
            <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">Lanjutkan Ayat</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Tebak kelanjutan ayat dari potongan yang diberikan.</p>
        </a>

        <a href="{{ route('tes.mulai', 'tebak_arti') }}"
            class="group rounded-xl border border-gray-200 bg-white p-6 shadow-lg transition hover:-translate-y-1 hover:shadow-xl dark:border-gray-700 dark:bg-gray-800">
            <div
                class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 transition group-hover:scale-110 dark:bg-emerald-900">
                <span class="text-2xl">🧠</span>
            </div>
            <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">Tebak Arti</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Pilih arti yang benar dari kata atau ayat yang muncul.</p>
        </a>

        <a href="{{ route('tes.mulai', 'susun_kata') }}"
            class="group rounded-xl border border-gray-200 bg-white p-6 shadow-lg transition hover:-translate-y-1 hover:shadow-xl dark:border-gray-700 dark:bg-gray-800">
            <div
                class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-purple-100 transition group-hover:scale-110 dark:bg-purple-900">
                <span class="text-2xl">🧩</span>
            </div>
            <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">Susun Kata</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Susun kata-kata yang diacak menjadi ayat yang benar.</p>
        </a>
    </div>
@endsection
