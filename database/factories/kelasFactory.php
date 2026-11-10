<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<kelas>
 */
class kelasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $kelas = ['XI RPL A', 'XI RPL B', 'XI RPL C'];
        return [
            'nama_kelas' => fake()->unique()->randomElement($kelas),
            'guru_id' => Guru::factory(),
        ];
    }
}
