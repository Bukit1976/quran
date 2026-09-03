@extends('layouts.app')

@section('title', 'Hafalan Saya')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
        {{ __('Hafalan Saya') }}
    </h2>
@endsection

@section('content')
    <div class="space-y-6">
        @if (!isset($hafalan) || $hafalan->isEmpty())
            <div
                class="rounded-xl border border-gray-200 bg-white p-8 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-12">
                <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Belum Ada Hafalan</h3>
                <p class="mb-6 text-gray-600 dark:text-gray-400">Mulai perjalanan menghafal Al-Qur'an Anda sekarang</p>
                <a href="{{ route('quran.index') }}"
                    class="inline-block rounded-lg bg-emerald-500 px-6 py-3 font-medium text-white transition hover:bg-emerald-600">
                    Mulai Menghafal
                </a>
            </div>
        @else
            @foreach ($hafalan as $surahNama => $ayahs)
                <div
                    class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                        <h4 class="text-lg font-semibold text-white">{{ $surahNama }}</h4>
                    </div>
                    <div class="space-y-3 p-4 sm:p-6">
                        @foreach ($ayahs as $hafalanItem)
                            <div
                                class="flex items-center justify-between rounded-lg bg-gray-50 p-3 transition hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700 sm:p-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300">
                                        {{ $hafalanItem->ayat->nomor_ayat }}
                                    </div>
                                    <span class="text-sm text-gray-900 dark:text-white sm:text-base">Ayat
                                        {{ $hafalanItem->ayat->nomor_ayat }}</span>
                                </div>
                                <div>
                                    @if ($hafalanItem->status === 'sudah_hafal')
                                        <span
                                            class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300 sm:text-sm">✓
                                            Hafal</span>
                                    @elseif($hafalanItem->status === 'sedang_dihafal')
                                        <span
                                            class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300 sm:text-sm">Menghafal</span>
                                    @else
                                        <span
                                            class="rounded-full bg-gray-200 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-600 dark:text-gray-300 sm:text-sm">○
                                            Belum</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
