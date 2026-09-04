<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        // $userSettings sudah otomatis tersedia di semua view berkat AppServiceProvider
        $settings = UserSetting::getOrCreate(Auth::user()->id);
        return view('settings.index', compact('settings'));
    }

    public function updateToggle(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        $allowedToggles = [
            'tajwid_berwarna',
            'aktifkan_latin',
            'aktifkan_terjemahan',
            'kata_demi_kata',
            'biarkan_layar_menyala',
            'layar_penuh'
        ];

        if (!in_array($field, $allowedToggles)) {
            return response()->json(['success' => false, 'message' => 'Field tidak valid'], 400);
        }

        $booleanValue = ($value === true || $value === 'true' || $value === '1' || $value === 1);

        $settings = UserSetting::getOrCreate(Auth::user()->id);
        $settings->update([$field => $booleanValue]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil disimpan'
        ]);
    }

    public function updateSelect(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        $settings = UserSetting::getOrCreate(Auth::user()->id);
        $settings->update([$field => $value]);

        $label = match ($field) {
            'tema_aplikasi' => $settings->getTemaLabel(),
            'mode_baca_quran' => $settings->getModeBacaLabel(),
            'jenis_penulisan_arabic' => $settings->getJenisPenulisanLabel(),
            'penerjemah' => $settings->getPenerjemahLabel(),
            'qori_murattal' => $settings->getQoriLabel(),
            'aksi_popup_ayat' => $settings->getAksiPopupLabel(),
            default => $value
        };

        return response()->json([
            'success' => true,
            'message' => 'Berhasil disimpan',
            'label' => $label
        ]);
    }

    public function updateFontSize(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        $settings = UserSetting::getOrCreate(Auth::user()->id);
        $settings->update([$field => $value]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil disimpan',
            'value' => $value
        ]);
    }
}
