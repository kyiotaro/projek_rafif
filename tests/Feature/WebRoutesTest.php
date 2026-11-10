<?php

namespace Tests\Feature;

use App\Models\siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_are_only_available_to_admins(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');

        $this->actingAs(User::factory()->create(['role' => 'siswa']));

        foreach (['dashboard', 'profil', 'guru', 'kelas', 'siswa'] as $page) {
            $this->get("/admin/{$page}")->assertForbidden();
        }

        $this->actingAs(User::factory()->create(['role' => 'admin']));

        foreach (['dashboard', 'profil', 'guru', 'kelas', 'siswa'] as $page) {
            $this->get("/admin/{$page}")->assertOk();
        }
    }

    public function test_siswa_name_parameter_does_not_shadow_resource_routes(): void
    {
        $siswa = siswa::factory()->create();

        $this->get('/siswa/Yurry')->assertRedirect('/login');
        $this->actingAs(User::factory()->create(['role' => 'siswa']));

        $this->get('/siswa/Yurry')
            ->assertOk()
            ->assertSeeText('Nama siswa: Yurry');

        $this->get(route('siswa.show', $siswa))
            ->assertOk();

        $this->get(route('siswa.create'))
            ->assertForbidden();
    }

    public function test_data_pages_require_a_valid_role_and_siswa_cannot_mutate_data(): void
    {
        foreach (['/siswa', '/guru', '/kelas'] as $page) {
            $this->get($page)->assertRedirect('/login');
        }

        $this->actingAs(User::factory()->create(['role' => 'siswa']));
        foreach (['/siswa', '/guru', '/kelas'] as $page) {
            $this->get($page)->assertOk();
        }

        $this->post('/siswa', [])->assertForbidden();

        $this->actingAs(User::factory()->create(['role' => 'user']));
        $this->get('/siswa')
            ->assertForbidden();
    }

    public function test_guru_can_manage_guru_and_kelas_but_not_siswa(): void
    {
        $guru = User::factory()->create(['role' => 'guru']);

        $this->actingAs($guru)
            ->get(route('guru.create'))
            ->assertOk();

        $this->get(route('siswa.create'))
            ->assertForbidden();
    }
}
