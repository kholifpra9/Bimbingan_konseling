<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class KesiswaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'kesiswaan']);
        
        $user = User::create([
            'name' => 'Kesiswaan User',
            'email' => 'kesiswaan@example.com',
            'password' => Hash::make('password')
        ]);
        
        $user->assignRole($role);
    }
}
