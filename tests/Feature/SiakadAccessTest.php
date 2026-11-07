<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Nilai;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class SiakadAccessTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_shows_role_dashboard_and_logout_returns_to_login(): void
    {
        $dosen = $this->createUser('Dosen');

        $this->post('/login', [
            'username' => $dosen->username,
            'password' => 'password123',
        ])->assertRedirect(route('dashboard'));

        $this->get('/dashboard')->assertOk()
            ->assertSee($dosen->nama_lengkap)
            ->assertSee('PANEL DOSEN');

        $this->post('/logout')->assertRedirect('/login');
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_disabled_accounts_cannot_log_in(): void
    {
        $user = $this->createUser('Mahasiswa', false);

        $this->post('/login', [
            'username' => $user->username,
            'password' => 'password123',
        ])->assertSessionHasErrors('username');
    }

    public function test_deactivated_user_session_is_logged_out_on_next_request(): void
    {
        $user = $this->createUser('Dosen');
        $this->actingAs($user);
        $user->update(['is_active' => false]);

        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/login')->assertOk()->assertSee('Akun Anda telah dinonaktifkan.');
    }

    public function test_student_dashboard_only_shows_the_linked_academic_profile_and_grades(): void
    {
        $user = $this->createUser('Mahasiswa');
        $student = Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $user->username,
            'nama' => $user->nama_lengkap,
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2025,
        ]);
        $course = Matakuliah::create([
            'kode_mk' => 'T'.Str::upper(Str::random(8)),
            'nama_mk' => 'Mata Kuliah Dashboard Uji',
            'sks' => 3,
        ]);
        Nilai::create([
            'mahasiswa_id' => $student->id,
            'matakuliah_id' => $course->id,
            'nilai_angka' => 88,
            'nilai_huruf' => 'A',
        ]);

        $this->post('/login', [
            'username' => $user->username,
            'password' => 'password123',
        ])->assertRedirect(route('dashboard'));

        $this->get('/dashboard')->assertOk()
            ->assertSee($user->nama_lengkap)
            ->assertSee($student->nim)
            ->assertSee($course->nama_mk)
            ->assertSee('88');
    }

    public function test_dosen_can_create_and_update_students_but_cannot_delete_them(): void
    {
        $this->actingAs($this->createUser('Dosen'));

        $this->post('/mahasiswa', [
            'nim' => 'test-'.Str::lower(Str::random(8)),
            'nama' => 'Nama Uji',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2025,
        ])->assertRedirect(route('mahasiswa.index'));

        $student = Mahasiswa::where('nama', 'Nama Uji')->latest('id')->firstOrFail();
        $this->put(route('mahasiswa.update', $student), [
            'nim' => $student->nim,
            'nama' => 'Nama Uji Diperbarui',
            'jurusan' => 'Sistem Informasi',
            'angkatan' => 2024,
        ])->assertRedirect(route('mahasiswa.index'));

        $this->delete(route('mahasiswa.destroy', $student))->assertForbidden();
        $this->assertDatabaseHas('t003_mahasiswa', [
            'id' => $student->id,
            'nama' => 'Nama Uji Diperbarui',
        ]);
    }

    public function test_admin_can_create_users_with_hashed_password_and_change_role_and_status(): void
    {
        $this->actingAs($this->createUser('Admin'));
        $this->get('/dashboard')->assertOk()
            ->assertSee('ADMINISTRATOR')
            ->assertSee('Kelola pengguna');
        $username = 'test-'.Str::lower(Str::random(10));
        $mahasiswaRole = Role::firstOrCreate(['nama_role' => 'Mahasiswa']);

        $this->post('/users', [
            'nama_lengkap' => 'Akun Uji',
            'username' => $username,
            'role_id' => Role::where('nama_role', 'Dosen')->value('id'),
            'is_active' => 1,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('users.index'));

        $user = User::where('username', $username)->firstOrFail();
        $this->assertTrue(Hash::check('password123', $user->password));

        $this->put(route('users.update', $user), [
            'nama_lengkap' => 'Akun Uji',
            'username' => $username,
            'role_id' => $mahasiswaRole->id,
            'is_active' => 0,
            'password' => '',
            'password_confirmation' => '',
        ])->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('t003_users', [
            'id' => $user->id,
            'role_id' => $mahasiswaRole->id,
            'is_active' => 0,
        ]);
    }

    public function test_dosen_can_create_and_update_courses_and_grades_and_admin_can_delete_grades(): void
    {
        $dosen = $this->createUser('Dosen');
        $this->actingAs($dosen);
        $code = 'T'.Str::upper(Str::random(8));

        $this->post('/matakuliah', [
            'kode_mk' => $code,
            'nama_mk' => 'Mata Kuliah Uji',
            'sks' => 3,
        ])->assertRedirect(route('matakuliah.index'));

        $course = Matakuliah::where('kode_mk', $code)->firstOrFail();
        $this->put(route('matakuliah.update', $course), [
            'kode_mk' => $code,
            'nama_mk' => 'Mata Kuliah Uji Diperbarui',
            'sks' => 4,
        ])->assertRedirect(route('matakuliah.index'));

        $student = Mahasiswa::firstOrFail();
        $this->post('/nilai', [
            'mahasiswa_id' => $student->id,
            'matakuliah_id' => $course->id,
            'nilai_angka' => 91,
        ])->assertRedirect(route('nilai.index'));

        $grade = Nilai::where('mahasiswa_id', $student->id)
            ->where('matakuliah_id', $course->id)
            ->firstOrFail();
        $this->assertSame('A', $grade->nilai_huruf);

        $this->put(route('nilai.update', $grade), [
            'mahasiswa_id' => $student->id,
            'matakuliah_id' => $course->id,
            'nilai_angka' => 68,
        ])->assertRedirect(route('nilai.index'));
        $this->assertDatabaseHas('t003_nilai', ['id' => $grade->id, 'nilai_huruf' => 'C']);
        $this->delete(route('nilai.destroy', $grade))->assertForbidden();

        $this->actingAs($this->createUser('Admin'))
            ->delete(route('nilai.destroy', $grade))
            ->assertRedirect(route('nilai.index'));
        $this->assertDatabaseMissing('t003_nilai', ['id' => $grade->id]);
    }

    private function createUser(string $roleName, bool $active = true): User
    {
        $role = Role::firstOrCreate(['nama_role' => $roleName]);

        return User::create([
            'username' => 'test-'.Str::lower(Str::random(12)),
            'password' => Hash::make('password123'),
            'nama_lengkap' => 'Pengguna Uji '.$roleName,
            'role_id' => $role->id,
            'foto_profil' => 'uploads/profil/default.svg',
            'is_active' => $active,
        ]);
    }
}
