<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\guru;

class guruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        guru::factory(5)->create();
    }
}
