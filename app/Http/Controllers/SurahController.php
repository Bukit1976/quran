<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surah;
use App\Models\UserSetting; // Tambahkan ini agar tidak perlu pakai \App\Models\

class SurahController extends Controller
{
    public function index()
    {
        $surahs = Surah::orderBy('nomor', 'asc')->get();
        return view('quran.index', compact('surahs'));
    }

    // Tambahkan 'int' sebelum $id agar editor tahu ini adalah angka
    public function show(int $id)
    {
        $surah = Surah::with('ayats')->findOrFail($id);

        // Gunakan Auth::id() yang lebih stabil dan dikenali editor
        $userSettings = UserSetting::getOrCreate(Auth::id());

        return view('quran.show', compact('surah', 'userSettings'));
    }
}
