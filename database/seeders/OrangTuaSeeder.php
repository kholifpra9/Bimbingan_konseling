<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class OrangTuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'orangtua']);
        
        $user = User::create([
            'name' => 'Orang Tua User',
            'email' => 'orangtua@example.com',
            'password' => Hash::make('password')
        ]);
        
        $user->assignRole($role);
    }
}
