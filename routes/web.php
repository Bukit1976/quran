<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\HafalanController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\MurajaahController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TesController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\JuzController;
use App\Http\Controllers\AlarmController;

// ==========================================
// Route Utama (Redirect berdasarkan status login)
// ==========================================
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->middleware('web');

// ==========================================
// Route yang memerlukan autentikasi (Login)
// ==========================================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Al-Qur'an & Juz
    Route::get('/quran', [SurahController::class, 'index'])->name('quran.index');
    Route::get('/quran/surah/{id}', [SurahController::class, 'show'])->name('quran.show');
    Route::get('/juz', [JuzController::class, 'index'])->name('juz.index');
    Route::get('/juz/{nomorJuz}', [JuzController::class, 'show'])->name('juz.show');

    // Hafalan & Murajaah
    Route::get('/hafalan', [HafalanController::class, 'index'])->name('hafalan.index');
    Route::get('/hafalan/mulai/{ayat}', [HafalanController::class, 'mulai'])->name('hafalan.mulai');
    Route::post('/hafalan/update/{ayat}', [HafalanController::class, 'updateStatus'])->name('hafalan.update');

    Route::get('/murajaah', [MurajaahController::class, 'index'])->name('murajaah.index');
    Route::patch('/murajaah/{murajaah}/selesai', [MurajaahController::class, 'selesai'])->name('murajaah.selesai');
    Route::post('/murajaah/buat-jadwal/{hafalan}', [MurajaahController::class, 'buatJadwal'])->name('murajaah.buatJadwal');
    Route::delete('/murajaah/{murajaah}', [MurajaahController::class, 'hapusJadwal'])->name('murajaah.hapus');

    // Latihan & Tes
    Route::get('/latihan/{ayat}', [LatihanController::class, 'index'])->name('latihan.index');
    Route::get('/latihan/{ayat}/mode/{mode}', [LatihanController::class, 'mode'])->name('latihan.mode');

    Route::get('/tes', [TesController::class, 'index'])->name('tes.index');
    Route::get('/tes/mulai/{jenis}', [TesController::class, 'mulai'])->name('tes.mulai');
    Route::post('/tes/simpan', [TesController::class, 'simpan'])->name('tes.simpan');
    Route::get('/tes/hasil/{skor}/{jenis}', [TesController::class, 'hasil'])->name('tes.hasil');

    // Statistik & AI
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik.index');
    Route::get('/ai', [AiController::class, 'index'])->name('ai.index');
    Route::post('/ai/chat', [AiController::class, 'chat'])->name('ai.chat');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Tambahkan route ini di dalam group middleware auth
    Route::delete('/hafalan/{hafalan}', [HafalanController::class, 'destroy'])->name('hafalan.destroy');
    // ==========================================
    // SETTINGS (PENGATURAN) - DIRAPIKAN & DISEMPURNAKAN
    // ==========================================
    // Menggunakan prefix & name group agar tidak ada duplikasi kode berulang.
    // Route AJAX (toggle, select, font-size) yang diminta sudah dimasukkan ke sini.
    Route::prefix('pengaturan')->name('settings.')->group(function () {
        // Halaman Utama Pengaturan
        Route::get('/', [SettingsController::class, 'index'])->name('index');

        // Route untuk submit form biasa (Update settings umum)
        Route::post('/', [SettingsController::class, 'update'])->name('update');

        // Route khusus AJAX (Sudah disesuaikan dengan permintaan)
        Route::post('/toggle', [SettingsController::class, 'updateToggle'])->name('updateToggle');
        Route::post('/select', [SettingsController::class, 'updateSelect'])->name('updateSelect');
        Route::post('/font-size', [SettingsController::class, 'updateFontSize'])->name('updateFontSize');

        // Route tambahan (Tema & Reset) agar lebih lengkap
        Route::post('/tema', [SettingsController::class, 'updateTema'])->name('updateTema');
        Route::post('/reset', [SettingsController::class, 'resetSettings'])->name('reset');
    });

    // Kumpulan Doa
    Route::get('/doa', [App\Http\Controllers\DoaController::class, 'index'])->name('doa.index');
    // ==========================================
    // JADWAL SHOLAT
    // ==========================================
    Route::get('/jadwal-sholat', [App\Http\Controllers\JadwalSholatController::class, 'index'])->name('jadwal-sholat.index');
    Route::get('/api/jadwal-sholat', [App\Http\Controllers\JadwalSholatController::class, 'getJadwal'])->name('jadwal-sholat.api');

    // ==========================================
    // ALARM ROUTES - SEDERHANA, PAKAI POST SEMUA
    // ==========================================
    Route::get('/alarm', [App\Http\Controllers\AlarmController::class, 'index'])->name('alarm.index');
    Route::post('/alarm', [App\Http\Controllers\AlarmController::class, 'storeOrUpdate'])->name('alarm.store');
    Route::delete('/alarm/{alarm}', [App\Http\Controllers\AlarmController::class, 'destroy'])->name('alarm.destroy');
    Route::post('/alarm/{alarm}/toggle', [App\Http\Controllers\AlarmController::class, 'toggle'])->name('alarm.toggle');

    // Halaman Tambahan
    Route::get('/audio-manager', function () {
        return view('audio-manager');
    })->name('audio.manager');

    Route::get('/privacy', function () {
        return view('privacy');
    })->name('privacy');
});

// Include route bawaan Laravel untuk autentikasi (Login, Register, Lupa Password)
require __DIR__ . '/auth.php';
