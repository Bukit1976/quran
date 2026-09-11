@extends('layouts.app')

@section('title', 'Penerjemah AI & Koreksi')

@section('content')
    <div class="mx-auto max-w-4xl" x-data="translatorApp()">
        <div
            class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-xl dark:border-gray-700 dark:bg-gray-800">

            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6 text-white">
                <h2 class="flex items-center gap-3 text-2xl font-bold">
                    <i class="fas fa-language text-3xl"></i>
                    Penerjemah & Koreksi Cerdas
                </h2>
                <p class="mt-2 text-sm text-emerald-100">
                    Ucapkan atau ketik teks, dapatkan terjemahan akurat dan koreksi tata bahasa secara otomatis.
                </p>
            </div>

            <div class="space-y-6 p-6">
                <!-- Language Selectors -->
                <div class="grid grid-cols-1 items-center gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Bahasa Asal</label>
                        <select x-model="sourceLang"
                            class="w-full rounded-xl border-gray-300 p-3 shadow-sm transition-all focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="id">🇮🇩 Indonesia</option>
                            <option value="en">🇬🇧 Inggris (English)</option>
                            <option value="ar">🇸🇦 Arab (العربية)</option>
                            <option value="ja">🇯🇵 Jepang (日本語)</option>
                            <option value="ko">🇰🇷 Korea (한국어)</option>
                            <option value="fr">🇫🇷 Prancis (Français)</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="flex-1">
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Bahasa
                                Tujuan</label>
                            <select x-model="targetLang"
                                class="w-full rounded-xl border-gray-300 p-3 shadow-sm transition-all focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="en">🇬🇧 Inggris (English)</option>
                                <option value="id">🇮🇩 Indonesia</option>
                                <option value="ar">🇸🇦 Arab (العربية)</option>
                                <option value="ja">🇯🇵 Jepang (日本語)</option>
                                <option value="ko">🇰🇷 Korea (한국어)</option>
                                <option value="fr">🇫🇷 Prancis (Français)</option>
                            </select>
                        </div>
                        <button @click="swapLanguages()"
                            class="mt-6 rounded-full bg-gray-100 p-3 text-gray-600 transition-all hover:bg-emerald-100 hover:text-emerald-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-emerald-900"
                            title="Tukar Bahasa">
                            <i class="fas fa-exchange-alt"></i>
                        </button>
                    </div>
                </div>

                <!-- Input Area -->
                <div class="relative">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Teks Masukan</label>
                    <div class="relative">
                        <textarea x-model="inputText" rows="4"
                            class="w-full resize-none rounded-xl border-gray-300 p-4 pr-14 shadow-sm transition-all focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            placeholder="Ketik atau tekan tombol mikrofon untuk berbicara..."></textarea>

                        <!-- Mic Button -->
                        <button @click="toggleSpeechRecognition()"
                            :class="isListening ? 'bg-red-500 animate-pulse text-white' :
                                'bg-emerald-500 hover:bg-emerald-600 text-white'"
                            class="absolute bottom-4 right-4 rounded-full p-3 shadow-lg transition-all duration-300"
                            title="Tekan untuk berbicara">
                            <i class="fas fa-microphone text-xl"></i>
                        </button>
                    </div>
                    <p x-show="isListening" class="mt-2 flex items-center gap-2 text-sm font-medium text-red-500">
                        <span class="h-2 w-2 animate-ping rounded-full bg-red-500"></span>
                        Mendengarkan... (Silakan bicara)
                    </p>
                </div>

                <!-- Action Button -->
                <button @click="processTranslation()" :disabled="isLoading || !inputText.trim()"
                    class="flex w-full transform items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 py-4 font-bold text-white shadow-lg transition-all hover:scale-[1.01] hover:from-emerald-600 hover:to-teal-700 disabled:cursor-not-allowed disabled:opacity-50">
                    <i x-show="isLoading" class="fas fa-circle-notch fa-spin"></i>
                    <span x-text="isLoading ? 'Menerjemahkan & Mengecek...' : 'Terjemahkan & Koreksi'"></span>
                </button>

                <!-- Result Area -->
                <div x-show="translation" x-transition class="space-y-4">

                    <!-- Correction Box (Muncul jika ada kesalahan) -->
                    <div x-show="correction" x-transition
                        class="rounded-r-xl border-l-4 border-amber-400 bg-amber-50 p-4 dark:bg-amber-900/20">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-lightbulb mt-1 text-lg text-amber-500"></i>
                            <div>
                                <h4 class="text-sm font-semibold text-amber-800 dark:text-amber-300">Saran Perbaikan</h4>
                                <p class="mt-1 leading-relaxed text-amber-700 dark:text-amber-200" x-text="correction"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Translation Box -->
                    <div
                        class="group relative rounded-xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-600 dark:bg-gray-700/50">
                        <div class="mb-3 flex items-start justify-between">
                            <h4 class="flex items-center gap-2 font-semibold text-gray-700 dark:text-gray-200">
                                <i class="fas fa-check-circle text-emerald-500"></i>
                                Hasil Terjemahan
                            </h4>
                            <button @click="speakText(translation)"
                                class="rounded-full p-2 text-gray-400 transition-colors hover:bg-emerald-50 hover:text-emerald-500 dark:hover:bg-emerald-900/30"
                                title="Dengarkan Audio">
                                <i class="fas fa-volume-up text-xl"></i>
                            </button>
                        </div>
                        <p class="text-lg leading-relaxed text-gray-800 dark:text-gray-100" x-text="translation"></p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function translatorApp() {
            return {
                sourceLang: 'id',
                targetLang: 'en',
                inputText: '',
                translation: '',
                correction: '',
                isLoading: false,
                isListening: false,
                recognition: null,

                init() {
                    // Inisialisasi Web Speech API (Bawaan Browser, Gratis)
                    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                        this.recognition = new SpeechRecognition();
                        this.recognition.continuous = false;
                        this.recognition.interimResults = false;
                        this.recognition.lang = this.getSpeechLang(this.sourceLang);

                        this.recognition.onresult = (event) => {
                            const transcript = event.results[0][0].transcript;
                            this.inputText = transcript;
                            this.isListening = false;
                        };

                        this.recognition.onerror = (event) => {
                            console.error('Speech recognition error', event.error);
                            this.isListening = false;
                            alert('Gagal mengenali suara. Pastikan izin mikrofon sudah diberikan.');
                        };

                        this.recognition.onend = () => {
                            this.isListening = false;
                        };
                    }
                },

                getSpeechLang(langCode) {
                    const map = {
                        'id': 'id-ID',
                        'en': 'en-US',
                        'ar': 'ar-SA',
                        'ja': 'ja-JP',
                        'ko': 'ko-KR',
                        'fr': 'fr-FR'
                    };
                    return map[langCode] || 'id-ID';
                },

                toggleSpeechRecognition() {
                    if (!this.recognition) {
                        alert('Browser Anda tidak mendukung fitur suara. Gunakan Chrome/Edge/Safari terbaru.');
                        return;
                    }

                    if (this.isListening) {
                        this.recognition.stop();
                        this.isListening = false;
                    } else {
                        this.recognition.lang = this.getSpeechLang(this.sourceLang);
                        this.recognition.start();
                        this.isListening = true;
                    }
                },

                swapLanguages() {
                    let temp = this.sourceLang;
                    this.sourceLang = this.targetLang;
                    this.targetLang = temp;
                },

                async processTranslation() {
                    if (!this.inputText.trim()) return;

                    this.isLoading = true;
                    this.correction = '';
                    this.translation = '';

                    try {
                        const response = await fetch('{{ route('translate.process') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                text: this.inputText,
                                source_lang: this.sourceLang,
                                target_lang: this.targetLang
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.correction = data.correction;
                            this.translation = data.translation;

                            // Opsional: Langsung putar audio setelah berhasil
                            // setTimeout(() => this.speakText(this.translation), 500);
                        } else {
                            alert('Gagal: ' + data.message);
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Terjadi kesalahan jaringan.');
                    } finally {
                        this.isLoading = false;
                    }
                },

                speakText(text) {
                    if (!text) return;

                    window.speechSynthesis.cancel(); // Hentikan audio sebelumnya jika ada

                    const utterance = new SpeechSynthesisUtterance(text);
                    utterance.lang = this.getSpeechLang(this.targetLang);
                    utterance.rate = 0.9; // Sedikit lebih lambat agar jelas
                    utterance.pitch = 1;

                    // Coba cari voice native yang sesuai
                    const voices = window.speechSynthesis.getVoices();
                    const targetVoice = voices.find(v => v.lang.startsWith(this.targetLang));
                    if (targetVoice) {
                        utterance.voice = targetVoice;
                    }

                    window.speechSynthesis.speak(utterance);
                }
            }
        }
    </script>
@endsection
