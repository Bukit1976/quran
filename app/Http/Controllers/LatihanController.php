<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ayat;
use App\Models\Hafalan;

class LatihanController extends Controller
{
    public function index($ayatId)
    {
        $user = Auth::user();
        $ayat = Ayat::with('surah')->findOrFail($ayatId);

        // Cek status hafalan
        $statusHafalan = Hafalan::where('user_id', $user->id)
            ->where('ayat_id', $ayatId)
            ->first();

        // Pecah ayat menjadi kata-kata
        $kataKata = preg_split('/\s+/', $ayat->teks_arab);
        $totalKata = count($kataKata);

        return view('latihan.index', compact('ayat', 'kataKata', 'totalKata', 'statusHafalan'));
    }

    public function mode(Request $request, $ayatId)
    {
        $user = Auth::user();
        $ayat = Ayat::with('surah')->findOrFail($ayatId);
        $mode = $request->mode; // 1, 2, 3, 4

        // Pecah ayat menjadi kata-kata
        $kataKata = preg_split('/\s+/', $ayat->teks_arab);
        $totalKata = count($kataKata);

        // Tentukan berapa kata yang disembunyikan
        $kataTersembunyi = [];

        if ($mode == 2) {
            // Mode 2: Sembunyikan 30% kata
            $jumlahSembunyi = (int) ceil($totalKata * 0.3);
            $kataTersembunyi = $this->getRandomKeys($totalKata, $jumlahSembunyi);
        } elseif ($mode == 3) {
            // Mode 3: Sembunyikan 60% kata
            $jumlahSembunyi = (int) ceil($totalKata * 0.6);
            $kataTersembunyi = $this->getRandomKeys($totalKata, $jumlahSembunyi);
        } elseif ($mode == 4) {
            // Mode 4: Sembunyikan semua
            $kataTersembunyi = range(0, $totalKata - 1);
        }

        return view('latihan.mode', compact('ayat', 'kataKata', 'totalKata', 'mode', 'kataTersembunyi'));
    }

    private function getRandomKeys($total, $count)
    {
        $keys = range(0, $total - 1);
        shuffle($keys);
        return array_slice($keys, 0, $count);
    }
}
