<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class JadwalSholatController extends Controller
{
    public function index()
    {
        return view('jadwal-sholat.index');
    }

    public function getJadwal(Request $request)
    {
        $city = $request->input('city', 'Jakarta');
        $country = 'Indonesia';
        $date = Carbon::now()->format('d-m-Y');

        try {
            // TAMBAHKAN ->withOptions(['verify' => false]) DI SINI
            $response = Http::timeout(10)
                ->withOptions(['verify' => false])
                ->get("https://api.aladhan.com/v1/timingsByCity", [
                    'city' => $city,
                    'country' => $country,
                    'method' => 20,
                    'date' => $date
                ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'error' => 'Gagal mengambil data dari API',
                'detail' => $response->body(),
                'status' => $response->status()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Koneksi ke API gagal',
                'detail' => $e->getMessage()
            ], 500);
        }
    }
}
