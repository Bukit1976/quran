<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ayat;

class AiController extends Controller
{
    public function index()
    {
        return view('ai.index');
    }

    public function chat(Request $request)
    {
        $pertanyaan = strtolower($request->input('pertanyaan'));

        // Logika AI Sederhana (Smart Keyword Search)
        // AI akan mencari ayat yang paling relevan dengan kata kunci user
        $hasil = Ayat::where('terjemahan', 'LIKE', "%{$pertanyaan}%")
            ->orWhere('teks_arab', 'LIKE', "%{$pertanyaan}%")
            ->with('surah')
            ->limit(3)
            ->get();

        if ($hasil->isEmpty()) {
            $jawaban = "Maaf, saya belum menemukan ayat yang cocok dengan pertanyaan '{$pertanyaan}'. Coba gunakan kata kunci lain, misalnya: 'Tuhan', 'Sabar', 'Surga', atau 'Neraka'.";
        } else {
            $jawaban = "Berikut adalah ayat yang saya temukan terkait pertanyaan Anda:\n\n";
            foreach ($hasil as $ayat) {
                $jawaban .= "📖 **{$ayat->surah->nama} : {$ayat->nomor_ayat}**\n";
                $jawaban .= "Arab: {$ayat->teks_arab}\n";
                $jawaban .= "Arti: {$ayat->terjemahan}\n\n";
            }
        }

        return response()->json([
            'jawaban' => $jawaban,
            'pertanyaan' => $pertanyaan
        ]);
    }
}
