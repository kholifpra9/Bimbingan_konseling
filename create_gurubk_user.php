<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Creating Guru BK user...\n";

// Create Guru BK user
$user = App\Models\User::create([
    'name' => 'Guru BK Test',
    'email' => 'gurubk@example.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
]);

// Assign role
$user->assignRole('gurubk');

echo "Guru BK user created successfully!\n";
echo "Email: " . $user->email . "\n";
echo "Password: password\n";
echo "Role: gurubk\n";
