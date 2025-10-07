<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tamus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('instansi');
            $table->string('tujuan');
            $table->timestamp('waktu_kedatangan')->useCurrent();
            $table->timestamps();
            $table->charset='utf8mb4';
            $table->collation='utf8mb4_unicode_ci';
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('tamus');
    }
};
