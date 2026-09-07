<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class SendPrayerNotification extends Command
{
    protected $signature = 'prayer:notify';
    protected $description = 'Send prayer time notifications';

    public function handle()
    {
        $users = User::whereNotNull('fcm_token')
            ->where('notification_enabled', true)
            ->get();

        $prayerTimes = $this->getCurrentPrayerTime();

        foreach ($users as $user) {
            $this->sendNotification($user->fcm_token, $prayerTimes);
        }

        $this->info('Notifications sent!');
    }

    // Tambahkan return type ': array'
    private function getCurrentPrayerTime(): array
    {
        // Logika untuk mendapatkan waktu sholat saat ini
        // Nanti Bapak sesuaikan dengan database/jadwal sholat yang sudah ada
        return [
            'name' => 'Dzuhur',
            'time' => '12:00'
        ];
    }

    // Tambahkan type hinting: string $token, array $prayer, dan return type : void
    private function sendNotification(string $token, array $prayer): void
    {
        $serverKey = env('FIREBASE_SERVER_KEY');

        Http::withHeaders([
            'Authorization' => 'key=' . $serverKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'to' => $token,
            'priority' => 'high', // PENTING: Memaksa HP untuk segera memproses notifikasi
            'time_to_live' => 60, // Notifikasi hangus jika HP tidak online dalam 60 detik
            'notification' => [
                'title' => '🔔 Waktu Sholat ' . $prayer['name'],
                'body' => 'Ayolah, saatnya menunaikan sholat ' . $prayer['name'],
                'sound' => 'alarm.mp3', // Nama file suara (untuk Android native)
                'click_action' => url('/jadwal-sholat'),
                'icon' => url('/Logo/LogoNew.png')
            ],
            // Payload tambahan untuk memastikan HP bangun dari standby
            'android' => [
                'priority' => 'high',
                'notification' => [
                    'sound' => 'alarm.mp3',
                    'default_vibrate_timings' => true
                ]
            ]
        ]);
    }
}
