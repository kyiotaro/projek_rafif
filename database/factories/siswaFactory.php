<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<siswa>
 */
class siswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $nama_siswa = ['Rizki', 'Fajar', 'Dimas', 'Aulia', 'Fadli', 'Rizal', 'Dewi', 'Putri', 'Siti'];
        return [
            'nama_siswa' => $this->faker->randomElement($nama_siswa),
            'Bb' => $this->faker->numberBetween(40, 100),
            'Tb' => $this->faker->numberBetween(140, 200),
            'kelas_id' => Kelas::factory(),
        ];
    }
}
