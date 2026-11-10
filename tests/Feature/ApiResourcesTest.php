<?php

namespace Tests\Feature;

use App\Models\guru;
use App\Models\kelas;
use App\Models\siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiResourcesTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_api_supports_crud_and_returns_its_class(): void
    {
        $kelas = kelas::factory()->create();

        $response = $this->postJson('/api/siswa', [
            'nama_siswa' => 'Rafi',
            'Bb' => 55,
            'Tb' => 170,
            'kelas_id' => $kelas->id,
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.nama_siswa', 'Rafi')
            ->assertJsonPath('data.kelas.id', $kelas->id);

        $siswa = siswa::firstOrFail();

        $this->getJson('/api/siswa')->assertOk()
            ->assertJsonPath('data.0.id', $siswa->id);
        $this->getJson("/api/siswa/{$siswa->id}")->assertOk()
            ->assertJsonPath('data.nama_siswa', 'Rafi');
        $this->patchJson("/api/siswa/{$siswa->id}", ['Bb' => 60])
            ->assertOk()
            ->assertJsonPath('data.Bb', 60);
        $this->deleteJson("/api/siswa/{$siswa->id}")->assertOk();

        $this->assertDatabaseMissing('siswa', ['id' => $siswa->id]);
    }

    public function test_guru_api_supports_crud_and_returns_related_classes(): void
    {
        $response = $this->postJson('/api/guru', [
            'nama_guru' => 'Dewi',
            'mapel' => 'Matematika',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.nama_guru', 'Dewi')
            ->assertJsonPath('data.mapel', 'Matematika');

        $guru = guru::firstOrFail();
        $kelas = kelas::factory()->create(['guru_id' => $guru->id]);

        $this->getJson('/api/guru')->assertOk()
            ->assertJsonPath('data.0.kelas.0.id', $kelas->id);
        $this->getJson("/api/guru/{$guru->id}")->assertOk()
            ->assertJsonPath('data.nama_guru', 'Dewi');
        $this->patchJson("/api/guru/{$guru->id}", ['mapel' => 'IPA'])
            ->assertOk()
            ->assertJsonPath('data.mapel', 'IPA');
        $this->deleteJson("/api/guru/{$guru->id}")->assertOk();

        $this->assertDatabaseMissing('guru', ['id' => $guru->id]);
        $this->assertDatabaseMissing('kelas', ['id' => $kelas->id]);
    }

    public function test_kelas_api_supports_crud_and_returns_related_teacher(): void
    {
        $guru = guru::factory()->create();

        $response = $this->postJson('/api/kelas', [
            'nama_kelas' => 'XI RPL A',
            'guru_id' => $guru->id,
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.nama_kelas', 'XI RPL A')
            ->assertJsonPath('data.guru.id', $guru->id);

        $kelas = kelas::firstOrFail();

        $this->getJson('/api/kelas')->assertOk()
            ->assertJsonPath('data.0.id', $kelas->id);
        $this->getJson("/api/kelas/{$kelas->id}")->assertOk()
            ->assertJsonPath('data.guru.nama_guru', $guru->nama_guru);
        $this->patchJson("/api/kelas/{$kelas->id}", ['nama_kelas' => 'XI RPL B'])
            ->assertOk()
            ->assertJsonPath('data.nama_kelas', 'XI RPL B');
        $this->deleteJson("/api/kelas/{$kelas->id}")->assertOk();

        $this->assertDatabaseMissing('kelas', ['id' => $kelas->id]);
    }

    public function test_api_validates_foreign_keys_and_siswa_fields(): void
    {
        $this->postJson('/api/siswa', [
            'nama_siswa' => 'Rafi',
            'Bb' => -1,
            'Tb' => 170,
            'kelas_id' => 999,
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['Bb', 'kelas_id']);

        $this->postJson('/api/kelas', [
            'nama_kelas' => 'XI RPL A',
            'guru_id' => 999,
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['guru_id']);
    }
}
