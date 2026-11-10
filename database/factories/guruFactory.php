<?php

namespace Database\Factories;

use App\Models\guru;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<guru>
 */
class guruFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $nama_guru = ['Rizki', 'Fajar', 'Dimas', 'Aulia', 'Fadli', 'Rizal', 'Dewi', 'Putri', 'Siti'];
        static $mapel = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS'];
        return [
            'nama_guru' => $this->faker->randomElement($nama_guru),
            'mapel' => $this->faker->randomElement($mapel),
        ];
    }
}
