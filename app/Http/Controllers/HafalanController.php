<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hafalan;
use App\Models\Murajaah;
use App\Models\Ayat;
use Carbon\Carbon;

class HafalanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $hafalan = Hafalan::with('ayat.surah')
            ->where('user_id', $user->id)
            ->get()
            ->groupBy(function ($item) {
                return $item->ayat->surah->nama;
            });

        return view('hafalan.index', compact('hafalan'));
    }

    public function mulai($ayatId)
    {
        $user = Auth::user();
        $ayat = Ayat::with('surah')->findOrFail($ayatId);

        $hafalan = Hafalan::firstOrCreate(
            [
                'user_id' => $user->id,
                'ayat_id' => $ayatId,
            ],
            [
                'status' => 'sedang_dihafal',
                'tanggal_mulai' => Carbon::now(),
            ]
        );

        return view('hafalan.mulai', compact('ayat', 'hafalan'));
    }

    public function updateStatus(Request $request, $ayatId)
    {
        $user = Auth::user();

        $hafalan = Hafalan::where('user_id', $user->id)
            ->where('ayat_id', $ayatId)
            ->first();

        if ($hafalan) {
            $hafalan->update([
                'status' => $request->status,
                'tanggal_selesai' => $request->status === 'sudah_hafal' ? Carbon::now() : null,
            ]);

            // Jika sudah hafal, otomatis buat jadwal murajaah
            if ($request->status === 'sudah_hafal') {
                $intervalHari = [1, 3, 7, 14, 30];

                foreach ($intervalHari as $hari) {
                    Murajaah::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'ayat_id' => $ayatId,
                            'tanggal_murajaah' => Carbon::now()->addDays($hari),
                        ],
                        ['status' => 'belum']
                    );
                }

                $hafalan->update(['status' => 'perlu_murajaah']);
            }
        }

        return redirect()->back()->with('success', 'Status hafalan berhasil diperbarui');
    }
}
