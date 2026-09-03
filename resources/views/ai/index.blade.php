@extends('layouts.app')

@section('title', 'AI Pendamping Hafalan')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 sm:text-2xl">AI Pendamping Hafalan</h2>
@endsection

@section('content')
    <div
        class="mx-auto flex h-[600px] max-w-3xl flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
        <div class="flex items-center space-x-3 bg-gradient-to-r from-emerald-500 to-teal-600 p-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-xl">🤖</div>
            <div>
                <h3 class="font-bold text-white">Ustadz AI</h3>
                <p class="text-xs text-emerald-100">Tanyakan arti ayat atau tema tertentu</p>
            </div>
        </div>

        <div id="chatArea" class="flex-1 space-y-4 overflow-y-auto bg-gray-50 p-4 dark:bg-gray-900">
            <div class="flex items-start space-x-2">
                <div
                    class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-emerald-500 text-sm text-white">
                    🤖</div>
                <div
                    class="max-w-[80%] rounded-lg rounded-tl-none border border-gray-200 bg-white p-3 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm text-gray-800 dark:text-gray-200">Assalamu'alaikum! Saya AI Pendamping Anda. Tanyakan
                        tema seperti "Sabar", "Doa", "Surga", atau ketik nama surah!</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
            <form id="chatForm" class="flex space-x-2">
                @csrf
                <input type="text" id="userInput" placeholder="Ketik pertanyaan Anda..."
                    class="flex-1 rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    required>
                <button type="submit"
                    class="flex items-center rounded-lg bg-emerald-500 px-6 py-2 font-medium text-white transition hover:bg-emerald-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const chatForm = document.getElementById('chatForm');
        const chatArea = document.getElementById('chatArea');
        const userInput = document.getElementById('userInput');

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const pertanyaan = userInput.value.trim();
            if (!pertanyaan) return;

            appendMessage(pertanyaan, 'user');
            userInput.value = '';
            const loadingId = appendMessage('Sedang mencari di Al-Qur\'an...', 'ai', true);

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
                    document.getElementById(loadingId).remove();
                    const formattedJawaban = data.jawaban.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                        .replace(/\n/g, '<br>');
                    appendMessage(formattedJawaban, 'ai');
                })
                .catch(error => {
                    document.getElementById(loadingId).remove();
                    appendMessage('Maaf, terjadi kesalahan koneksi.', 'ai');
                });
        });

        function appendMessage(text, sender, isLoading = false) {
            const id = 'msg-' + Date.now();
            const div = document.createElement('div');
            div.id = id;

            if (sender === 'user') {
                div.className = 'flex items-start space-x-2 flex-row-reverse space-x-reverse';
                div.innerHTML =
                    `<div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm flex-shrink-0">👤</div><div class="bg-blue-500 text-white p-3 rounded-lg rounded-tr-none shadow-sm max-w-[80%]"><p class="text-sm">${text}</p></div>`;
            } else {
                div.className = 'flex items-start space-x-2';
                const content = isLoading ? `<p class="text-sm text-gray-500 italic">${text}</p>` :
                    `<p class="text-sm text-gray-800 dark:text-gray-200">${text}</p>`;
                div.innerHTML =
                    `<div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white text-sm flex-shrink-0">🤖</div><div class="bg-white dark:bg-gray-800 p-3 rounded-lg rounded-tl-none shadow-sm border border-gray-200 dark:border-gray-700 max-w-[80%]">${content}</div>`;
            }

            chatArea.appendChild(div);
            chatArea.scrollTop = chatArea.scrollHeight;
            return id;
        }
    </script>
@endpush
