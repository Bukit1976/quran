<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100 sm:text-2xl">
            {{ __('Daftar Juz Al-Qur\'an') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Info Card -->
        <div class="rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 p-6 text-white shadow-lg">
            <h3 class="mb-2 text-xl font-bold">📖 30 Juz Al-Qur'an</h3>
            <p class="text-sm text-emerald-100">Al-Qur'an terdiri dari 30 Juz, 114 Surah, dan 6236 Ayat. Pilih Juz untuk
                mulai membaca.</p>
        </div>

        <!-- Grid Juz -->
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 md:grid-cols-5 lg:grid-cols-6">
            @foreach ($juzList as $nomor => $info)
                <a href="{{ route('juz.show', $nomor) }}"
                    class="group rounded-xl border border-gray-200 bg-white p-4 text-center shadow-sm transition hover:border-emerald-500 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 dark:hover:border-emerald-500">
                    <div
                        class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-lg font-bold text-white transition group-hover:scale-110">
                        {{ $nomor }}
                    </div>
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Juz {{ $nomor }}</h4>
                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                        {{ $info['surah_awal'] }}
                    </p>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
