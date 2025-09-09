<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppNotificationService;

class TestWhatsAppConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test WhatsApp API connection using Fonnte';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing WhatsApp API connection...');
        
        $whatsappService = new WhatsAppNotificationService();
        $result = $whatsappService->testConnection();
        
        if ($result['success']) {
            $this->info('✅ ' . $result['message']);
            if (isset($result['data'])) {
                $this->table(['Key', 'Value'], collect($result['data'])->map(function ($value, $key) {
                    return [$key, is_array($value) ? json_encode($value) : $value];
                })->toArray());
            }
        } else {
            $this->error('❌ ' . $result['message']);
        }
        
        return $result['success'] ? 0 : 1;
    }
}
