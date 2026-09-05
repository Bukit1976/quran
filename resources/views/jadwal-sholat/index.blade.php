@extends('layouts.app')

@section('title', 'Jadwal Sholat')

@section('header')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">Jadwal Sholat Hari Ini</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" x-text="tanggalHijriah + ' | ' + tanggalMasehi">Memuat
                tanggal...</p>
        </div>
        <div class="flex items-center gap-2">
            <select x-model="kota" @change="ambilJadwal()"
                class="rounded-xl border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                <option value="Jakarta">Jakarta</option>
                <option value="Bandung">Bandung</option>
                <option value="Surabaya">Surabaya</option>
                <option value="Yogyakarta">Yogyakarta</option>
                <option value="Semarang">Semarang</option>
                <option value="Medan">Medan</option>
                <option value="Makassar">Makassar</option>
                <option value="Denpasar">Denpasar</option>
                <option value="Palembang">Palembang</option>
                <option value="Balikpapan">Balikpapan</option>
            </select>
            <button @click="tesAdzan()"
                class="flex items-center gap-2 rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-amber-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                </svg>
                Tes Adzan
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div x-data="jadwalSholat()" x-init="init()" class="mx-auto max-w-4xl space-y-6">

        <!-- Audio Element Tersembunyi untuk Adzan -->
        <audio id="audioAdzan" preload="auto">
            <!-- Menggunakan link audio Adzan yang stabil dan umum digunakan -->
            <source src="https://www.islamcan.com/audio/adhan/azan1.mp3" type="audio/mpeg">
            Browser Anda tidak mendukung elemen audio.
        </audio>

        <!-- Info Box -->
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-800 dark:bg-emerald-900/20">
            <div class="flex items-start gap-3">
                <svg class="h-6 w-6 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-semibold text-emerald-900 dark:text-emerald-100">Menuju Sholat Berikutnya:</p>
                    <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300"
                        x-text="sholatBerikutnyaNama || 'Memuat...'"></p>
                    <p class="font-mono text-lg text-emerald-600 dark:text-emerald-400" x-text="countdown"></p>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div x-show="loading" class="flex justify-center py-12">
            <svg class="h-10 w-10 animate-spin text-emerald-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>

        <!-- Grid Jadwal Sholat -->
        <div x-show="!loading" class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-5">
            <template x-for="(waktu, nama) in jadwalSholat" :key="nama">
                <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-4 text-center shadow-sm transition-all duration-300 dark:border-gray-700 dark:bg-gray-800"
                    :class="{ 'ring-2 ring-emerald-500 bg-emerald-50 dark:bg-emerald-900/30': isNextPrayer(nama) }">

                    <!-- Icon Sholat -->
                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700"
                        :class="{
                            'bg-emerald-100 text-emerald-600 dark:bg-emerald-800 dark:text-emerald-300': isNextPrayer(
                                nama)
                        }">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <template x-if="nama === 'Fajr'">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </template>
                            <template x-if="nama === 'Dhuhr'">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </template>
                            <template x-if="nama === 'Asr'">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </template>
                            <template x-if="nama === 'Maghrib'">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </template>
                            <template x-if="nama === 'Isha'">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </template>
                        </svg>
                    </div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
                        x-text="translateNama(nama)"></p>
                    <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white" x-text="formatWaktu(waktu)"></p>

                    <span x-show="isNextPrayer(nama)"
                        class="absolute right-2 top-2 rounded-full bg-emerald-500 px-2 py-0.5 text-[10px] font-bold text-white">BERIKUTNYA</span>
                </div>
            </template>
        </div>

        <!-- Info Adzan -->
        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 text-center dark:border-gray-700 dark:bg-gray-800/50">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                💡 <strong>Catatan:</strong> Pastikan Anda pernah mengklik tombol "Tes Suara Adzan" di atas agar browser
                mengizinkan pemutaran suara otomatis saat waktu sholat tiba.
            </p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function jadwalSholat() {
            return {
                kota: localStorage.getItem('sholat_kota') || 'Jakarta',
                jadwalSholat: {},
                loading: true,
                tanggalHijriah: '',
                tanggalMasehi: '',
                sholatBerikutnyaNama: '',
                countdown: '00:00:00',
                audioAdzan: null,
                intervalId: null,

                init() {
                    this.audioAdzan = document.getElementById('audioAdzan');
                    this.ambilJadwal();
                    // Update countdown setiap detik
                    this.intervalId = setInterval(() => this.updateCountdown(), 1000);
                },

                async ambilJadwal() {
                    this.loading = true;
                    localStorage.setItem('sholat_kota', this.kota);

                    try {
                        const response = await fetch(`/api/jadwal-sholat?city=${this.kota}`);
                        const data = await response.json();

                        // Cek jika response bukan 200 OK
                        if (!response.ok) {
                            console.error("Detail Error dari Server:", data);
                            alert("Gagal: " + (data.detail || data.error || "Periksa koneksi internet Anda."));
                            this.loading = false;
                            return;
                        }

                        if (data.code === 200) {
                            this.jadwalSholat = data.data.timings;
                            this.tanggalHijriah =
                                `${data.data.date.hijri.day} ${data.data.date.hijri.month.en} ${data.data.date.hijri.year} H`;
                            this.tanggalMasehi = data.data.date.readable;
                            this.updateCountdown(); // Hitung ulang setelah data datang
                        } else {
                            alert("Format data dari API tidak dikenali.");
                        }
                    } catch (error) {
                        console.error("Fetch Error (Cek Console F12):", error);
                        alert(
                            'Gagal memuat jadwal sholat. Pastikan route "/api/jadwal-sholat" sudah terdaftar di web.php');
                    } finally {
                        this.loading = false;
                    }
                },

                translateNama(nama) {
                    const map = {
                        'Fajr': 'Subuh',
                        'Dhuhr': 'Dzuhur',
                        'Asr': 'Ashar',
                        'Maghrib': 'Maghrib',
                        'Isha': 'Isya'
                    };
                    return map[nama] || nama;
                },

                formatWaktu(waktu24) {
                    // Ubah "15:30" menjadi "15:30" (tetap 24 jam agar rapi, atau bisa diubah ke 12 jam)
                    return waktu24;
                },

                isNextPrayer(nama) {
                    return this.sholatBerikutnyaNama === nama;
                },

                updateCountdown() {
                    if (Object.keys(this.jadwalSholat).length === 0) return;

                    const now = new Date();
                    const prayers = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                    let nextPrayerFound = false;

                    for (let nama of prayers) {
                        const waktuStr = this.jadwalSholat[nama];
                        if (!waktuStr) continue;

                        const [jam, menit] = waktuStr.split(':');
                        const prayerTime = new Date();
                        prayerTime.setHours(parseInt(jam), parseInt(menit), 0, 0);

                        if (prayerTime > now) {
                            this.sholatBerikutnyaNama = nama;
                            nextPrayerFound = true;

                            const diff = prayerTime - now;
                            const hours = Math.floor(diff / (1000 * 60 * 60));
                            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                            this.countdown =
                                `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                            // Trigger Adzan jika waktu sudah tepat (selisih 0)
                            if (diff <= 1000 && diff >= 0) {
                                this.putarAdzan();
                            }
                            break;
                        }
                    }

                    // Jika semua sholat hari ini sudah lewat, next prayer adalah Subuh besok
                    if (!nextPrayerFound) {
                        this.sholatBerikutnyaNama = 'Fajr';
                        const waktuStr = this.jadwalSholat['Fajr'];
                        const [jam, menit] = waktuStr.split(':');
                        const prayerTimeBesok = new Date();
                        prayerTimeBesok.setDate(prayerTimeBesok.getDate() + 1);
                        prayerTimeBesok.setHours(parseInt(jam), parseInt(menit), 0, 0);

                        const diff = prayerTimeBesok - now;
                        const hours = Math.floor(diff / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                        this.countdown =
                            `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                    }
                },

                putarAdzan() {
                    if (this.audioAdzan) {
                        this.audioAdzan.play().catch(e => console.log(
                            "Auto-play diblokir browser, user perlu interaksi dulu.", e));
                    }
                },

                tesAdzan() {
                    if (this.audioAdzan) {
                        this.audioAdzan.currentTime = 0;
                        this.audioAdzan.play().then(() => {
                            alert('Suara Adzan berhasil diputar! Browser sekarang mengizinkan suara otomatis.');
                        }).catch(e => {
                            alert('Gagal memutar suara. Pastikan volume perangkat Anda tidak mute.');
                        });
                    }
                }
            }
        }
    </script>
@endpush
