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
        $surahs = Surah::orderBy('nomor')->get();
        return view('quran.index', compact('surahs'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $surah = Surah::with('ayats')->findOrFail($id);
        return view('quran.show', compact('surah'));
    }
}
