<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Tampilan
            $table->string('tema_aplikasi')->default('mengikuti_perangkat'); // mengikuti_perangkat, gelap, terang
            $table->string('mode_baca_quran')->default('selalu_tanya'); // selalu_tanya, otomatis_mushaf, otomatis_hafalan

            // Arabic
            $table->string('jenis_penulisan_arabic')->default('indopak'); // indopak, utsmani, imlaei
            $table->boolean('tajwid_berwarna')->default(true);
            $table->integer('ukuran_font_arabic')->default(18);

            // Latin (Transliterasi)
            $table->boolean('aktifkan_latin')->default(true);
            $table->integer('ukuran_font_latin')->default(16);

            // Terjemahan
            $table->boolean('aktifkan_terjemahan')->default(true);
            $table->string('penerjemah')->default('kemenag-ri'); // kemenag-ri, quraish-shihab, etc
            $table->integer('ukuran_font_terjemahan')->default(16);
            $table->boolean('kata_demi_kata')->default(false);

            // Audio Murattal
            $table->string('qori_murattal')->default('mishary_rashid');
            $table->string('aksi_popup_ayat')->default('diklik'); // diklik, ditahan

            // Lainnya
            $table->boolean('biarkan_layar_menyala')->default(true);
            $table->boolean('layar_penuh')->default(false);

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
