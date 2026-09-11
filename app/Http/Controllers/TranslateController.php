<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TranslateController extends Controller
{
    public function index()
    {
        return view('translate.index');
    }

    public function process(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'source_lang' => 'required|string',
            'target_lang' => 'required|string',
        ]);

        $text = $request->text;
        $source = $request->source_lang;
        $target = $request->target_lang;

        // Pastikan OPENAI_API_KEY sudah diisi di file .env
        $apiKey = env('OPENAI_API_KEY');

        $prompt = "Anda adalah asisten penerjemah dan guru bahasa yang ahli.
        Tugas Anda:
        1. Terjemahkan teks berikut dari bahasa {$source} ke bahasa {$target}.
        2. Jika ada kesalahan tata bahasa, ejaan, atau frasa yang tidak wajar dalam teks asli, berikan koreksi yang sopan dalam bahasa asli (contoh: 'Maaf, ada sedikit kesalahan. Yang lebih tepat adalah...'). Jika teks asli sudah sempurna, isi dengan null.
        3. Berikan hasil terjemahan yang akurat dan natural.

        Format respons Anda HARUS dalam JSON valid seperti ini:
        {
            \"correction\": \"Teks koreksi jika ada, atau null jika tidak ada kesalahan.\",
            \"translation\": \"Hasil terjemahan.\"
        }

        Teks asli: \"{$text}\"";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo', // Bisa diganti gpt-4o jika punya akses
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful translation and language correction assistant. Always respond in valid JSON format.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.3,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'];

                // Bersihkan respons dari markdown code block (```json) jika ada
                $content = preg_replace('/^```json\s*|\s*```$/', '', trim($content));

                $result = json_decode($content, true);

                return response()->json([
                    'success' => true,
                    'correction' => $result['correction'] ?? null,
                    'translation' => $result['translation'] ?? 'Terjemahan tidak tersedia.',
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Gagal menghubungi layanan AI.'], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
