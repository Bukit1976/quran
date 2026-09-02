<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hafalan;
use App\Models\Murajaah;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalHafalan = Hafalan::where('user_id', $user->id)
            ->where('status', 'sudah_hafal')
            ->count();

        $hafalanHariIni = Hafalan::where('user_id', $user->id)
            ->whereDate('tanggal_mulai', Carbon::today())
            ->count();

        $targetAyat = 3;

        $murajaahHariIni = Murajaah::where('user_id', $user->id)
            ->whereDate('tanggal_murajaah', Carbon::today())
            ->where('status', 'belum')
            ->count();

        return view('dashboard', compact(
            'totalHafalan',
            'hafalanHariIni',
            'targetAyat',
            'murajaahHariIni'
        ));
    }
}
