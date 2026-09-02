<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\HafalanController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\MurajaahController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/quran', [SurahController::class, 'index'])->name('quran.index');
    Route::get('/quran/surah/{id}', [SurahController::class, 'show'])->name('quran.show');

    Route::get('/hafalan', [HafalanController::class, 'index'])->name('hafalan.index');
    Route::get('/hafalan/mulai/{ayat}', [HafalanController::class, 'mulai'])->name('hafalan.mulai');
    Route::post('/hafalan/update/{ayat}', [HafalanController::class, 'updateStatus'])->name('hafalan.update');

    // Route Latihan
    Route::get('/latihan/{ayat}', [LatihanController::class, 'index'])->name('latihan.index');
    Route::get('/latihan/{ayat}/mode/{mode}', [LatihanController::class, 'mode'])->name('latihan.mode');

    // Route Murajaah
    Route::get('/murajaah', [MurajaahController::class, 'index'])->name('murajaah.index');
    Route::patch('/murajaah/{murajaah}/selesai', [MurajaahController::class, 'selesai'])->name('murajaah.selesai');
    Route::post('/murajaah/buat-jadwal/{hafalan}', [MurajaahController::class, 'buatJadwal'])->name('murajaah.buatJadwal');
    Route::delete('/murajaah/{murajaah}', [MurajaahController::class, 'hapusJadwal'])->name('murajaah.hapus');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Route Tes
    Route::get('/tes', [App\Http\Controllers\TesController::class, 'index'])->name('tes.index');
    Route::get('/tes/mulai/{jenis}', [App\Http\Controllers\TesController::class, 'mulai'])->name('tes.mulai');
    Route::post('/tes/simpan', [App\Http\Controllers\TesController::class, 'simpan'])->name('tes.simpan');
    Route::get('/tes/hasil/{skor}/{jenis}', [App\Http\Controllers\TesController::class, 'hasil'])->name('tes.hasil');

    // Route Statistik
    Route::get('/statistik', [App\Http\Controllers\StatistikController::class, 'index'])->name('statistik.index');

    // Route AI Pendamping
    Route::get('/ai', [App\Http\Controllers\AiController::class, 'index'])->name('ai.index');
    Route::post('/ai/chat', [App\Http\Controllers\AiController::class, 'chat'])->name('ai.chat');

    // Route Juz
    Route::get('/juz', [App\Http\Controllers\JuzController::class, 'index'])->name('juz.index');
    Route::get('/juz/{nomorJuz}', [App\Http\Controllers\JuzController::class, 'show'])->name('juz.show');

    // Settings Routes
    Route::get('/pengaturan', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/pengaturan', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/pengaturan/tema', [SettingsController::class, 'updateTema'])->name('settings.updateTema');
    Route::post('/pengaturan/toggle', [SettingsController::class, 'updateToggle'])->name('settings.updateToggle');
    Route::post('/pengaturan/font-size', [SettingsController::class, 'updateFontSize'])->name('settings.updateFontSize');
    Route::post('/pengaturan/select', [SettingsController::class, 'updateSelect'])->name('settings.updateSelect');
    Route::post('/pengaturan/reset', [SettingsController::class, 'resetSettings'])->name('settings.reset');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/update/{field}', [SettingsController::class, 'updateSingle'])->name('settings.update');

    // Tambahkan route ini:
    Route::get('/audio-manager', function () {
        return view('audio-manager'); // atau buat view nya nanti
    })->name('audio.manager');

    Route::get('/privacy', function () {
        return view('privacy');
    })->name('privacy');
});

require __DIR__ . '/auth.php';
