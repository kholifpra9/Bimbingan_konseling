<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use app\Models\Siswa;
use App\Models\User;
use PhpParser\Node\Expr\Cast\Array_;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if role exists before creating
        if (!Role::where('name', 'siswa')->exists()) {
            Role::create(['name' => 'siswa','guard_name' => 'web',]);
        }
        
        $data = [
            [
            'nis' => '56790',
            'email' => 'Risdyana@gmail.com',
            'nama' => 'Risdy',
            'kelas' => '12',
            'jurusan' => 'TKRO',
            'jenis_kelamin' => 'Laki-Laki',
            'no_tlp' => '089678900',
            'alamat' => 'Kp.pataruman'
            ],

            [
            'nis' => '56791',
            'email' => 'Ikrimahk@gmail.com',
            'nama' => 'Ikrimah',
            'kelas' => '12',
            'jurusan' => 'DPIB',
            'jenis_kelamin' => 'Perempuan',
            'no_tlp' => '089678901',
            'alamat' => 'Kp.pataruman'
            ],

            [
            'nis' => '56792',
            'email' => 'Dzakiyya@gmail.com',
            'nama' => 'Dzakiyya',
            'kelas' => '12',
            'jurusan' => 'TKJ',
            'jenis_kelamin' => 'Perempuan',
            'no_tlp' => '089678902',
            'alamat' => 'Margaluyu'
            ],
                
            [
            'nis' => '56793',
            'email' => 'Aufa@gmail.com',
            'nama' => 'Aufa',
            'kelas' => '12',
            'jurusan' => 'TITL',
            'jenis_kelamin' => 'Laki-laki',
            'no_tlp' => '089678903',
            'alamat' => 'Margaluyu'
            ],

            [
            'nis' => '56794',
            'email' => 'Luki@gmail.com',
            'nama' => 'Luki',
            'kelas' => '12',
            'jurusan' => 'TM',
            'jenis_kelamin' => 'Laki-laki',
            'no_tlp' => '089678904',
            'alamat' => 'Kp.pataruman'
            ],
        ];
        
        foreach ($data as $item) {
            $user = User::create([
                'name' => $item['nama'],
                'email' => $item['email'],
                'password' => Hash::make('siswa123'),
            ]);

            DB::table('siswa')->insert([
                [
                    'nis' => $item['nis'],
                    'nama' => $item['nama'],
                    'kelas' => $item['kelas'],
                    'jurusan' => $item['jurusan'],
                    'jenis_kelamin' => $item['jenis_kelamin'],
                    'no_tlp' => $item['no_tlp'],
                    'alamat' => $item['alamat'],
                    'id_user' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            $user->assignRole('siswa');
        }

    }
}
