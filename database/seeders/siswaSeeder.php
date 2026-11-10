<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\siswa;
use App\Models\Kelas;

class siswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasIds = Kelas::query()->pluck('id')->all();

        if ($kelasIds === []) {
            throw new \RuntimeException('Seed classes before seeding students.');
        }

        siswa::factory(20)->state(fn () => [
            'kelas_id' => $kelasIds[array_rand($kelasIds)],
        ])->create();
    }
}
