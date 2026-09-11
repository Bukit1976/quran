@extends('layouts.app')

@section('title', 'Alarm & Pengingat')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="container mx-auto px-4 py-8 max-w-6xl">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Alarm & Pengingat</h1>
                <p class="text-gray-600 dark:text-gray-400">Atur pengingat hafalan atau ibadah dengan nada dering pilihan Anda</p>
            </div>

            @php
                $alarmsJson = $alarms->map(function ($alarm) {
                    return [
                        'id' => $alarm->id,
                        'time' => $alarm->time,
                        'label' => $alarm->label ?? '',
                        'audio_path' => $alarm->audio_path ? asset('storage/' . $alarm->audio_path) : '',
                        'is_active' => (bool) $alarm->is_active,
                    ];
                });
            @endphp

            <div x-data="alarmManager({{ $alarmsJson->toJson() }})" x-init="init()" class="space-y-6">

                {{-- Audio Unlock Warning --}}
                <div x-show="!audioUnlocked" x-transition class="bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-300 dark:border-amber-700 rounded-2xl p-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-amber-500 text-white p-3 rounded-full animate-pulse">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-amber-900 dark:text-amber-100">Aktifkan Notifikasi Alarm</h3>
                                <p class="text-sm text-amber-700 dark:text-amber-300">Izinkan notifikasi agar alarm bisa membunyikan HP meski layar mati!</p>
                            </div>
                        </div>
                        <button @click="enableNotifications()" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-6 py-3 rounded-xl transition-all active:scale-95 w-full sm:w-auto">
                            Aktifkan Sekarang
                        </button>
                    </div>
                </div>

                {{-- Form Tambah/Edit Alarm --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6" :class="{ 'ring-4 ring-emerald-500': isEditing }">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span x-text="isEditing ? 'Edit Alarm' : 'Tambah Alarm Baru'"></span>
                    </h2>

                    <form action="{{ route('alarm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="alarm_id" :value="editId">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Waktu <span class="text-red-500">*</span></label>
                                <input type="time" name="time" x-model="formData.time" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                                @error('time')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Label (Opsional)</label>
                                <input type="text" name="label" x-model="formData.label" placeholder="Contoh: Bangun Tahajud" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                                @error('label')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nada Dering Custom (MP3/WAV/M4A/AAC/FLAC, Maks 50MB)</label>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="file" name="audio" accept="audio/*" @change="handleFileSelect" class="flex-1 px-4 py-3 rounded-xl border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-100 dark:file:bg-emerald-900/30 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-700 dark:file:text-emerald-400 hover:file:bg-emerald-200 dark:hover:file:bg-emerald-900/50 transition-all">
                                <button type="button" @click="testAudio" :disabled="!formData.audioFile && !currentAudioPath" class="bg-amber-500 hover:bg-amber-600 disabled:bg-gray-300 dark:disabled:bg-gray-600 disabled:cursor-not-allowed text-white font-semibold px-6 py-3 rounded-xl transition-all whitespace-nowrap">Test Audio</button>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400" x-show="fileName" x-text="'File terpilih: ' + fileName"></p>
                            @error('audio')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 pt-4">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all active:scale-95">
                                <span x-text="isEditing ? 'Simpan Perubahan' : 'Simpan Alarm'"></span>
                            </button>
                            <button type="button" x-show="isEditing" @click="cancelEdit" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-3 px-6 rounded-xl transition-all active:scale-95">Batal</button>
                        </div>
                    </form>
                </div>

                {{-- Daftar Alarm --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Daftar Alarm</h2>
                    <template x-for="alarm in alarmsList" :key="alarm.id">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 mb-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all" :class="{ 'opacity-60': !alarm.is_active }">
                            <div class="flex items-center gap-4 flex-1">
                                <div @click="toggleAlarm(alarm.id)" class="relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer rounded-full transition-colors duration-200" :class="alarm.is_active ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-gray-600'">
                                    <div class="absolute top-0.5 left-0.5 bg-white rounded-full h-6 w-6 shadow transition-transform duration-200" :style="alarm.is_active ? 'transform: translateX(20px)' : 'transform: translateX(0)'"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white" x-text="formatTime(alarm.time)"></p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <span x-text="alarm.label || 'Tanpa Label'"></span>
                                        <span x-show="alarm.audio_path" class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300">Custom</span>
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                        Status: <span :class="alarm.is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500'" x-text="alarm.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <button type="button" @click="startEdit(alarm.id)" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    <span class="text-sm">Edit</span>
                                </button>
                                <form :action="'{{ url('/alarm') }}/' + alarm.id" method="POST" onsubmit="return confirm('Yakin ingin menghapus alarm ini?')" class="flex-1 sm:flex-none">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        <span class="text-sm">Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </template>
                    <div x-show="alarmsList.length === 0" class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg">Belum ada alarm yang diatur</p>
                    </div>
                </div>
            </div>
        </div>

        <audio id="alarmAudio" preload="auto" playsinline></audio>

        {{-- MODAL ALARM --}}
        <div id="alarmModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/90 via-teal-900/90 to-cyan-900/90 backdrop-blur-xl"></div>
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="particle particle-1"></div><div class="particle particle-2"></div><div class="particle particle-3"></div>
                <div class="particle particle-4"></div><div class="particle particle-5"></div><div class="particle particle-6"></div>
            </div>
            <div class="relative z-10 w-full max-w-md">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="pulse-ring pulse-ring-1"></div><div class="pulse-ring pulse-ring-2"></div><div class="pulse-ring pulse-ring-3"></div>
                </div>
                <div class="alarm-card relative overflow-hidden rounded-3xl p-8 text-center">
                    <div class="glow-border"></div>
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-white to-transparent opacity-60"></div>
                    <div class="relative mx-auto mb-6">
                        <div class="bell-container relative inline-block">
                            <div class="bell-glow"></div>
                            <div class="bell-icon-wrapper">
                                <svg class="bell-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-2 drop-shadow-lg" id="modalLabel">Waktunya Alarm!</h3>
                    <div class="relative inline-block mb-8">
                        <div class="time-glow"></div>
                        <p class="time-display text-5xl font-mono font-bold text-white tracking-wider" id="modalTime">00:00</p>
                    </div>
                    <div class="flex items-center justify-center gap-2 mb-6">
                        <div class="h-px w-12 bg-gradient-to-r from-transparent to-white/50"></div>
                        <div class="w-2 h-2 rounded-full bg-white/70 animate-pulse"></div>
                        <div class="h-px w-12 bg-gradient-to-l from-transparent to-white/50"></div>
                    </div>
                    <div class="space-y-3">
                        <button onclick="stopAlarm()" class="group relative w-full overflow-hidden rounded-2xl bg-white py-4 px-6 font-bold text-emerald-600 shadow-2xl transition-all hover:scale-105 active:scale-95">
                            <span class="relative flex items-center justify-center gap-2 text-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                Matikan Alarm
                            </span>
                        </button>
                        <button onclick="snoozeAlarm()" class="group relative w-full overflow-hidden rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 py-3 px-6 font-semibold text-white transition-all hover:bg-white/20 hover:scale-105 active:scale-95">
                            <span class="relative flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Tunda 5 Menit
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentAudioElement = null;

        function alarmManager(initialAlarms) {
            return {
                alarmsList: initialAlarms,
                isEditing: false,
                editId: null,
                formData: { time: '', label: '', audioFile: null },
                fileName: '',
                currentAudioPath: '',
                audioUnlocked: localStorage.getItem('alarm_audio_unlocked') === 'true',
                alarmRinging: false,
                ringingLabel: '',
                ringingTime: '',
                lastTriggeredMinute: null,
                checkInterval: null,
                audioElement: null,
                currentAlarmId: null,

                async init() {
                    this.audioElement = document.getElementById('alarmAudio');
                    currentAudioElement = this.audioElement;
                    if (this.audioElement) {
                        this.audioElement.preload = 'auto';
                        this.audioElement.volume = 0.01;
                    }
                    await this.requestPermissions();
                    await this.scheduleAllAlarms();
                    this.startChecking();
                },

                async requestPermissions() {
                    try {
                        const { LocalNotifications } = await import('@capacitor/local-notifications');
                        await LocalNotifications.requestPermissions();
                    } catch (error) {
                        console.error('Failed to request permissions:', error);
                    }
                },

                async enableNotifications() {
                    await this.requestPermissions();
                    this.audioUnlocked = true;
                    localStorage.setItem('alarm_audio_unlocked', 'true');
                    await this.scheduleAllAlarms();
                    this.showToast('✅ Notifikasi alarm berhasil diaktifkan!');
                },

                async scheduleAllAlarms() {
                    try {
                        const { LocalNotifications } = await import('@capacitor/local-notifications');
                        await LocalNotifications.cancelAll();

                        const notifications = [];
                        const now = new Date();

                        for (const alarm of this.alarmsList) {
                            if (!alarm.is_active) continue;

                            const [hours, minutes] = alarm.time.split(':').map(Number);
                            let scheduleTime = new Date();
                            scheduleTime.setHours(hours, minutes, 0, 0);

                            if (scheduleTime <= now) {
                                scheduleTime.setDate(scheduleTime.getDate() + 1);
                            }

                            notifications.push({
                                title: '🕌 Waktunya Sholat!',
                                body: alarm.label || 'Segera tunaikan ibadah Anda.',
                                id: alarm.id,
                                schedule: { at: scheduleTime, repeats: false },
                                // PENTING: 'adzan' adalah nama file di folder android/app/src/main/res/raw/adzan.mp3
                                // Android TIDAK BISA memutar URL internet saat layar mati.
                                sound: 'adzan',
                                ongoing: true,    // Mencegah Android membunuh notifikasi
                                priority: 5,      // Prioritas MAKSIMAL (Memaksa layar menyala & bergetar)
                                visibility: 1,    // Tampilkan di layar kunci (Lock Screen)
                                actionTypeId: 'alarm',
                                extra: {
                                    alarmId: alarm.id,
                                    label: alarm.label,
                                    time: alarm.time,
                                    audioPath: alarm.audio_path // Disimpan untuk diputar saat user membuka aplikasi
                                }
                            });
                        }

                        if (notifications.length > 0) {
                            await LocalNotifications.schedule({ notifications: notifications });
                            this.showToast(`✅ ${notifications.length} alarm dijadwalkan dengan Prioritas Tinggi`);
                        }
                    } catch (error) {
                        console.error('Gagal menjadwalkan alarm:', error);
                    }
                },

                formatTime(time) { return time ? time.substring(0, 5) : '--:--'; },

                async unlockAudio() {
                    if (!this.audioElement) return;
                    try {
                        const beepData = 'data:audio/wav;base64,UklGRi4AAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQAAAAA=';
                        this.audioElement.src = beepData;
                        this.audioElement.volume = 0.5;
                        await this.audioElement.play();
                        this.audioElement.pause();
                        this.audioElement.currentTime = 0;
                        this.audioElement.volume = 1.0;
                        this.audioUnlocked = true;
                        localStorage.setItem('alarm_audio_unlocked', 'true');
                        this.showToast('✅ Suara alarm berhasil diaktifkan!');
                    } catch (error) {
                        alert('Gagal mengaktifkan suara: ' + error.message);
                    }
                },

                startEdit(id) {
                    const alarm = this.alarmsList.find(a => a.id === id);
                    if (!alarm) return;
                    this.isEditing = true;
                    this.editId = alarm.id;
                    this.formData.time = this.formatTime(alarm.time);
                    this.formData.label = alarm.label || '';
                    this.formData.audioFile = null;
                    this.currentAudioPath = alarm.audio_path;
                    this.fileName = alarm.audio_path ? 'Audio tersimpan di server' : '';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                cancelEdit() {
                    this.isEditing = false;
                    this.editId = null;
                    this.formData = { time: '', label: '', audioFile: null };
                    this.fileName = '';
                    this.currentAudioPath = '';
                    const fileInput = document.querySelector('input[name="audio"]');
                    if (fileInput) fileInput.value = '';
                },

                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.formData.audioFile = file;
                        this.fileName = file.name;
                        this.currentAudioPath = URL.createObjectURL(file);
                    }
                },

                async testAudio() {
                    if (!this.audioUnlocked) { alert('Silakan klik "Aktifkan Suara" terlebih dahulu!'); return; }
                    if (!this.currentAudioPath && !this.formData.audioFile) { alert('Silakan pilih file audio terlebih dahulu!'); return; }
                    try {
                        this.audioElement.src = this.currentAudioPath;
                        this.audioElement.volume = 1.0;
                        this.audioElement.loop = false;
                        await this.audioElement.play();
                        this.showToast('🔊 Audio sedang diputar...');
                        setTimeout(() => { this.audioElement.pause(); this.audioElement.currentTime = 0; }, 3000);
                    } catch (error) { alert('Gagal memutar audio: ' + error.message); }
                },

                async toggleAlarm(id) {
                    const alarm = this.alarmsList.find(a => a.id === id);
                    if (!alarm) return;
                    try {
                        alarm.is_active = !alarm.is_active;
                        const response = await fetch(`/alarm/${id}/toggle`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                            body: JSON.stringify({ is_active: alarm.is_active })
                        });
                        if (response.ok) {
                            await this.scheduleAllAlarms();
                            this.showToast(alarm.is_active ? '✅ Alarm diaktifkan' : '⏸️ Alarm dinonaktifkan');
                        } else { alarm.is_active = !alarm.is_active; }
                    } catch (error) { alarm.is_active = !alarm.is_active; }
                },

                startChecking() {
                    if (this.checkInterval) clearInterval(this.checkInterval);
                    this.checkInterval = setInterval(() => this.checkAlarms(), 1000);
                },

                checkAlarms() {
                    if (this.alarmRinging || !this.audioUnlocked) return;
                    const now = new Date();
                    const currentHH = String(now.getHours()).padStart(2, '0');
                    const currentMM = String(now.getMinutes()).padStart(2, '0');
                    const currentSS = now.getSeconds();
                    const currentTimeKey = `${currentHH}:${currentMM}`;
                    if (currentSS > 5 || this.lastTriggeredMinute === currentTimeKey) return;

                    this.alarmsList.forEach(alarm => {
                        if (alarm.is_active && this.formatTime(alarm.time) === currentTimeKey) {
                            this.lastTriggeredMinute = currentTimeKey;
                            this.currentAlarmId = alarm.id;
                            this.triggerAlarm(alarm.label || 'Waktunya Alarm!', this.formatTime(alarm.time), alarm.audio_path);
                        }
                    });
                },

                async triggerAlarm(label, time, audioPath) {
                    if (!this.audioUnlocked) return;
                    this.alarmRinging = true;
                    this.ringingLabel = label;
                    this.ringingTime = time;

                    const modal = document.getElementById('alarmModal');
                    const modalLabel = document.getElementById('modalLabel');
                    const modalTime = document.getElementById('modalTime');
                    if (modalLabel) modalLabel.textContent = label;
                    if (modalTime) modalTime.textContent = time;
                    if (modal) modal.style.display = 'flex';

                    let audioUrl = audioPath || 'https://www.soundjay.com/misc/sounds/bell-ringing-05.wav';
                    try {
                        this.audioElement.src = audioUrl;
                        this.audioElement.loop = true;
                        this.audioElement.volume = 1.0;
                        await this.audioElement.play();
                    } catch (error) { console.error('Audio play failed:', error); }
                },

                showToast(message) {
                    const toast = document.createElement('div');
                    toast.className = 'fixed bottom-6 right-6 z-[100] bg-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl';
                    toast.innerHTML = `<p class="font-semibold">${message}</p>`;
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);
                }
            };
        }

        function stopAlarm() {
            const modal = document.getElementById('alarmModal');
            if (modal) modal.style.display = 'none';
            if (currentAudioElement) { currentAudioElement.pause(); currentAudioElement.currentTime = 0; currentAudioElement.loop = false; }
            const alpineComponent = document.querySelector('[x-data]');
            if (alpineComponent && alpineComponent.__x) { alpineComponent.__x.$data.alarmRinging = false; }
        }

        function snoozeAlarm() { stopAlarm(); alert('⏰ Alarm ditunda 5 menit'); }
    </script>
@endpush

@push('styles')
    <style>
        [x-cloak] { display: none !important; }
        .particle { position: absolute; border-radius: 50%; background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%); animation: float-particle 8s infinite ease-in-out; }
        .particle-1 { width: 100px; height: 100px; top: 10%; left: 10%; animation-delay: 0s; }
        .particle-2 { width: 150px; height: 150px; top: 60%; left: 80%; animation-delay: 1s; }
        .particle-3 { width: 80px; height: 80px; top: 80%; left: 20%; animation-delay: 2s; }
        .particle-4 { width: 120px; height: 120px; top: 30%; left: 70%; animation-delay: 3s; }
        .particle-5 { width: 90px; height: 90px; top: 50%; left: 40%; animation-delay: 4s; }
        .particle-6 { width: 110px; height: 110px; top: 20%; left: 50%; animation-delay: 5s; }
        @keyframes float-particle { 0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.3; } 50% { transform: translate(-30px, 50px) scale(0.8); opacity: 0.4; } }
        .pulse-ring { position: absolute; border-radius: 50%; border: 2px solid rgba(255, 255, 255, 0.3); animation: pulse-ring 2s infinite ease-out; }
        .pulse-ring-1 { width: 300px; height: 300px; animation-delay: 0s; }
        .pulse-ring-2 { width: 300px; height: 300px; animation-delay: 0.5s; }
        .pulse-ring-3 { width: 300px; height: 300px; animation-delay: 1s; }
        @keyframes pulse-ring { 0% { transform: scale(0.5); opacity: 1; } 100% { transform: scale(2); opacity: 0; } }
        .alarm-card { background: linear-gradient(135deg, rgba(16, 185, 129, 0.95) 0%, rgba(20, 184, 166, 0.95) 50%, rgba(6, 182, 212, 0.95) 100%); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 60px rgba(16, 185, 129, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.2); animation: card-entrance 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); }
        @keyframes card-entrance { 0% { transform: scale(0.5) translateY(50px); opacity: 0; } 100% { transform: scale(1) translateY(0); opacity: 1; } }
        .glow-border { position: absolute; inset: 0; border-radius: 1.5rem; padding: 2px; background: linear-gradient(45deg, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.8)); -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0); -webkit-mask-composite: xor; mask-composite: exclude; animation: glow-rotate 3s linear infinite; pointer-events: none; }
        @keyframes glow-rotate { 0% { filter: hue-rotate(0deg); } 100% { filter: hue-rotate(360deg); } }
        .bell-container { width: 100px; height: 100px; }
        .bell-glow { position: absolute; inset: 0; border-radius: 50%; background: radial-gradient(circle, rgba(255, 255, 255, 0.6) 0%, transparent 70%); animation: bell-glow-pulse 1.5s infinite ease-in-out; }
        @keyframes bell-glow-pulse { 0%, 100% { transform: scale(1); opacity: 0.6; } 50% { transform: scale(1.3); opacity: 0; } }
        .bell-icon-wrapper { position: relative; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); border: 2px solid rgba(255, 255, 255, 0.3); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); }
        .bell-icon { width: 50px; height: 50px; color: white; animation: bell-ring 1s infinite ease-in-out; transform-origin: top center; filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3)); }
        @keyframes bell-ring { 0%, 100% { transform: rotate(0deg); } 10%, 30%, 50%, 70%, 90% { transform: rotate(15deg); } 20%, 40%, 60%, 80% { transform: rotate(-15deg); } }
        .time-display { text-shadow: 0 0 10px rgba(255, 255, 255, 0.8), 0 0 20px rgba(255, 255, 255, 0.6), 0 0 30px rgba(255, 255, 255, 0.4); animation: time-pulse 2s infinite ease-in-out; }
        .time-glow { position: absolute; inset: -10px; background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%); animation: time-glow-pulse 2s infinite ease-in-out; pointer-events: none; }
        @keyframes time-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
        @keyframes time-glow-pulse { 0%, 100% { opacity: 0.5; transform: scale(1); } 50% { opacity: 1; transform: scale(1.2); } }
        @media (max-width: 640px) {
            .alarm-card { padding: 1.5rem; }
            .time-display { font-size: 3rem; }
            .bell-container { width: 80px; height: 80px; }
            .bell-icon { width: 40px; height: 40px; }
            .pulse-ring-1, .pulse-ring-2, .pulse-ring-3 { width: 200px; height: 200px; }
        }
    </style>
@endpush
