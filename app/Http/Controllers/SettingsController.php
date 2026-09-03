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

        // Konversi manual - terima "true", "false", true, false, 1, 0
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

        return response()->json([
            'success' => true,
            'message' => 'Berhasil disimpan'
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
            'message' => 'Berhasil disimpan'
        ]);
    }
}
