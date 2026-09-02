<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 sm:text-2xl">Statistik & Progres</h2>
    </x-slot>

    <!-- Kartu Ringkasan -->
    <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-xl border-l-4 border-emerald-500 bg-white p-6 shadow-lg dark:bg-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Ayat Dihafal</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalHafal }}</p>
        </div>
        <div class="rounded-xl border-l-4 border-amber-500 bg-white p-6 shadow-lg dark:bg-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400">Sedang Dihafal</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $sedangHafal }}</p>
        </div>
        <div class="rounded-xl border-l-4 border-blue-500 bg-white p-6 shadow-lg dark:bg-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400">Rata-rata Nilai Tes</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($rataNilai, 1) }}</p>
        </div>
    </div>

    <!-- Grafik -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-bold text-gray-900 dark:text-white">Ayat Dihafal (7 Hari Terakhir)</h3>
            <canvas id="chartHafalan"></canvas>
        </div>
        <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-bold text-gray-900 dark:text-white">Nilai Tes (7 Hari Terakhir)</h3>
            <canvas id="chartTes"></canvas>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labels);
        const dataHafalan = @json($dataHafalan);
        const dataTes = @json($dataTes);
        const isDark = localStorage.getItem('darkMode') === 'true';
        const textColor = isDark ? '#e5e7eb' : '#374151';

        new Chart(document.getElementById('chartHafalan'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ayat Baru',
                    data: dataHafalan,
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: textColor
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor
                        }
                    },
                    x: {
                        ticks: {
                            color: textColor
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('chartTes'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rata-rata Skor',
                    data: dataTes,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: textColor
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            color: textColor
                        }
                    },
                    x: {
                        ticks: {
                            color: textColor
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
