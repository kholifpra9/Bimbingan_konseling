<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Creating test data for surat pemanggilan...\n";

$user = App\Models\User::where('email', 'siswa@example.com')->first();
if (!$user || !$user->siswa) {
    echo "Error: User or siswa data not found\n";
    exit;
}

$cekMasalah = new App\Models\CekMasalah();
$cekMasalah->id_siswa = $user->siswa->id;
$cekMasalah->kategori_masalah = ['pribadi', 'sosial'];
$cekMasalah->masalah_terpilih = ['Masalah keluarga', 'Kurang percaya diri', 'Sulit bergaul dengan teman'];
$cekMasalah->masalah_lain = 'Sering merasa cemas dan takut';
$cekMasalah->tingkat_urgensi = 'tinggi';
$cekMasalah->deskripsi_tambahan = 'Siswa sering menangis di kelas dan menolak berinteraksi dengan teman-teman. Prestasi akademik menurun drastis dalam 2 bulan terakhir.';
$cekMasalah->status = 'pending';
$cekMasalah->save();

echo "Test data created successfully!\n";
echo "CekMasalah ID: " . $cekMasalah->id . "\n";
echo "Siswa: " . $user->siswa->nama . "\n";
echo "Tingkat Urgensi: " . $cekMasalah->tingkat_urgensi . "\n";
echo "Status: " . $cekMasalah->status . "\n";
