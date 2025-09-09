<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class KetuaJurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'kajur',
            'guard_name' => 'web'
        ]);

        $data = [
            [
                'email' => 'kajur@gmail.com',
                'name' => 'Kajur',
            ],
        ];

        foreach ($data as $item) {
            $user = User::create([
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => Hash::make('kajur1234'),
            ]);

            $user->assignRole('kajur');
        }
    }
}
