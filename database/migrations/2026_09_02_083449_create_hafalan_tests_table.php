<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hafalan_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ayat_id')->constrained()->onDelete('cascade');
            $table->string('jenis_tes'); // lanjutkan_ayat, tebak_arti, susun_kata
            $table->integer('skor'); // 0 - 100
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hafalan_tests');
    }
};
