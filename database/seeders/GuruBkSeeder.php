<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class GuruBkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'gurubk', 'guard_name' => 'web',]);
        $data = [
            [
                'nip' => '1234',
                'email' => 'puput@gmail.com',
                'nama' => 'Puput',
                'jenis_kelamin' => 'Perempuan',
                'no_tlp' => '08780000',
                'alamat' => 'Kp.nagrak'
            ],
        ];
        
        foreach ($data as $item) {
            $user = User::create([
                'name' => $item['nama'],
                'email' => $item['email'],
                'password' => Hash::make('ppt123'),
            ]);
            
            $user->assignRole('gurubk');

            DB::table('gurubk')->insert([
                'nip' => '1234',
                'nama' => 'Puput',
                'jenis_kelamin' => 'Perempuan',
                'no_tlp' => '08780000',
                'alamat' => 'Kp.nagrak',
                'id_user' => $user->id,
            ]);
        }
    }
}
