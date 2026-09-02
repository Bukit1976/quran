<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ayat;
use App\Models\Hafalan;
use App\Models\HafalanTest;

class TesController extends Controller
{
    public function index()
    {
        return view('tes.index');
    }

    // Ambil soal acak
    private function getSoalAcak($jenis, $jumlah = 5)
    {
        $user = Auth::user();
        // Ambil ayat yang sudah pernah dihafal user (status sudah_hafal atau sedang_dihafal)
        $ayatIds = Hafalan::where('user_id', $user->id)
            ->whereIn('status', ['sudah_hafal', 'sedang_dihafal'])
            ->pluck('ayat_id');

        // Jika belum ada hafalan, ambil ayat acak dari Juz 30 (surah 78-114)
        if ($ayatIds->isEmpty()) {
            $ayatIds = Ayat::whereHas('surah', function ($q) {
                $q->whereBetween('nomor', [78, 114]);
            })->pluck('id');
        }

        return Ayat::whereIn('id', $ayatIds)->inRandomOrder()->limit($jumlah)->get();
    }

    public function mulai($jenis)
    {
        $soal = $this->getSoalAcak($jenis, 5);

        $dataSoal = [];
        foreach ($soal as $ayat) {
            $item = ['ayat' => $ayat];

            if ($jenis === 'lanjutkan_ayat') {
                // Pecah ayat jadi 2 bagian
                $kata = preg_split('/\s+/', $ayat->teks_arab);
                $tengah = (int) ceil(count($kata) / 2);
                $item['bagian1'] = implode(' ', array_slice($kata, 0, $tengah));
                $item['jawaban_benar'] = implode(' ', array_slice($kata, $tengah));

                // Cari pengecoh
                $pengecoh = Ayat::where('id', '!=', $ayat->id)->inRandomOrder()->limit(3)->get();
                $item['pilihan'] = collect([$item['jawaban_benar']])->merge(
                    $pengecoh->map(fn($a) => implode(' ', array_slice(preg_split('/\s+/', $a->teks_arab), $tengah)))
                )->shuffle()->values();
            } elseif ($jenis === 'tebak_arti') {
                // Ambil 1 kata acak
                $kata = preg_split('/\s+/', $ayat->teks_arab);
                $indexKata = array_rand($kata);
                $item['kata_arab'] = $kata[$indexKata];

                // Terjemahan sederhana (kita pakai terjemahan full ayat sebagai opsi untuk simplifikasi, atau bisa pakai kamus)
                $item['jawaban_benar'] = $ayat->terjemahan;
                $pengecoh = Ayat::where('id', '!=', $ayat->id)->inRandomOrder()->limit(3)->pluck('terjemahan');
                $item['pilihan'] = collect([$item['jawaban_benar']])->merge($pengecoh)->shuffle()->values();
            } elseif ($jenis === 'susun_kata') {
                $kata = preg_split('/\s+/', $ayat->teks_arab);
                $item['kata_acak'] = collect($kata)->shuffle()->values();
                $item['jawaban_benar'] = $kata;
            }

            $dataSoal[] = $item;
        }

        return view('tes.quiz', compact('dataSoal', 'jenis'));
    }

    public function simpan(Request $request)
    {
        $user = Auth::user();
        $skor = $request->skor;
        $jenis = $request->jenis;
        $ayatId = $request->ayat_id; // Bisa array atau single, kita simpan yang terakhir atau rata-rata

        // Simpan hasil tes
        HafalanTest::create([
            'user_id' => $user->id,
            'ayat_id' => $ayatId,
            'jenis_tes' => $jenis,
            'skor' => $skor,
        ]);

        return redirect()->route('tes.hasil', ['skor' => $skor, 'jenis' => $jenis]);
    }

    public function hasil($skor, $jenis)
    {
        return view('tes.hasil', compact('skor', 'jenis'));
    }
}
