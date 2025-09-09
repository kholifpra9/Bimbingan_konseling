<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create siswa role if not exists
        $siswaRole = Role::firstOrCreate(['name' => 'siswa']);

        // Create test siswa user
        $siswaUser = User::firstOrCreate(
            ['email' => 'siswa@example.com'],
            [
                'name' => 'Siswa Test',
                'password' => Hash::make('password'),
            ]
        );

        // Assign siswa role
        if (!$siswaUser->hasRole('siswa')) {
            $siswaUser->assignRole('siswa');
        }

        // Create siswa data if not exists
        $siswa = Siswa::firstOrCreate(
            ['id_user' => $siswaUser->id],
            [
                'nis' => '12345678',
                'nama' => 'Siswa Test',
                'kelas' => 'XII RPL 1',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'jenis_kelamin' => 'L',
                'no_tlp' => '081234567890',
                'no_tlp_ortu' => '081234567891',
                'alamat' => 'Jl. Test No. 123, Cilaku',
            ]
        );

        // Create another test user (Risdy) if exists, link with siswa data
        $risdyUser = User::where('name', 'Risdy')->first();
        if ($risdyUser && !$risdyUser->siswa) {
            // Assign siswa role if not already assigned
            if (!$risdyUser->hasRole('siswa')) {
                $risdyUser->assignRole('siswa');
            }

            // Create siswa data for Risdy
            Siswa::firstOrCreate(
                ['id_user' => $risdyUser->id],
                [
                    'nis' => '87654321',
                    'nama' => 'Risdy',
                    'kelas' => 'XII RPL 2',
                    'jurusan' => 'Rekayasa Perangkat Lunak',
                    'jenis_kelamin' => 'L',
                    'no_tlp' => '081234567892',
                    'no_tlp_ortu' => '081234567893',
                    'alamat' => 'Jl. Risdy No. 456, Cilaku',
                ]
            );
        }

        $this->command->info('User-Siswa relationships created successfully!');
    }
}
