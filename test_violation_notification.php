<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Services\WhatsAppNotificationService;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 Testing Violation Notification System\n";
echo "=====================================\n\n";

try {
    // 1. Find or create test student
    $siswa = Siswa::where('nama', 'Test Siswa Pelanggaran')->first();
    
    if (!$siswa) {
        echo "❌ Test student not found. Creating test student...\n";
        
        // Create test user first
        $user = \App\Models\User::create([
            'name' => 'Test Siswa Pelanggaran',
            'email' => 'test.pelanggaran@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        
        // Assign siswa role
        $user->assignRole('siswa');
        
        // Create siswa record
        $siswa = Siswa::create([
            'nis' => '2024999999',
            'nama' => 'Test Siswa Pelanggaran',
            'kelas' => 'XII RPL 1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'jenis_kelamin' => 'L',
            'no_tlp' => '081234567890',
            'no_tlp_ortu' => '081234567891', // Parent's number for notification
            'alamat' => 'Jl. Test No. 123',
            'id_user' => $user->id,
        ]);
        
        echo "✅ Test student created: {$siswa->nama}\n";
    } else {
        echo "✅ Test student found: {$siswa->nama}\n";
    }
    
    // 2. Check current violation points
    $currentPoints = Pelanggaran::getTotalPointsForStudent($siswa->id);
    echo "📊 Current violation points: {$currentPoints}\n";
    
    // 3. Add violations to reach 65+ points
    $targetPoints = 70;
    $pointsNeeded = $targetPoints - $currentPoints;
    
    if ($pointsNeeded > 0) {
        echo "➕ Adding {$pointsNeeded} points to reach {$targetPoints} total points...\n";
        
        // Add a major violation
        $pelanggaran = Pelanggaran::create([
            'id_siswa' => $siswa->id,
            'jenis_pelanggaran' => 'Berkelahi dengan teman sekelas',
            'point_pelanggaran' => $pointsNeeded,
        ]);
        
        echo "✅ Violation added: {$pelanggaran->jenis_pelanggaran} ({$pointsNeeded} points)\n";
    } else {
        echo "ℹ️  Student already has sufficient violation points\n";
        
        // Create a new violation to trigger notification
        $pelanggaran = Pelanggaran::create([
            'id_siswa' => $siswa->id,
            'jenis_pelanggaran' => 'Terlambat masuk kelas',
            'point_pelanggaran' => 5,
        ]);
        
        echo "✅ New violation added: {$pelanggaran->jenis_pelanggaran} (5 points)\n";
    }
    
    // 4. Check if notification is needed
    $needsNotification = Pelanggaran::needsNotification($siswa->id);
    $totalPoints = Pelanggaran::getTotalPointsForStudent($siswa->id);
    
    echo "📊 Total violation points: {$totalPoints}\n";
    echo "🔔 Needs notification: " . ($needsNotification ? 'YES' : 'NO') . "\n\n";
    
    if ($needsNotification) {
        echo "📱 Testing WhatsApp notification...\n";
        
        // 5. Test WhatsApp notification
        $whatsappNumber = $siswa->getWhatsAppNumber();
        echo "📞 WhatsApp number: {$whatsappNumber}\n";
        
        if ($whatsappNumber) {
            // Prepare notification message
            $message = "🚨 *PERINGATAN PELANGGARAN SISWA* 🚨\n\n";
            $message .= "Kepada Yth. Orang Tua/Wali dari:\n";
            $message .= "👤 *Nama*: {$siswa->nama}\n";
            $message .= "🏫 *Kelas*: {$siswa->kelas}\n";
            $message .= "📚 *Jurusan*: {$siswa->jurusan}\n\n";
            
            $message .= "📊 *INFORMASI PELANGGARAN:*\n";
            $message .= "• Total Poin Pelanggaran: *{$totalPoints} poin*\n";
            $message .= "• Pelanggaran Terbaru: {$pelanggaran->jenis_pelanggaran}\n";
            $message .= "• Poin Pelanggaran Terbaru: {$pelanggaran->point_pelanggaran} poin\n\n";
            
            $message .= "⚠️ *PERHATIAN:*\n";
            $message .= "Siswa telah mencapai batas kritis pelanggaran (≥65 poin).\n";
            $message .= "Mohon segera menghubungi Guru BK untuk konsultasi lebih lanjut.\n\n";
            
            $message .= "📞 *Hubungi Guru BK:*\n";
            $message .= "SMK SILIWANGI\n";
            $message .= "Jl. Raya Garut - Tasikmalaya\n\n";
            
            $message .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
            $message .= "_Pesan otomatis dari Sistem Bimbingan Konseling_";
            
            // Send notification
            $whatsappService = new WhatsAppNotificationService();
            $sent = $whatsappService->sendViolationNotification($whatsappNumber, $message);
            
            if ($sent) {
                echo "✅ WhatsApp notification sent successfully!\n";
                
                // Mark notification as sent
                $pelanggaran->markNotificationSent($message);
                echo "✅ Notification marked as sent in database\n";
            } else {
                echo "❌ Failed to send WhatsApp notification\n";
                echo "ℹ️  Check your FONNTE_API_TOKEN in .env file\n";
            }
        } else {
            echo "❌ No WhatsApp number found for student\n";
        }
    } else {
        echo "ℹ️  No notification needed (already sent or points < 65)\n";
    }
    
    echo "\n📋 Summary:\n";
    echo "- Student: {$siswa->nama}\n";
    echo "- Total Points: {$totalPoints}\n";
    echo "- WhatsApp: {$whatsappNumber}\n";
    echo "- Notification Needed: " . ($needsNotification ? 'YES' : 'NO') . "\n";
    
    echo "\n✅ Test completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
