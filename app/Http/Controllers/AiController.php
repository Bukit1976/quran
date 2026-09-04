<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ayat;
use App\Models\Surah;
use Illuminate\Support\Facades\DB;

class AiController extends Controller
{
    public function index()
    {
        return view('ai.index');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:500'
        ]);

        $pertanyaan = strtolower(trim($request->pertanyaan));
        $jawaban = $this->prosesPertanyaan($pertanyaan);

        return response()->json([
            'jawaban' => $jawaban
        ]);
    }

    private function prosesPertanyaan($pertanyaan)
    {
        // 1. Cek greetings
        $greetings = $this->cekGreeting($pertanyaan);
        if ($greetings) {
            return $greetings;
        }

        // 2. Cek apakah mencari nama surah
        $surahResult = $this->cariSurah($pertanyaan);
        if ($surahResult) {
            return $surahResult;
        }

        // 3. Cek apakah mencari tema/topik
        $temaResult = $this->cariTema($pertanyaan);
        if ($temaResult) {
            return $temaResult;
        }

        // 4. Cari ayat berdasarkan kata kunci
        $ayatResult = $this->cariAyat($pertanyaan);
        if ($ayatResult) {
            return $ayatResult;
        }

        // 5. Default response
        return $this->getDefaultResponse($pertanyaan);
    }

    private function cekGreeting($pertanyaan)
    {
        $greetings = [
            'assalamu\'alaikum' => 'Wa\'alaikumussalam warahmatullahi wabarakatuh! Ada yang bisa saya bantu terkait Al-Qur\'an?',
            'selamat pagi' => 'Selamat pagi! Semoga hari Anda penuh berkah. Ada yang ingin ditanyakan tentang Al-Qur\'an?',
            'selamat siang' => 'Selamat siang! Semoga Anda dalam keadaan baik. Ada pertanyaan tentang Al-Qur\'an?',
            'selamat sore' => 'Selamat sore! Semoga sore Anda menyenangkan. Ada yang bisa saya bantu?',
            'selamat malam' => 'Selamat malam! Semoga malam Anda penuh ketenangan. Ada pertanyaan tentang Al-Qur\'an?',
            'halo' => 'Halo! Saya AI Pendamping Hafalan. Tanyakan tema seperti "sabar", "doa", "surga", "neraka", atau nama surah!',
            'hi' => 'Hi! Saya siap membantu Anda belajar Al-Qur\'an. Silakan tanyakan sesuatu!',
            'terima kasih' => 'Sama-sama! Senang bisa membantu. Jangan ragu untuk bertanya lagi!',
            'makasih' => 'Sama-sama! Semoga bermanfaat. Ada lagi yang ingin ditanyakan?',
        ];

        foreach ($greetings as $key => $response) {
            if (strpos($pertanyaan, $key) !== false) {
                return $response;
            }
        }

        return null;
    }

    private function cariSurah($pertanyaan)
    {
        // Mapping nama surah
        $surahMapping = [
            'yasin' => 'Yasin',
            'yāsin' => 'Yasin',
            'al-fatihah' => 'Al-Fatihah',
            'alfatihah' => 'Al-Fatihah',
            'al-baqarah' => 'Al-Baqarah',
            'albaqarah' => 'Al-Baqarah',
            'al-ikhlas' => 'Al-Ikhlas',
            'alikhlas' => 'Al-Ikhlas',
            'al-falaq' => 'Al-Falaq',
            'alfalaq' => 'Al-Falaq',
            'an-nas' => 'An-Nas',
            'annas' => 'An-Nas',
            'ar-rahman' => 'Ar-Rahman',
            'arrahman' => 'Ar-Rahman',
            'al-waqiah' => 'Al-Waqiah',
            'alwaqiah' => 'Al-Waqiah',
            'al-mulk' => 'Al-Mulk',
            'almulk' => 'Al-Mulk',
            'al-kahfi' => 'Al-Kahfi',
            'alkahfi' => 'Al-Kahfi',
        ];

        foreach ($surahMapping as $key => $namaSurah) {
            if (strpos($pertanyaan, $key) !== false) {
                $surah = Surah::where('nama', 'LIKE', "%{$namaSurah}%")->first();
                if ($surah) {
                    return "✅ **Surah {$surah->nama}** ditemukan!\n\n" .
                        " **Nama Arab:** {$surah->nama_arab}\n" .
                        "📊 **Jumlah Ayat:** {$surah->jumlah_ayat} ayat\n" .
                        "📍 **Juz:** {$surah->juz}\n\n" .
                        "Ketik \"ayat {$surah->nama}\" untuk melihat ayat-ayatnya.";
                }
            }
        }

        // Cari dari database
        $surah = Surah::where('nama', 'LIKE', "%{$pertanyaan}%")->first();
        if ($surah) {
            return "✅ **Surah {$surah->nama}** ditemukan!\n\n" .
                "📖 **Nama Arab:** {$surah->nama_arab}\n" .
                "📊 **Jumlah Ayat:** {$surah->jumlah_ayat} ayat\n" .
                "📍 **Juz:** {$surah->juz}";
        }

        return null;
    }

    private function cariTema($pertanyaan)
    {
        // Mapping tema dengan kata kunci
        $temaMapping = [
            'sabar' => [
                'keywords' => ['sabar', 'kesabaran', 'bersabar'],
                'ayat_ids' => [153, 154, 155, 200, 249, 1200], // Contoh ayat tentang sabar
            ],
            'doa' => [
                'keywords' => ['doa', 'berdoa', 'memohon', 'mohon'],
                'ayat_ids' => [186, 201, 202, 285, 651],
            ],
            'surga' => [
                'keywords' => ['surga', 'jannah', 'jannah', 'syurga'],
                'ayat_ids' => [25, 26, 27, 28, 29, 30, 31],
            ],
            'neraka' => [
                'keywords' => ['neraka', 'jahannam', 'azab', 'siksa'],
                'ayat_ids' => [39, 114, 115, 116, 117],
            ],
            'sedekah' => [
                'keywords' => ['sedekah', 'zakat', 'infak', 'amal'],
                'ayat_ids' => [267, 268, 269, 270, 271, 272, 273, 274],
            ],
            'orang tua' => [
                'keywords' => ['orang tua', 'ibu', 'bapak', 'walidain', 'berbakti'],
                'ayat_ids' => [823, 824, 2370, 2371],
            ],
            'ilmu' => [
                'keywords' => ['ilmu', 'belajar', 'menuntut ilmu', 'pendidikan'],
                'ayat_ids' => [11, 112, 269, 285, 5954],
            ],
            'rezeki' => [
                'keywords' => ['rezeki', 'rizki', 'nafkah', 'makanan'],
                'ayat_ids' => [267, 268, 269, 3470, 5782],
            ],
            'puasa' => [
                'keywords' => ['puasa', 'shaum', 'ramadhan'],
                'ayat_ids' => [183, 184, 185, 186, 187],
            ],
            'jihad' => [
                'keywords' => ['jihad', 'berjuang', 'perang', 'fi sabilillah'],
                'ayat_ids' => [190, 191, 192, 193, 194, 195],
            ],
        ];

        foreach ($temaMapping as $tema => $data) {
            foreach ($data['keywords'] as $keyword) {
                if (strpos($pertanyaan, $keyword) !== false) {
                    return $this->getAyatByTema($tema, $data['ayat_ids']);
                }
            }
        }

        return null;
    }

    private function getAyatByTema($tema, $ayatIds)
    {
        $ayats = Ayat::whereIn('id', $ayatIds)
            ->with('surah')
            ->limit(3)
            ->get();

        if ($ayats->isEmpty()) {
            return null;
        }

        $response = " **Ayat-ayat tentang " . ucfirst($tema) . "**:\n\n";

        foreach ($ayats as $ayat) {
            $response .= "️ **{$ayat->surah->nama} : {$ayat->nomor_ayat}**\n";
            $response .= "{$ayat->teks_arab}\n\n";
            $response .= "*{$ayat->terjemahan}*\n\n";
            $response .= str_repeat("─", 40) . "\n\n";
        }

        $response .= "💡 *Ketik tema lain untuk mencari ayat lainnya.*";

        return $response;
    }

    private function cariAyat($pertanyaan)
    {
        // Hapus kata-kata umum
        $stopWords = ['apa', 'yang', 'tentang', 'di', 'dalam', 'pada', 'ayat', 'surah', 'quran', 'al quran'];
        $words = array_filter(explode(' ', $pertanyaan), function ($word) use ($stopWords) {
            return !in_array($word, $stopWords) && strlen($word) > 2;
        });

        if (empty($words)) {
            return null;
        }

        // Cari dalam teks Arab, transliterasi, atau terjemahan
        $query = Ayat::query();

        foreach ($words as $word) {
            $query->orWhere('teks_arab', 'LIKE', "%{$word}%")
                ->orWhere('transliterasi', 'LIKE', "%{$word}%")
                ->orWhere('terjemahan', 'LIKE', "%{$word}%");
        }

        $ayats = $query->with('surah')->limit(3)->get();

        if ($ayats->isEmpty()) {
            return null;
        }

        $response = " **Hasil pencarian untuk \"{$pertanyaan}\":**\n\n";

        foreach ($ayats as $ayat) {
            $response .= "▫️ **{$ayat->surah->nama} : {$ayat->nomor_ayat}**\n";
            $response .= substr($ayat->teks_arab, 0, 100) . (strlen($ayat->teks_arab) > 100 ? '...' : '') . "\n\n";
            $response .= substr($ayat->terjemahan, 0, 150) . (strlen($ayat->terjemahan) > 150 ? '...' : '') . "\n\n";
            $response .= str_repeat("─", 40) . "\n\n";
        }

        return $response;
    }

    private function getDefaultResponse($pertanyaan)
    {
        $responses = [
            "Maaf, saya belum memahami pertanyaan Anda. Coba gunakan kata kunci seperti:\n\n" .
                "• **Tema:** \"sabar\", \"doa\", \"surga\", \"neraka\", \"sedekah\"\n" .
                "• **Nama Surah:** \"Yasin\", \"Al-Fatihah\", \"Al-Baqarah\"\n" .
                "• **Kata Kunci:** \"rezeki\", \"ilmu\", \"orang tua\"\n\n" .
                "💡 Contoh: \"ayat tentang sabar\" atau \"surah Yasin\"",

            "Saya belum menemukan jawaban yang tepat. Silakan coba dengan:\n\n" .
                " **Tema Al-Qur'an:** sabar, doa, puasa, zakat, jihad\n" .
                "📖 **Nama Surah:** ketik nama surah yang ingin diketahui\n" .
                "🔍 **Kata Kunci:** cari ayat dengan kata tertentu\n\n" .
                "Contoh: \"tentang kesabaran\" atau \"Al-Ikhlas\"",
        ];

        return $responses[array_rand($responses)];
    }
}
