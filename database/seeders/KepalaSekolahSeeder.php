<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class KepalaSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'kepsek',
            'guard_name' => 'web'
        ]);

        $data = [
            [
                'email' => 'kepsek@gmail.com',
                'name' => 'Kepsek',
            ],
        ];

        foreach ($data as $item) {
            $user = User::create([
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => Hash::make('kepsek1234'),
            ]);

            $user->assignRole('kepsek');
        }
    }
}
