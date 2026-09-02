<x-app-layout>
    <div class="mx-auto max-w-md py-12 text-center">
        <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-xl dark:border-gray-700 dark:bg-gray-800">
            <h2 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">Tes Selesai!</h2>
            <div class="mb-4 text-6xl font-bold text-emerald-500">{{ $skor }}</div>
            <p class="mb-8 text-gray-600 dark:text-gray-400">Nilai Anda untuk tes {{ str_replace('_', ' ', $jenis) }}</p>

            <div class="flex flex-col gap-3">
                <a href="{{ route('tes.index') }}"
                    class="rounded-lg bg-emerald-500 py-3 font-bold text-white transition hover:bg-emerald-600">Coba Tes
                    Lain</a>
                <a href="{{ route('statistik.index') }}"
                    class="rounded-lg bg-blue-500 py-3 font-bold text-white transition hover:bg-blue-600">Lihat
                    Statistik</a>
            </div>
        </div>
    </div>
</x-app-layout>
