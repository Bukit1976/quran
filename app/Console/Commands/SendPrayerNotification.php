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
            'notification' => [
                'title' => 'Waktu Sholat ' . $prayer['name'],
                'body' => 'Saatnya menunaikan sholat ' . $prayer['name'],
                'sound' => 'default',
                'click_action' => url('/jadwal-sholat')
            ]
        ]);
    }
}
