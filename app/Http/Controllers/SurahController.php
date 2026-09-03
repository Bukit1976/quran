<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surah;

class SurahController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $surahs = Surah::orderBy('nomor', 'asc')->get();
        return view('quran.index', compact('surahs'));
    }

    public function show($id)
    {
        $user = Auth::user();
        // Memuat surah beserta ayat-ayat yang diurutkan berdasarkan nomor ayat
        $surah = Surah::with(['ayats' => function ($query) {
            $query->orderBy('nomor_ayat', 'asc');
        }])->findOrFail($id);

        return view('quran.show', compact('surah'));
    }
}
