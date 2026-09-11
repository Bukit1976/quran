@extends('layouts.app')

@section('title', 'Jadwal Sholat')

@section('header')
    <div class="flex flex-col gap-2">
        <h2 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white">
            Jadwal Sholat Hari Ini
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Jadwal sholat otomatis berdasarkan lokasi Anda
        </p>
    </div>
@endsection

@section('content')
    <div x-data="jadwalSholat()" x-init="init()" class="mx-auto max-w-6xl space-y-6 px-4 md:px-0">

        {{-- PANEL LOKASI GPS OTOMATIS --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-lg dark:border-gray-700 dark:bg-gray-800">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Lokasi Anda</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400" x-text="locationStatus"></p>
                    </div>
                </div>

                {{-- Tombol Refresh GPS --}}
                <button @click="detectLocationGPS()" :disabled="detectingGPS"
                    class="inline-flex items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed bg-gradient-to-r from-blue-500 to-cyan-600">
                    <svg x-show="!detectingGPS" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <svg x-show="detectingGPS" class="h-5 w-5 animate-spin" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span x-text="detectingGPS ? 'Mendeteksi...' : 'Perbarui Lokasi'"></span>
                </button>
            </div>

            {{-- INFO LOKASI --}}
            <div
                class="mt-4 flex items-center gap-2 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-300">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <div class="flex-1">
                    <span class="font-semibold">Lokasi: </span>
                    <span x-text="displayLocation" class="break-words"></span>
                    <span x-show="gpsSuccess"
                        class="ml-2 inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                        GPS
                    </span>
                </div>
            </div>
        </div>

        <audio id="audioAdzan" preload="auto" x-ref="audioAdzan"></audio>

        {{-- PANEL KONTROL ADZAN --}}
        <div
            class="rounded-2xl border border-emerald-200 bg-gradient-to-r from-emerald-50 via-teal-50 to-cyan-50 p-5 shadow-lg dark:border-emerald-800 dark:from-emerald-900/30 dark:via-teal-900/30 dark:to-cyan-900/30">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Pilihan Suara Adzan</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pilihan tersimpan otomatis di browser</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <select x-model="selectedAdzan" @change="gantiAdzan()"
                        class="w-full sm:min-w-[250px] rounded-xl border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        <optgroup label="Timur Tengah">
                            <option value="masjidil_haram">Masjidil Haram (Mekkah)</option>
                            <option value="mishary_alafasy">Mishary Rashid Alafasy</option>
                            <option value="abdul_basit">Abdul Basit (Mesir)</option>
                            <option value="saudi_1">Adzan Saudi (Madani)</option>
                        </optgroup>
                        <optgroup label="Asia">
                            <option value="turki_1">Turki (Sultan Ahmed)</option>
                            <option value="malaysia_1">Malaysia</option>
                            <option value="indonesia_1">Indonesia</option>
                            <option value="pakistan_1">Pakistan</option>
                        </optgroup>
                    </select>

                    <div class="flex gap-2">
                        <button @click="toggleAdzan()"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white shadow-lg transition-all hover:scale-105 active:scale-95"
                            :class="isPlaying ? 'bg-gradient-to-r from-red-500 to-pink-500' :
                                'bg-gradient-to-r from-amber-500 to-orange-500'">
                            <span x-text="isPlaying ? 'Stop' : 'Tes Adzan'"></span>
                        </button>
                        <button @click="toggleMute()"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all hover:scale-105 active:scale-95"
                            :class="isMuted ? 'bg-red-500' : 'bg-gray-500'">
                            <span x-text="isMuted ? 'Unmute' : 'Mute'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- COUNTDOWN --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-700 p-6 md:p-8 text-white shadow-2xl">
            <div class="relative z-10">
                <div class="mb-4 flex items-center gap-2 text-emerald-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">Menuju Sholat Berikutnya:</span>
                </div>
                <h3 class="mb-2 text-3xl md:text-4xl font-bold"
                    x-text="translateNama(sholatBerikutnyaNama) || 'Memuat...'"></h3>
                <div class="flex items-baseline gap-2">
                    <span class="font-mono text-4xl md:text-5xl font-bold" x-text="countdown"></span>
                    <span class="text-emerald-200">lagi</span>
                </div>
                <div class="mt-4 flex flex-wrap items-center gap-2 text-sm text-emerald-100">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span x-text="displayLocation" class="break-words"></span>
                </div>
                <div class="mt-2 text-sm text-emerald-100">
                    <span x-text="tanggalHijriah"></span>
                    <span> | </span>
                    <span x-text="tanggalMasehi"></span>
                </div>
            </div>
        </div>

        {{-- LOADING --}}
        <div x-show="loading" class="flex justify-center py-12">
            <div class="h-16 w-16 animate-spin rounded-full border-4 border-emerald-200 border-t-emerald-600"></div>
        </div>

        {{-- JADWAL SHOLAT --}}
        <div x-show="!loading" x-cloak class="grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-8">
            {{-- SUBUH --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer"
                :class="{ 'scale-110': isNextPrayer('Fajr') }">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Subuh"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(16,185,129,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(16,185,129,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">SUBUH</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Fajr)"></p>
                <span x-show="isNextPrayer('Fajr')"
                    class="mt-3 inline-block rounded-full bg-emerald-500 px-4 py-1 text-xs font-bold text-white animate-pulse shadow-lg shadow-emerald-500/50">BERIKUTNYA</span>
            </div>

            {{-- TERBIT --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Terbit"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(245,158,11,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(245,158,11,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">TERBIT</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Sunrise)"></p>
            </div>

            {{-- DZUHUR --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer"
                :class="{ 'scale-110': isNextPrayer('Dhuhr') }">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Dzuhur"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(234,179,8,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(234,179,8,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">DZUHUR</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Dhuhr)"></p>
                <span x-show="isNextPrayer('Dhuhr')"
                    class="mt-3 inline-block rounded-full bg-emerald-500 px-4 py-1 text-xs font-bold text-white animate-pulse shadow-lg shadow-emerald-500/50">BERIKUTNYA</span>
            </div>

            {{-- ASHAR --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer"
                :class="{ 'scale-110': isNextPrayer('Asr') }">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Ashar"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(249,115,22,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(249,115,22,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">ASHAR</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Asr)"></p>
                <span x-show="isNextPrayer('Asr')"
                    class="mt-3 inline-block rounded-full bg-emerald-500 px-4 py-1 text-xs font-bold text-white animate-pulse shadow-lg shadow-emerald-500/50">BERIKUTNYA</span>
            </div>

            {{-- MAGHRIB --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer"
                :class="{ 'scale-110': isNextPrayer('Maghrib') }">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Maghrib"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(239,68,68,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(239,68,68,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">MAGHRIB</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Maghrib)"></p>
                <span x-show="isNextPrayer('Maghrib')"
                    class="mt-3 inline-block rounded-full bg-emerald-500 px-4 py-1 text-xs font-bold text-white animate-pulse shadow-lg shadow-emerald-500/50">BERIKUTNYA</span>
            </div>

            {{-- ISYA --}}
            <div class="relative p-4 md:p-6 text-center transition-all duration-300 hover:scale-110 group cursor-pointer"
                :class="{ 'scale-110': isNextPrayer('Isha') }">
                <img src="{{ asset('Logo/Jadwal.png') }}" alt="Isya"
                    class="h-24 w-24 md:h-32 md:w-32 mx-auto mb-3 object-contain drop-shadow-[0_0_15px_rgba(99,102,241,0.5)] group-hover:drop-shadow-[0_0_25px_rgba(99,102,241,0.8)] transition-all duration-300">
                <p class="mb-2 text-sm md:text-base font-bold tracking-wider text-gray-700 dark:text-gray-200">ISYA</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white"
                    x-text="formatWaktu(jadwalSholat.Isha)"></p>
                <span x-show="isNextPrayer('Isha')"
                    class="mt-3 inline-block rounded-full bg-emerald-500 px-4 py-1 text-xs font-bold text-white animate-pulse shadow-lg shadow-emerald-500/50">BERIKUTNYA</span>
            </div>
        </div>

        {{-- INFO --}}
        <div
            class="rounded-2xl border border-amber-200 bg-gradient-to-br from-amber-50 to-orange-50 p-6 shadow-lg dark:border-amber-800 dark:from-amber-900/20 dark:to-orange-900/20">
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-amber-500 text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="mb-2 text-sm font-bold text-amber-900 dark:text-amber-100"> Tips Penggunaan</h4>
                    <ul class="space-y-1 text-sm text-amber-800 dark:text-amber-200">
                        <li>• Lokasi dideteksi <strong>otomatis</strong> saat halaman dibuka.</li>
                        <li>• Klik tombol <strong>"Perbarui Lokasi"</strong> jika ingin refresh GPS.</li>
                        <li>• Pastikan <strong>GPS/Location</strong> aktif di perangkat Anda.</li>
                        <li>• Izinkan akses lokasi saat diminta browser/aplikasi.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- TOAST --}}
        <div x-show="showToast" x-transition x-cloak
            class="fixed bottom-6 right-6 left-6 md:left-auto z-50 rounded-xl bg-emerald-600 px-6 py-4 text-white shadow-2xl">
            <div class="flex items-center gap-3">
                <svg class="h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-semibold text-sm md:text-base" x-text="toastMessage"></p>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const LocalNotif = (typeof window !== 'undefined' && window.Capacitor && window.Capacitor.Plugins && window
                .Capacitor.Plugins.LocalNotifications) ?
            window.Capacitor.Plugins.LocalNotifications :
            null;

        function jadwalSholat() {
            return {
                jadwalSholat: {
                    Fajr: '04:30',
                    Sunrise: '05:45',
                    Dhuhr: '11:45',
                    Asr: '15:00',
                    Maghrib: '17:45',
                    Isha: '19:00'
                },
                loading: true,
                tanggalHijriah: '',
                tanggalMasehi: '',
                sholatBerikutnyaNama: 'Fajr',
                countdown: '00:00:00',
                selectedAdzan: localStorage.getItem('selected_adzan') || 'masjidil_haram',
                adzanPlayed: false,
                isPlaying: false,
                isMuted: false,
                showToast: false,
                toastMessage: '',
                countdownInterval: null,
                toastTimeout: null,

                detectingGPS: false,
                gpsSuccess: false,
                currentLat: null,
                currentLng: null,
                displayLocation: 'Mendeteksi lokasi...',
                locationStatus: 'Mencari lokasi Anda...',

                adzanSources: {
                    masjidil_haram: 'https://www.islamcan.com/audio/adhan/azan1.mp3',
                    mishary_alafasy: 'https://www.islamcan.com/audio/adhan/azan2.mp3',
                    abdul_basit: 'https://www.islamcan.com/audio/adhan/azan3.mp3',
                    saudi_1: 'https://www.islamcan.com/audio/adhan/azan4.mp3',
                    turki_1: 'https://www.islamcan.com/audio/adhan/azan5.mp3',
                    malaysia_1: 'https://www.islamcan.com/audio/adhan/azan6.mp3',
                    indonesia_1: 'https://www.islamcan.com/audio/adhan/azan7.mp3',
                    pakistan_1: 'https://www.islamcan.com/audio/adhan/azan8.mp3'
                },

                async init() {
                    this.updateAudioSource();
                    this.updateTanggal();

                    if (LocalNotif) {
                        try {
                            await LocalNotif.createChannel({
                                id: 'alarm_channel',
                                name: 'Alarm Sholat',
                                description: 'Notifikasi waktu sholat',
                                importance: 4,
                                visibility: 1,
                                sound: 'default',
                                vibration: true
                            });
                            await LocalNotif.requestPermissions();
                        } catch (e) {
                            console.log('Setup notifikasi:', e);
                        }
                    }

                    // Coba load koordinat dari localStorage dulu
                    const savedLat = localStorage.getItem('sholat_lat');
                    const savedLng = localStorage.getItem('sholat_lng');
                    const savedLocation = localStorage.getItem('sholat_location_name');

                    if (savedLat && savedLng) {
                        this.currentLat = parseFloat(savedLat);
                        this.currentLng = parseFloat(savedLng);
                        if (savedLocation) {
                            this.displayLocation = savedLocation;
                            this.gpsSuccess = true;
                            this.locationStatus = 'Lokasi tersimpan: ' + savedLocation;
                        }
                        await this.fetchPrayerTimesByGPS(this.currentLat, this.currentLng);
                    } else {
                        // Belum ada data GPS, deteksi otomatis
                        await this.detectLocationGPS();
                    }

                    this.startCountdown();
                },

                async detectLocationGPS() {
                    if (!navigator.geolocation) {
                        this.locationStatus = 'Browser tidak mendukung GPS';
                        this.showToastMessage('Browser tidak mendukung GPS');
                        return;
                    }

                    this.detectingGPS = true;
                    this.locationStatus = 'Mencari lokasi Anda...';
                    this.showToastMessage('Mendeteksi lokasi...');

                    try {
                        const position = await new Promise((resolve, reject) => {
                            navigator.geolocation.getCurrentPosition(
                                (pos) => resolve(pos),
                                (err) => reject(err), {
                                    enableHighAccuracy: true,
                                    timeout: 15000,
                                    maximumAge: 0
                                }
                            );
                        });

                        this.currentLat = position.coords.latitude;
                        this.currentLng = position.coords.longitude;

                        await this.reverseGeocode(this.currentLat, this.currentLng);
                        await this.fetchPrayerTimesByGPS(this.currentLat, this.currentLng);

                        this.gpsSuccess = true;
                        localStorage.setItem('sholat_gps', 'true');
                        localStorage.setItem('sholat_lat', this.currentLat);
                        localStorage.setItem('sholat_lng', this.currentLng);

                        this.locationStatus = 'Lokasi terdeteksi: ' + this.displayLocation;
                        this.showToastMessage('Lokasi berhasil dideteksi!');

                    } catch (error) {
                        console.error('GPS Error:', error);
                        let errorMsg = 'Gagal mendeteksi lokasi. ';
                        if (error.code === 1) errorMsg += 'Izin lokasi ditolak.';
                        else if (error.code === 2) errorMsg += 'Posisi tidak tersedia.';
                        else if (error.code === 3) errorMsg += 'Timeout. Coba lagi.';
                        else errorMsg += 'Error tidak diketahui.';

                        this.locationStatus = errorMsg;
                        this.showToastMessage(errorMsg);

                        // Fallback: pakai jadwal default
                        this.displayLocation = 'Lokasi Default';
                        this.loading = false;
                    } finally {
                        this.detectingGPS = false;
                    }
                },

                async reverseGeocode(lat, lng) {
                    try {
                        const response = await fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' +
                            lat + '&lon=' + lng + '&zoom=10&addressdetails=1', {
                                headers: {
                                    'Accept-Language': 'id'
                                }
                            });
                        const data = await response.json();

                        let locationName = '';
                        const addr = data.address || {};

                        if (addr.city_district || addr.suburb) {
                            locationName = addr.city_district || addr.suburb;
                        } else if (addr.city || addr.town || addr.village) {
                            locationName = addr.city || addr.town || addr.village;
                        }

                        if (addr.county) {
                            locationName += ', ' + addr.county;
                        } else if (addr.state) {
                            locationName += ', ' + addr.state;
                        }

                        if (locationName) {
                            this.displayLocation = locationName;
                            localStorage.setItem('sholat_location_name', locationName);
                        } else {
                            this.displayLocation = lat.toFixed(4) + ', ' + lng.toFixed(4);
                        }
                    } catch (error) {
                        console.error('Reverse geocode error:', error);
                        this.displayLocation = lat.toFixed(4) + ', ' + lng.toFixed(4);
                    }
                },

                async fetchPrayerTimesByGPS(lat, lng) {
                    this.loading = true;
                    try {
                        const tanggal = new Date();
                        const year = tanggal.getFullYear();
                        const month = String(tanggal.getMonth() + 1).padStart(2, '0');
                        const day = String(tanggal.getDate()).padStart(2, '0');

                        const url = 'https://api.aladhan.com/v1/timings/' + year + '-' + month + '-' + day +
                            '?latitude=' + lat + '&longitude=' + lng + '&method=11&timezone=Asia/Jakarta';

                        const response = await fetch(url);
                        const data = await response.json();

                        if (data.code === 200 && data.data && data.data.timings) {
                            this.jadwalSholat = data.data.timings;
                            if (data.data.date && data.data.date.hijri) {
                                this.tanggalHijriah = data.data.date.hijri.day + ' ' + data.data.date.hijri.month.en +
                                    ' ' + data.data.date.hijri.year + ' H';
                            }
                            if (data.data.date && data.data.date.readable) {
                                this.tanggalMasehi = data.data.date.readable;
                            }
                            this.updateCountdown();
                        } else {
                            throw new Error('Format tidak dikenali');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.showToastMessage('Gagal mengambil jadwal: ' + error.message);
                    } finally {
                        this.loading = false;
                    }
                },

                updateTanggal() {
                    const now = new Date();
                    const options = {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    };
                    this.tanggalMasehi = now.toLocaleDateString('id-ID', options);
                    this.tanggalHijriah = now.toLocaleDateString('ar-SA', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }) + ' H';
                },

                formatWaktu(waktu24) {
                    if (!waktu24) return '--:--';
                    return waktu24.toString().split(' ')[0].substring(0, 5);
                },

                isNextPrayer(nama) {
                    return this.sholatBerikutnyaNama === nama;
                },

                startCountdown() {
                    if (this.countdownInterval) clearInterval(this.countdownInterval);
                    this.countdownInterval = setInterval(() => this.updateCountdown(), 1000);
                },

                updateCountdown() {
                    if (!this.jadwalSholat || Object.keys(this.jadwalSholat).length === 0) {
                        this.countdown = '00:00:00';
                        return;
                    }

                    const now = new Date();
                    const prayers = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                    let nextPrayerFound = false;

                    for (const nama of prayers) {
                        const waktuStr = this.jadwalSholat[nama];
                        if (!waktuStr) continue;

                        const waktu = this.formatWaktu(waktuStr);
                        const parts = waktu.split(':');
                        if (parts.length < 2) continue;

                        const prayerTime = new Date();
                        prayerTime.setHours(parseInt(parts[0], 10), parseInt(parts[1], 10), 0, 0);

                        if (prayerTime > now) {
                            this.sholatBerikutnyaNama = nama;
                            nextPrayerFound = true;

                            const diff = prayerTime.getTime() - now.getTime();
                            const hours = Math.floor(diff / (1000 * 60 * 60));
                            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                            this.countdown = String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0') + ':' +
                                String(seconds).padStart(2, '0');

                            if (diff <= 1000 && diff >= 0 && !this.adzanPlayed) {
                                this.aktifkanAlarmSholat();
                                this.adzanPlayed = true;
                                setTimeout(() => {
                                    this.adzanPlayed = false;
                                }, 300000);
                            }
                            break;
                        }
                    }

                    if (!nextPrayerFound) {
                        const waktuStr = this.jadwalSholat.Fajr;
                        if (!waktuStr) {
                            this.countdown = '00:00:00';
                            return;
                        }
                        const waktu = this.formatWaktu(waktuStr);
                        const jamMenit = waktu.split(':');
                        const jam = parseInt(jamMenit[0], 10);
                        const menit = parseInt(jamMenit[1], 10);
                        const prayerTimeBesok = new Date();
                        prayerTimeBesok.setDate(prayerTimeBesok.getDate() + 1);
                        prayerTimeBesok.setHours(jam, menit, 0, 0);
                        const diff = prayerTimeBesok.getTime() - now.getTime();
                        this.sholatBerikutnyaNama = 'Fajr';
                        const hours = Math.floor(diff / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                        this.countdown = String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0') + ':' +
                            String(seconds).padStart(2, '0');
                    }
                },

                updateAudioSource() {
                    const audio = this.$refs.audioAdzan;
                    if (!audio) return;
                    const source = this.adzanSources[this.selectedAdzan];
                    if (!source) return;
                    audio.src = source;
                    audio.load();
                },

                async aktifkanAlarmSholat() {
                    const namaSholat = this.translateNama(this.sholatBerikutnyaNama);

                    const audio = this.$refs.audioAdzan;
                    if (audio) {
                        audio.currentTime = 0;
                        audio.play().catch(() => {});
                    }

                    if (LocalNotif) {
                        try {
                            await LocalNotif.schedule({
                                notifications: [{
                                    title: 'Waktunya Sholat ' + namaSholat,
                                    body: 'Segera laksanakan sholat ' + namaSholat + ' di ' + this
                                        .displayLocation,
                                    id: Date.now(),
                                    channelId: 'alarm_channel',
                                    schedule: {
                                        at: new Date(Date.now() + 1000)
                                    },
                                    sound: 'default',
                                    extra: {
                                        prayer: namaSholat
                                    }
                                }]
                            });
                            this.showToastMessage('Waktunya ' + namaSholat + '!');
                        } catch (error) {
                            console.error("Gagal mengirim notifikasi:", error);
                            this.showToastMessage('Waktunya ' + namaSholat + '!');
                        }
                    } else {
                        this.showToastMessage('Waktunya ' + namaSholat + '!');
                    }
                },

                toggleAdzan() {
                    const audio = this.$refs.audioAdzan;
                    if (!audio) return;
                    if (this.isPlaying) {
                        audio.pause();
                        audio.currentTime = 0;
                        this.isPlaying = false;
                        this.showToastMessage('Adzan dihentikan');
                    } else {
                        audio.loop = true;
                        audio.play().then(() => {
                            this.isPlaying = true;
                            this.showToastMessage('Adzan diputar...');
                        }).catch(() => {
                            this.showToastMessage('Gagal memutar adzan');
                        });
                    }
                },

                toggleMute() {
                    const audio = this.$refs.audioAdzan;
                    if (!audio) return;
                    this.isMuted = !this.isMuted;
                    audio.muted = this.isMuted;
                    this.showToastMessage(this.isMuted ? 'Muted' : 'Unmuted');
                },

                gantiAdzan() {
                    const wasPlaying = this.isPlaying;
                    if (wasPlaying) {
                        const audio = this.$refs.audioAdzan;
                        if (audio) {
                            audio.pause();
                            audio.currentTime = 0;
                        }
                        this.isPlaying = false;
                    }
                    localStorage.setItem('selected_adzan', this.selectedAdzan);
                    this.updateAudioSource();
                    if (wasPlaying) setTimeout(() => this.toggleAdzan(), 300);
                    this.showToastMessage('Suara adzan disimpan: ' + this.selectedAdzan);
                },

                translateNama(nama) {
                    const map = {
                        Fajr: 'Subuh',
                        Dhuhr: 'Dzuhur',
                        Asr: 'Ashar',
                        Maghrib: 'Maghrib',
                        Isha: 'Isya'
                    };
                    return map[nama] || nama;
                },

                showToastMessage(message) {
                    this.toastMessage = message;
                    this.showToast = true;
                    if (this.toastTimeout) clearTimeout(this.toastTimeout);
                    this.toastTimeout = setTimeout(() => {
                        this.showToast = false;
                    }, 3000);
                }
            };
        }
    </script>
@endpush
