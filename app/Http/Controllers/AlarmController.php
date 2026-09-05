<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AlarmController extends Controller
{
    public function index()
    {
        $alarms = Alarm::where('user_id', Auth::id())
            ->orderBy('time')
            ->get();

        return view('alarms.index', compact('alarms'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'time' => 'required|date_format:H:i',
            'label' => 'nullable|string|max:255',
            'audio' => 'nullable|file|mimes:mp3,wav,m4a,aac,flac|max:51200',
            'alarm_id' => 'nullable|integer|exists:alarms,id',
        ]);

        $alarmId = $request->input('alarm_id');

        if ($alarmId) {
            $alarm = Alarm::where('id', $alarmId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $alarm->time = $request->time;
            $alarm->label = $request->label;

            if ($request->hasFile('audio')) {
                if ($alarm->audio_path) {
                    Storage::disk('public')->delete($alarm->audio_path);
                }
                $alarm->audio_path = $request->file('audio')->store('alarm_audio', 'public');
            }

            $alarm->save();

            return redirect()->route('alarm.index')
                ->with('success', 'Alarm berhasil diperbarui!');
        }

        $alarm = new Alarm();
        $alarm->user_id = Auth::id();
        $alarm->time = $request->time;
        $alarm->label = $request->label;
        $alarm->is_active = true;

        if ($request->hasFile('audio')) {
            $alarm->audio_path = $request->file('audio')->store('alarm_audio', 'public');
        }

        $alarm->save();

        return redirect()->route('alarm.index')
            ->with('success', 'Alarm berhasil ditambahkan!');
    }

    public function destroy(Alarm $alarm)
    {
        if ($alarm->user_id !== Auth::id()) {
            abort(403);
        }

        if ($alarm->audio_path) {
            Storage::disk('public')->delete($alarm->audio_path);
        }

        $alarm->delete();

        return redirect()->route('alarm.index')
            ->with('success', 'Alarm berhasil dihapus!');
    }

    public function toggle(Alarm $alarm)
    {
        if ($alarm->user_id !== Auth::id()) {
            abort(403);
        }

        $alarm->is_active = !$alarm->is_active;
        $alarm->save();

        return redirect()->route('alarm.index');
    }
}
