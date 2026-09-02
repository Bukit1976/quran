<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ayat;

class JuzController extends Controller
{
    public function index()
    {
        // Daftar 30 Juz dengan info surah awal
        $juzList = [
            1  => ['surah_awal' => 'Al-Fatihah', 'ayat_awal' => 1, 'surah_akhir' => 'Al-Baqarah', 'ayat_akhir' => 141],
            2  => ['surah_awal' => 'Al-Baqarah', 'ayat_awal' => 142, 'surah_akhir' => 'Al-Baqarah', 'ayat_akhir' => 252],
            3  => ['surah_awal' => 'Al-Baqarah', 'ayat_awal' => 253, 'surah_akhir' => 'Ali Imran', 'ayat_akhir' => 92],
            4  => ['surah_awal' => 'Ali Imran', 'ayat_awal' => 93, 'surah_akhir' => 'An-Nisa', 'ayat_akhir' => 23],
            5  => ['surah_awal' => 'An-Nisa', 'ayat_awal' => 24, 'surah_akhir' => 'An-Nisa', 'ayat_akhir' => 147],
            6  => ['surah_awal' => 'An-Nisa', 'ayat_awal' => 148, 'surah_akhir' => 'Al-Ma\'idah', 'ayat_akhir' => 81],
            7  => ['surah_awal' => 'Al-Ma\'idah', 'ayat_awal' => 82, 'surah_akhir' => 'Al-An\'am', 'ayat_akhir' => 110],
            8  => ['surah_awal' => 'Al-An\'am', 'ayat_awal' => 111, 'surah_akhir' => 'Al-A\'raf', 'ayat_akhir' => 87],
            9  => ['surah_awal' => 'Al-A\'raf', 'ayat_awal' => 88, 'surah_akhir' => 'Al-Anfal', 'ayat_akhir' => 40],
            10 => ['surah_awal' => 'Al-Anfal', 'ayat_awal' => 41, 'surah_akhir' => 'At-Taubah', 'ayat_akhir' => 92],
            11 => ['surah_awal' => 'At-Taubah', 'ayat_awal' => 93, 'surah_akhir' => 'Hud', 'ayat_akhir' => 5],
            12 => ['surah_awal' => 'Hud', 'ayat_awal' => 6, 'surah_akhir' => 'Yusuf', 'ayat_akhir' => 52],
            13 => ['surah_awal' => 'Yusuf', 'ayat_awal' => 53, 'surah_akhir' => 'Ar-Ra\'d', 'ayat_akhir' => 18],
            14 => ['surah_awal' => 'Ar-Ra\'d', 'ayat_awal' => 19, 'surah_akhir' => 'Al-Hijr', 'ayat_akhir' => 1],
            15 => ['surah_awal' => 'Al-Hijr', 'ayat_awal' => 2, 'surah_akhir' => 'An-Nahl', 'ayat_akhir' => 128],
            16 => ['surah_awal' => 'An-Nahl', 'ayat_awal' => 1, 'surah_akhir' => 'Al-Isra', 'ayat_akhir' => 111],
            17 => ['surah_awal' => 'Al-Isra', 'ayat_awal' => 1, 'surah_akhir' => 'Al-Kahf', 'ayat_akhir' => 74],
            18 => ['surah_awal' => 'Al-Kahf', 'ayat_awal' => 75, 'surah_akhir' => 'Taha', 'ayat_akhir' => 135],
            19 => ['surah_awal' => 'Taha', 'ayat_awal' => 1, 'surah_akhir' => 'Al-Anbiya', 'ayat_akhir' => 112],
            20 => ['surah_awal' => 'Al-Anbiya', 'ayat_awal' => 1, 'surah_akhir' => 'Al-Hajj', 'ayat_akhir' => 78],
            21 => ['surah_awal' => 'Al-Hajj', 'ayat_awal' => 1, 'surah_akhir' => 'Al-Mu\'minun', 'ayat_akhir' => 118],
            22 => ['surah_awal' => 'Al-Mu\'minun', 'ayat_awal' => 1, 'surah_akhir' => 'An-Nur', 'ayat_akhir' => 64],
            23 => ['surah_awal' => 'An-Nur', 'ayat_awal' => 1, 'surah_akhir' => 'Al-Furqan', 'ayat_akhir' => 77],
            24 => ['surah_awal' => 'Al-Furqan', 'ayat_awal' => 1, 'surah_akhir' => 'An-Naml', 'ayat_akhir' => 55],
            25 => ['surah_awal' => 'An-Naml', 'ayat_awal' => 56, 'surah_akhir' => 'Al-Ankabut', 'ayat_akhir' => 45],
            26 => ['surah_awal' => 'Al-Ankabut', 'ayat_awal' => 46, 'surah_akhir' => 'Al-Ahzab', 'ayat_akhir' => 30],
            27 => ['surah_awal' => 'Al-Ahzab', 'ayat_awal' => 31, 'surah_akhir' => 'Yasin', 'ayat_akhir' => 27],
            28 => ['surah_awal' => 'Yasin', 'ayat_awal' => 28, 'surah_akhir' => 'Al-Hujurat', 'ayat_akhir' => 18],
            29 => ['surah_awal' => 'Al-Hujurat', 'ayat_awal' => 1, 'surah_akhir' => 'Al-Hadid', 'ayat_akhir' => 29],
            30 => ['surah_awal' => 'Al-Mulk', 'ayat_awal' => 1, 'surah_akhir' => 'An-Nas', 'ayat_akhir' => 6],
        ];

        return view('juz.index', compact('juzList'));
    }

    public function show($nomorJuz)
    {
        // Ambil semua ayat dalam juz ini, diurutkan berdasarkan surah dan nomor ayat
        $ayats = Ayat::where('juz', $nomorJuz)
            ->with('surah')
            ->orderBy('surah_id')
            ->orderBy('nomor_ayat')
            ->get();

        $juz = $nomorJuz;

        return view('juz.show', compact('ayats', 'juz'));
    }
}
