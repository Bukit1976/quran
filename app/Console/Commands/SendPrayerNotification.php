<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User; // Sesuaikan dengan nama Model User Bapak
use Illuminate\Support\Facades\Http;

class SendPrayerNotification extends Command
{
    protected $signature = 'prayer:send-notification {prayer_name?}';
    protected $description = 'Kirim notifikasi waktu sholat ke semua user via FCM';

    public function handle()
    {
        // Ambil nama sholat dari parameter, default Fajr
        $prayerName = $this->argument('prayer_name') ?? 'Fajr';

        // Ambil user yang punya token dan mengaktifkan notifikasi
        $users = User::whereNotNull('fcm_token')->where('notification_enabled', true)->get();

        if ($users->isEmpty()) {
            $this->info('Tidak ada user dengan FCM token aktif.');
            return;
        }

        $serverKey = env('FIREBASE_SERVER_KEY');

        if (!$serverKey) {
            $this->error('FIREBASE_SERVER_KEY belum diatur di file .env!');
            return;
        }

        $notificationTitle = '🕌 Waktunya Sholat!';
        $notificationBody = $this->getPrayerBody($prayerName);
        $audioUrl = $this->getAudioUrl($prayerName);

        foreach ($users as $user) {
            try {
                // Kirim request langsung ke Firebase FCM API
                $response = Http::withHeaders([
                    'Authorization' => 'key=' . $serverKey,
                    'Content-Type' => 'application/json',
                ])->post('https://fcm.googleapis.com/fcm/send', [
                    'to' => $user->fcm_token,
                    'priority' => 'high', // PENTING: Memaksa HP untuk memproses notifikasi segera
                    'notification' => [
                        'title' => $notificationTitle,
                        'body' => $notificationBody,
                        'sound' => 'default',
                        'click_action' => url('/jadwal-sholat')
                    ],
                    'data' => [
                        'prayer_name' => $prayerName,
                        'audio_url' => $audioUrl,
                        'click_action' => url('/jadwal-sholat')
                    ]
                ]);

                if ($response->successful()) {
                    $this->info("✅ Berhasil kirim ke: {$user->email}");
                } else {
                    $this->error("❌ Gagal kirim ke {$user->email}: " . $response->body());
                }
            } catch (\Exception $e) {
                $this->error("⚠️ Error pada {$user->email}: {$e->getMessage()}");
            }
        }

        $this->info('🎉 Selesai mengirim notifikasi!');
    }

    private function getPrayerBody($prayer)
    {
        $map = [
            'Fajr' => 'Subuh',
            'Dhuhr' => 'Dzuhur',
            'Asr' => 'Ashar',
            'Maghrib' => 'Maghrib',
            'Isha' => 'Isya'
        ];
        return "Segera tunaikan sholat " . ($map[$prayer] ?? $prayer);
    }

    private function getAudioUrl($prayer)
    {
        $map = [
            'Fajr' => 'https://www.islamcan.com/audio/adhan/azan1.mp3',
            'Dhuhr' => 'https://www.islamcan.com/audio/adhan/azan2.mp3',
            'Asr' => 'https://www.islamcan.com/audio/adhan/azan3.mp3',
            'Maghrib' => 'https://www.islamcan.com/audio/adhan/azan4.mp3',
            'Isha' => 'https://www.islamcan.com/audio/adhan/azan5.mp3'
        ];
        return $map[$prayer] ?? 'https://www.islamcan.com/audio/adhan/azan1.mp3';
    }
}
