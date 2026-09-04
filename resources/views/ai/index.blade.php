@extends('layouts.app')

@section('title', 'AI Pendamping Hafalan')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 sm:text-2xl">AI Pendamping Hafalan</h2>
@endsection

@section('content')
    <div
        class="mx-auto flex h-[600px] max-w-3xl flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
        <div class="flex items-center justify-between bg-gradient-to-r from-emerald-500 to-teal-600 p-4">
            <div class="flex items-center space-x-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-xl">🤖</div>
                <div>
                    <h3 class="font-bold text-white">Ustadz AI</h3>
                    <p class="text-xs text-emerald-100">Tanyakan ayat, tema, atau nama surah</p>
                </div>
            </div>
            <div class="flex gap-2">
                {{-- TOMBOL CLEAR --}}
                <button onclick="clearChat()"
                    class="flex items-center gap-1 rounded-lg bg-white/20 px-3 py-1 text-xs text-white transition hover:bg-white/30">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Clear
                </button>

                {{-- TOMBOL CLOSE/KELUAR --}}
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-1 rounded-lg bg-red-500/80 px-3 py-1 text-xs text-white transition hover:bg-red-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close
                </a>
            </div>
        </div>

        <div id="chatArea" class="flex-1 space-y-4 overflow-y-auto bg-gray-50 p-4 dark:bg-gray-900">
            <div class="flex items-start space-x-2">
                <div
                    class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-emerald-500 text-sm text-white">
                    🤖
                </div>
                <div
                    class="max-w-[80%] rounded-lg rounded-tl-none border border-gray-200 bg-white p-3 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        Assalamu'alaikum! Saya AI Pendamping Anda.
                        <br><br>
                        💡 <strong>Saya bisa membantu:</strong>
                        <br>• Mencari ayat tentang tema tertentu (sabar, doa, surga)
                        <br>• Informasi surah (Yasin, Al-Fatihah, Al-Baqarah)
                        <br>• Mencari ayat berdasarkan kata kunci
                        <br><br>
                        Silakan tanyakan sesuatu!
                    </p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
            <form id="chatForm" class="flex space-x-2">
                @csrf
                <input type="text" id="userInput" placeholder="Contoh: ayat tentang sabar..."
                    class="flex-1 rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    required>
                <button type="submit" id="sendBtn"
                    class="flex items-center rounded-lg bg-emerald-500 px-6 py-2 font-medium text-white transition hover:bg-emerald-600 disabled:opacity-50">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
            <div class="mt-2 flex flex-wrap gap-2">
                <button onclick="quickAsk('selamat pagi')"
                    class="rounded-full bg-emerald-100 px-3 py-1 text-xs text-emerald-700 hover:bg-emerald-200 dark:bg-emerald-900 dark:text-emerald-300">
                    ☀️ Selamat Pagi
                </button>
                <button onclick="quickAsk('ayat tentang sabar')"
                    class="rounded-full bg-blue-100 px-3 py-1 text-xs text-blue-700 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300">
                    📖 Ayat Sabar
                </button>
                <button onclick="quickAsk('surah Yasin')"
                    class="rounded-full bg-purple-100 px-3 py-1 text-xs text-purple-700 hover:bg-purple-200 dark:bg-purple-900 dark:text-purple-300">
                    📗 Surah Yasin
                </button>
                <button onclick="quickAsk('tentang doa')"
                    class="rounded-full bg-yellow-100 px-3 py-1 text-xs text-yellow-700 hover:bg-yellow-200 dark:bg-yellow-900 dark:text-yellow-300">
                    🤲 Tentang Doa
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const chatForm = document.getElementById('chatForm');
        const chatArea = document.getElementById('chatArea');
        const userInput = document.getElementById('userInput');
        const sendBtn = document.getElementById('sendBtn');

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const pertanyaan = userInput.value.trim();
            if (!pertanyaan) return;

            appendMessage(pertanyaan, 'user');
            userInput.value = '';
            setLoading(true);

            const loadingId = appendLoadingMessage();

            fetch('{{ route('ai.chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        pertanyaan: pertanyaan
                    })
                })
                .then(response => response.json())
                .then(data => {
                    removeLoadingMessage(loadingId);
                    const formattedJawaban = formatResponse(data.jawaban);
                    appendMessage(formattedJawaban, 'ai');
                    setLoading(false);
                })
                .catch(error => {
                    removeLoadingMessage(loadingId);
                    appendMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi.', 'ai');
                    setLoading(false);
                });
        });

        function quickAsk(text) {
            userInput.value = text;
            chatForm.dispatchEvent(new Event('submit'));
        }

        function setLoading(isLoading) {
            sendBtn.disabled = isLoading;
            userInput.disabled = isLoading;
            if (isLoading) {
                userInput.placeholder = 'Sedang mencari...';
            } else {
                userInput.placeholder = 'Contoh: ayat tentang sabar...';
            }
        }

        function appendLoadingMessage() {
            const id = 'loading-' + Date.now();
            const div = document.createElement('div');
            div.id = id;
            div.className = 'flex items-start space-x-2';
            div.innerHTML = `
                <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white text-sm flex-shrink-0">🤖</div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg rounded-tl-none shadow-sm border border-gray-200 dark:border-gray-700 max-w-[80%]">
                    <div class="flex space-x-2">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            `;
            chatArea.appendChild(div);
            chatArea.scrollTop = chatArea.scrollHeight;
            return id;
        }

        function removeLoadingMessage(id) {
            const element = document.getElementById(id);
            if (element) {
                element.remove();
            }
        }

        function appendMessage(text, sender) {
            const div = document.createElement('div');
            div.className = 'flex items-start space-x-2 ' + (sender === 'user' ? 'flex-row-reverse space-x-reverse' : '');

            if (sender === 'user') {
                div.innerHTML = `
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm flex-shrink-0"></div>
                    <div class="bg-blue-500 text-white p-3 rounded-lg rounded-tr-none shadow-sm max-w-[80%]">
                        <p class="text-sm">${text}</p>
                    </div>
                `;
            } else {
                div.innerHTML = `
                    <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white text-sm flex-shrink-0">🤖</div>
                    <div class="bg-white dark:bg-gray-800 p-3 rounded-lg rounded-tl-none shadow-sm border border-gray-200 dark:border-gray-700 max-w-[80%]">
                        <p class="text-sm text-gray-800 dark:text-gray-200">${text}</p>
                    </div>
                `;
            }

            chatArea.appendChild(div);
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        function formatResponse(text) {
            // Format bold
            text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            // Format italic
            text = text.replace(/\*(.*?)\*/g, '<em>$1</em>');
            // Format new lines
            text = text.replace(/\n/g, '<br>');
            // Format horizontal line
            text = text.replace(/─{40}/g, '<hr class="my-2 border-gray-300 dark:border-gray-600">');

            return text;
        }

        function clearChat() {
            if (confirm('Hapus semua riwayat chat?')) {
                chatArea.innerHTML = `
                    <div class="flex items-start space-x-2">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-emerald-500 text-sm text-white">
                            🤖
                        </div>
                        <div class="max-w-[80%] rounded-lg rounded-tl-none border border-gray-200 bg-white p-3 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                            <p class="text-sm text-gray-800 dark:text-gray-200">
                                Chat telah dihapus. Ada yang bisa saya bantu?
                            </p>
                        </div>
                    </div>
                `;
            }
        }

        // Auto-focus input
        userInput.focus();
    </script>
@endpush
