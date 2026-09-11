<?php

namespace App\Http\Controllers;

// 2 BARIS PENGAMAN EKSTRA UNTUK MEMATIKAN PAKSA CEK SSL DI LEVEL SERVER
putenv('CURL_SSL_VERIFYPEER=0');
putenv('CURL_SSL_VERIFYHOST=0');

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

        $apiKey = env('GOOGLE_GEMINI_API_KEY');
        $model = env('GEMINI_MODEL', 'gemini-1.5-flash');

        $prompt = "Anda adalah asisten penerjemah dan guru bahasa yang ahli.
        Tugas Anda:
        1. Terjemahkan teks berikut dari bahasa {$source} ke bahasa {$target}.
        2. Jika ada kesalahan tata bahasa, ejaan, atau frasa yang tidak wajar dalam teks asli, berikan koreksi yang sopan dalam bahasa asli. Jika teks asli sudah sempurna, isi dengan null.
        3. Berikan hasil terjemahan yang akurat dan natural.

        Format respons Anda HARUS dalam JSON valid seperti ini:
        {
            \"correction\": \"Teks koreksi jika ada, atau null jika tidak ada kesalahan.\",
            \"translation\": \"Hasil terjemahan.\"
        }

        Teks asli: \"{$text}\"";

        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

            // PERHATIKAN: 'verify' => false adalah kunci utama mematikan error cURL 60
            $response = Http::timeout(30)
                ->withOptions(['verify' => false])
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.3,
                        'responseMimeType' => 'application/json',
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

                // Bersihkan dari tanda markdown ```json jika ada
                $content = preg_replace('/^```json\s*|\s*```$/', '', trim($content));
                $result = json_decode($content, true);

                // Fallback jika AI tidak merespons dalam format JSON yang sempurna
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json([
                        'success' => true,
                        'correction' => null,
                        'translation' => $content,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'correction' => $result['correction'] ?? null,
                    'translation' => $result['translation'] ?? 'Terjemahan tidak tersedia.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghubungi layanan AI. Detail: ' . $response->body()
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
