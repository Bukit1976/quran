<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hafalan;
use App\Models\Murajaah;
use Carbon\Carbon;

class MurajaahController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua murajaah yang belum selesai
        $murajaahHariIni = Murajaah::with('ayat.surah')
            ->where('user_id', $user->id)
            ->whereDate('tanggal_murajaah', Carbon::today())
            ->where('status', 'belum')
            ->get()
            ->groupBy(function ($item) {
                return $item->ayat->surah->nama;
            });

        // Ambil semua murajaah yang sudah selesai
        $murajaahSelesai = Murajaah::with('ayat.surah')
            ->where('user_id', $user->id)
            ->whereDate('tanggal_murajaah', Carbon::today())
            ->where('status', 'selesai')
            ->get();

        return view('murajaah.index', compact('murajaahHariIni', 'murajaahSelesai'));
    }

    public function selesai($murajaahId)
    {
        $user = Auth::user();

        $murajaah = Murajaah::where('user_id', $user->id)
            ->where('id', $murajaahId)
            ->first();

        if ($murajaah) {
            $murajaah->update(['status' => 'selesai']);
        }

        return redirect()->back()->with('success', 'Murajaah berhasil diselesaikan!');
    }

    public function buatJadwal($hafalanId)
    {
        $user = Auth::user();

        $hafalan = Hafalan::where('user_id', $user->id)
            ->where('id', $hafalanId)
            ->first();

        if (!$hafalan) {
            return redirect()->back()->with('error', 'Hafalan tidak ditemukan');
        }

        // Buat jadwal murajaah otomatis: 1, 3, 7, 14, 30 hari
        $intervalHari = [1, 3, 7, 14, 30];

        foreach ($intervalHari as $hari) {
            Murajaah::create([
                'user_id' => $user->id,
                'ayat_id' => $hafalan->ayat_id,
                'tanggal_murajaah' => Carbon::now()->addDays($hari),
                'status' => 'belum',
            ]);
        }

        // Update status hafalan menjadi perlu_murajaah
        $hafalan->update(['status' => 'perlu_murajaah']);

        return redirect()->back()->with('success', 'Jadwal murajaah berhasil dibuat!');
    }

    public function hapusJadwal($murajaahId)
    {
        $user = Auth::user();

        Murajaah::where('user_id', $user->id)
            ->where('id', $murajaahId)
            ->delete();

        return redirect()->back()->with('success', 'Jadwal murajaah dihapus');
    }
}
