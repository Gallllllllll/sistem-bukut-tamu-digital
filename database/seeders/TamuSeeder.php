<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TamuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tamus')->insert([
            [
                'nama' => 'Ara Putri',
                'instansi' => 'TK A Ceria',
                'tujuan' => 'Bertemu Kepala Sekolah',
                'waktu_kedatangan' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dina Lestari',
                'instansi' => 'SD Harapan Bangsa',
                'tujuan' => 'Menyerahkan dokumen',
                'waktu_kedatangan' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
