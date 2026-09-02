<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hafalan;
use App\Models\HafalanTest;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Total Hafalan
        $totalHafal = Hafalan::where('user_id', $user->id)->where('status', 'sudah_hafal')->count();
        $sedangHafal = Hafalan::where('user_id', $user->id)->where('status', 'sedang_dihafal')->count();

        // Rata-rata Nilai Tes
        $rataNilai = HafalanTest::where('user_id', $user->id)->avg('skor') ?? 0;

        // Data Grafik (7 hari terakhir)
        $labels = [];
        $dataHafalan = [];
        $dataTes = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->format('d M');

            $dataHafalan[] = Hafalan::where('user_id', $user->id)
                ->whereDate('tanggal_mulai', $date)->count();

            $dataTes[] = HafalanTest::where('user_id', $user->id)
                ->whereDate('created_at', $date)->avg('skor') ?? 0;
        }

        return view('statistik.index', compact(
            'totalHafal',
            'sedangHafal',
            'rataNilai',
            'labels',
            'dataHafalan',
            'dataTes'
        ));
    }
}
