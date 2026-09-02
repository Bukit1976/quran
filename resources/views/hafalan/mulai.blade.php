<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 sm:text-2xl dark:text-gray-100">
            {{ __('Menghafal Ayat') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-3xl space-y-6">
        <div
            class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="mb-2 text-2xl font-bold text-gray-900 sm:text-3xl dark:text-white">{{ $ayat->surah->nama }}</h3>
            <p class="text-gray-600 dark:text-gray-400">Ayat {{ $ayat->nomor_ayat }}</p>
        </div>

        <div
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8 dark:border-gray-700 dark:bg-gray-800">
            <div
                class="font-arabic mb-6 text-right text-3xl leading-loose text-gray-900 sm:text-4xl lg:text-5xl dark:text-white">
                {{ $ayat->teks_arab }}
            </div>

            <div class="space-y-3 border-t border-gray-200 pt-4 dark:border-gray-700">
                <p class="text-center text-base italic text-emerald-600 sm:text-lg dark:text-emerald-400">
                    {{ $ayat->transliterasi }}
                </p>
                <p class="text-center text-sm text-gray-700 sm:text-base dark:text-gray-300">
                    {{ $ayat->terjemahan }}
                </p>
            </div>
        </div>

        <form action="{{ route('hafalan.update', $ayat->id) }}" method="POST" class="space-y-3">
            @csrf
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <button type="submit" name="status" value="sedang_dihafal"
                    class="rounded-lg bg-yellow-500 px-6 py-3 font-medium text-white transition hover:bg-yellow-600">
                    Sedang Menghafal
                </button>
                <button type="submit" name="status" value="sudah_hafal"
                    class="rounded-lg bg-emerald-500 px-6 py-3 font-medium text-white transition hover:bg-emerald-600">
                    Sudah Hafal
                </button>
            </div>
        </form>

        <a href="{{ route('quran.show', $ayat->surah_id) }}"
            class="block rounded-lg bg-gray-200 px-6 py-3 text-center font-medium text-gray-900 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
            ← Kembali ke Surah
        </a>
    </div>
</x-app-layout>
