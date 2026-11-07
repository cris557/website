<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Nilai;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            foreach (['Admin', 'Dosen', 'Mahasiswa'] as $name) {
                Role::firstOrCreate(['nama_role' => $name]);
            }

            $adminRole = Role::where('nama_role', 'Admin')->firstOrFail();
            $dosenRole = Role::where('nama_role', 'Dosen')->firstOrFail();
            $mahasiswaRole = Role::where('nama_role', 'Mahasiswa')->firstOrFail();

            User::updateOrCreate(['username' => '25k30003'], [
                'password' => Hash::make('admin123'),
                'nama_lengkap' => 'Elsa Agatha',
                'role_id' => $adminRole->id,
                'foto_profil' => file_exists(public_path('uploads/profil/003.jpg'))
                    ? 'uploads/profil/003.jpg'
                    : 'uploads/profil/default.svg',
                'is_active' => true,
            ]);

            User::updateOrCreate(['username' => 'dosen01'], [
                'password' => Hash::make('dosen123'),
                'nama_lengkap' => 'Dr. Emmanuela Kanaya S.Kom., M.Kom.',
                'role_id' => $dosenRole->id,
                'foto_profil' => 'uploads/profil/default.svg',
                'is_active' => true,
            ]);

            $faker = \Faker\Factory::create('id_ID');
            $students = [];
            $legacyStudents = Mahasiswa::where('nama', 'like', 'Mahasiswa Dummy %')
                ->orderBy('id')
                ->limit(13)
                ->get()
                ->values();
            for ($i = 1; $i <= 13; $i++) {
                $nim = '25k3'.str_pad((string) ($i + 100), 4, '0', STR_PAD_LEFT);
                $student = Mahasiswa::firstOrNew(['nim' => $nim]);
                if (! $student->exists && $legacyStudents->has($i - 1)) {
                    $student = $legacyStudents->get($i - 1);
                }
                $name = $student->exists && ! str_starts_with($student->nama ?? '', 'Mahasiswa Dummy ')
                    ? $student->nama
                    : $faker->name();
                $account = User::updateOrCreate(['username' => $nim], [
                    'password' => Hash::make('mahasiswa123'),
                    'nama_lengkap' => $name,
                    'role_id' => $mahasiswaRole->id,
                    'foto_profil' => 'uploads/profil/default.svg',
                    'is_active' => true,
                ]);

                $student->user_id = $account->id;
                $student->nim = $nim;
                $student->nama = $name;
                $student->jurusan = 'Teknik Informatika';
                $student->angkatan = 2025;
                $student->save();
                $students[] = $student;
            }

            $mk1 = Matakuliah::updateOrCreate(['kode_mk' => 'IF101'], [
                'nama_mk' => 'Pemrograman Web',
                'sks' => 3,
            ]);
            $mk2 = Matakuliah::updateOrCreate(['kode_mk' => 'IF102'], [
                'nama_mk' => 'Basis Data',
                'sks' => 3,
            ]);

            foreach ($students as $index => $student) {
                foreach ([$mk1, $mk2] as $courseIndex => $course) {
                    $score = 65 + (($index * 7 + $courseIndex * 13) % 36);
                    Nilai::updateOrCreate([
                        'mahasiswa_id' => $student->id,
                        'matakuliah_id' => $course->id,
                    ], [
                        'nilai_angka' => $score,
                        'nilai_huruf' => $score >= 85 ? 'A' : ($score >= 70 ? 'B' : ($score >= 60 ? 'C' : 'D')),
                    ]);
                }
            }
        });
    }
}
