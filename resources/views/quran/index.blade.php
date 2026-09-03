@extends('layouts.app')

@section('title', 'Al-Qur\'an')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
        {{ __('Al-Qur\'an') }}
    </h2>
@endsection

@section('content')
    <div class="space-y-6">
        {{-- Search Bar --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <input type="text" x-data
                x-on:input="$refs.surahList.querySelectorAll('.surah-item').forEach(item => {
                       item.style.display = item.textContent.toLowerCase().includes($event.target.value.toLowerCase()) ? '' : 'none'
                   })"
                placeholder="Cari surah..."
                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 outline-none focus:border-transparent focus:ring-2 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
        </div>

        {{-- Surah List --}}
        <div x-ref="surahList" class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-3">
            @if (isset($surahs) && $surahs->count() > 0)
                @foreach ($surahs as $surah)
                    <a href="{{ route('quran.show', $surah->id) }}"
                        class="surah-item group rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:border-emerald-500 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 dark:hover:border-emerald-500 sm:p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 text-sm font-bold text-white sm:h-12 sm:w-12 sm:text-base">
                                    {{ $surah->nomor }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white sm:text-base">
                                        {{ $surah->nama }}
                                    </h4>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 sm:text-sm">
                                        {{ $surah->jumlah_ayat }} Ayat
                                    </p>
                                </div>
                            </div>
                            <div
                                class="font-arabic text-xl text-gray-900 transition group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400 sm:text-2xl">
                                {{ $surah->nama_arab }}
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="col-span-full py-12 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Belum ada data surah. Silakan jalankan seeder.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
