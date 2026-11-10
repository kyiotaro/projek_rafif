<?php

namespace Tests\Feature;

use App\Models\siswa;
use App\Models\kelas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_page_displays_data_from_database(): void
    {
        $siswa = siswa::factory()->create([
            'nama_siswa' => 'Rafi',
        ]);

        $response = $this->actingAs(User::factory()->create(['role' => 'siswa']))
            ->get('/siswa');

        $response->assertOk();
        $response->assertSee($siswa->nama_siswa);
    }

    public function test_siswa_page_filters_by_name_keyword(): void
    {
        $kelas = kelas::factory()->create();
        siswa::factory()->create([
            'nama_siswa' => 'Rafi Pratama',
            'kelas_id' => $kelas->id,
        ]);
        siswa::factory()->create([
            'nama_siswa' => 'Dina Putri',
            'kelas_id' => $kelas->id,
        ]);

        $response = $this->actingAs(User::factory()->create(['role' => 'siswa']))
            ->get('/siswa?keyword=Rafi');

        $response->assertOk();
        $response->assertSee('Rafi Pratama');
        $response->assertDontSee('Dina Putri');
    }

    public function test_siswa_page_searches_by_height_and_applies_body_filters(): void
    {
        $kelas = kelas::factory()->create();
        siswa::factory()->create([
            'nama_siswa' => 'Rafi Pratama',
            'Bb' => 55,
            'Tb' => 170,
            'kelas_id' => $kelas->id,
        ]);
        siswa::factory()->create([
            'nama_siswa' => 'Dina Putri',
            'Bb' => 55,
            'Tb' => 165,
            'kelas_id' => $kelas->id,
        ]);

        $response = $this->actingAs(User::factory()->create(['role' => 'siswa']))
            ->get('/siswa?keyword=170&kelas='.$kelas->id.'&bb_min=50&tb_min=168');

        $response->assertOk();
        $response->assertSee('Rafi Pratama');
        $response->assertDontSee('Dina Putri');
    }
}
