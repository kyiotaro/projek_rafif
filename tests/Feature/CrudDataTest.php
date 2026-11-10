<?php

namespace Tests\Feature;

use App\Models\guru;
use App\Models\kelas;
use App\Models\siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrudDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_can_be_created_via_post(): void
    {
        $kelas = kelas::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/siswa', [
            'nama_siswa' => 'Rafi',
            'Bb' => 55,
            'Tb' => 170,
            'kelas_id' => $kelas->id,
        ]);

        $response->assertRedirect('/siswa');
        $this->assertDatabaseHas('siswa', [
            'nama_siswa' => 'Rafi',
            'Bb' => 55,
            'Tb' => 170,
        ]);
    }

    public function test_guru_page_displays_data_from_database(): void
    {
        $guru = guru::factory()->create([
            'nama_guru' => 'Budi',
            'mapel' => 'IPA',
        ]);

        $response = $this->actingAs(User::factory()->create(['role' => 'siswa']))
            ->get('/guru');

        $response->assertOk();
        $response->assertSee($guru->nama_guru);
        $response->assertSee($guru->mapel);
    }

    public function test_guru_page_searches_and_filters_by_subject(): void
    {
        guru::factory()->create([
            'nama_guru' => 'Budi',
            'mapel' => 'IPA',
        ]);
        guru::factory()->create([
            'nama_guru' => 'Dewi',
            'mapel' => 'Matematika',
        ]);

        $response = $this->actingAs(User::factory()->create(['role' => 'siswa']))
            ->get('/guru?keyword=IPA&mapel=IPA');

        $response->assertOk();
        $response->assertSee('Budi');
        $response->assertDontSee('Dewi');
    }

    public function test_kelas_page_searches_related_student_and_filters_by_teacher(): void
    {
        $guru = guru::factory()->create(['nama_guru' => 'Guru Target']);
        $targetKelas = kelas::factory()->create([
            'nama_kelas' => 'Kelas Target',
            'guru_id' => $guru->id,
        ]);
        siswa::factory()->create([
            'nama_siswa' => 'Nadia Target',
            'kelas_id' => $targetKelas->id,
        ]);

        $otherGuru = guru::factory()->create(['nama_guru' => 'Guru Lain']);
        $otherKelas = kelas::factory()->create([
            'nama_kelas' => 'Kelas Lain',
            'guru_id' => $otherGuru->id,
        ]);
        siswa::factory()->create([
            'nama_siswa' => 'Nadia Lain',
            'kelas_id' => $otherKelas->id,
        ]);

        $response = $this->actingAs(User::factory()->create(['role' => 'siswa']))
            ->get('/kelas?keyword=Nadia&guru='.$guru->id);

        $response->assertOk();
        $response->assertSee('Kelas Target');
        $response->assertDontSee('Kelas Lain');
    }

    public function test_kelas_can_be_created_via_post(): void
    {
        $guru = guru::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/kelas', [
            'nama_kelas' => 'XI RPL A',
            'guru_id' => $guru->id,
        ]);

        $response->assertRedirect('/kelas');
        $this->assertDatabaseHas('kelas', [
            'nama_kelas' => 'XI RPL A',
        ]);
    }

    public function test_guru_can_create_guru_and_kelas_records(): void
    {
        $user = User::factory()->create(['role' => 'guru']);

        $this->actingAs($user)
            ->post('/guru', [
                'nama_guru' => 'Dewi',
                'mapel' => 'Matematika',
            ])
            ->assertRedirect('/guru');

        $guru = guru::where('nama_guru', 'Dewi')->firstOrFail();

        $this->post('/kelas', [
            'nama_kelas' => 'X IPA 1',
            'guru_id' => $guru->id,
        ])->assertRedirect('/kelas');

        $this->assertDatabaseHas('kelas', [
            'nama_kelas' => 'X IPA 1',
            'guru_id' => $guru->id,
        ]);

        $this->post('/siswa', [])->assertForbidden();
    }
}
