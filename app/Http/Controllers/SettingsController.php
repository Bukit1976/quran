<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = UserSetting::getOrCreate(Auth::user()->id);
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = UserSetting::getOrCreate(Auth::user()->id);

        $validated = $request->validate([
            // Tampilan
            'tema_aplikasi' => 'sometimes|string|in:mengikuti_perangkat,gelap,terang',
            'mode_baca_quran' => 'sometimes|string|in:selalu_tanya,otomatis_mushaf,otomatis_hafalan',

            // Arabic
            'jenis_penulisan_arabic' => 'sometimes|string|in:indopak,utsmani,imlaei',
            'tajwid_berwarna' => 'sometimes|boolean',
            'ukuran_font_arabic' => 'sometimes|integer|min:12|max:48',

            // Latin
            'aktifkan_latin' => 'sometimes|boolean',
            'ukuran_font_latin' => 'sometimes|integer|min:10|max:36',

            // Terjemahan
            'aktifkan_terjemahan' => 'sometimes|boolean',
            'penerjemah' => 'sometimes|string|in:kemenag-ri,quraish-shihab,buya-hamka,jalaluddin',
            'ukuran_font_terjemahan' => 'sometimes|integer|min:10|max:36',
            'kata_demi_kata' => 'sometimes|boolean',

            // Audio
            'qori_murattal' => 'sometimes|string',
            'aksi_popup_ayat' => 'sometimes|string|in:diklik,ditahan',

            // Lainnya
            'biarkan_layar_menyala' => 'sometimes|boolean',
            'layar_penuh' => 'sometimes|boolean',
        ]);

        // Handle boolean fields that might not be sent
        $booleanFields = [
            'tajwid_berwarna',
            'aktifkan_latin',
            'aktifkan_terjemahan',
            'kata_demi_kata',
            'biarkan_layar_menyala',
            'layar_penuh'
        ];

        foreach ($booleanFields as $field) {
            if (!$request->has($field)) {
                $validated[$field] = false;
            }
        }

        $settings->update($validated);

        // Apply theme if changed
        if (isset($validated['tema_aplikasi'])) {
            $this->applyTheme($validated['tema_aplikasi']);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function updateTema(Request $request)
    {
        $request->validate([
            'tema_aplikasi' => 'required|string|in:mengikuti_perangkat,gelap,terang',
        ]);

        $settings = UserSetting::getOrCreate(Auth::user()->id);
        $settings->update(['tema_aplikasi' => $request->tema_aplikasi]);

        $this->applyTheme($request->tema_aplikasi);

        return response()->json([
            'success' => true,
            'message' => 'Tema berhasil diubah!',
            'tema' => $settings->getTemaLabel(),
        ]);
    }

    public function updateToggle(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|boolean',
        ]);

        $allowedToggles = [
            'tajwid_berwarna',
            'aktifkan_latin',
            'aktifkan_terjemahan',
            'kata_demi_kata',
            'biarkan_layar_menyala',
            'layar_penuh'
        ];

        if (!in_array($request->field, $allowedToggles)) {
            return response()->json(['success' => false, 'message' => 'Field tidak valid'], 400);
        }

        $settings = UserSetting::getOrCreate(Auth::user()->id);
        $settings->update([$request->field => $request->value]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil disimpan!',
        ]);
    }

    public function updateFontSize(Request $request)
    {
        $request->validate([
            'field' => 'required|string|in:ukuran_font_arabic,ukuran_font_latin,ukuran_font_terjemahan',
            'value' => 'required|integer|min:10|max:48',
        ]);

        $settings = UserSetting::getOrCreate(Auth::user()->id);
        $settings->update([$request->field => $request->value]);

        return response()->json([
            'success' => true,
            'message' => 'Ukuran font berhasil diubah!',
            'value' => $request->value . ' px',
        ]);
    }

    public function updateSelect(Request $request)
    {
        $request->validate([
            'field' => 'required|string|in:mode_baca_quran,jenis_penulisan_arabic,penerjemah,qori_murattal,aksi_popup_ayat',
            'value' => 'required|string',
        ]);

        $settings = UserSetting::getOrCreate(Auth::user()->id);
        $settings->update([$request->field => $request->value]);

        $label = match ($request->field) {
            'mode_baca_quran' => $settings->getModeBacaLabel(),
            'jenis_penulisan_arabic' => $settings->getJenisPenulisanLabel(),
            'penerjemah' => $settings->getPenerjemahLabel(),
            'qori_murattal' => $settings->getQoriLabel(),
            'aksi_popup_ayat' => $settings->getAksiPopupLabel(),
            default => $request->value,
        };

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil disimpan!',
            'label' => $label,
        ]);
    }

    private function applyTheme(string $tema): void
    {
        // Theme is applied via JavaScript in the layout
        // This just stores the preference
    }

    public function resetSettings()
    {
        $settings = UserSetting::getOrCreate(Auth::user()->id);
        $settings->update(UserSetting::getDefaultSettings());

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan berhasil direset ke default!');
    }
}
