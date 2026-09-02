<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('murajaahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ayat_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_murajaah');
            $table->enum('status', ['belum', 'selesai'])->default('belum');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('murajaahs');
    }
};
