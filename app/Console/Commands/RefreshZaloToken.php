<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RefreshZaloToken extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'zalo:refresh-token';

    /**
     * The console command description.
     */
    protected $description = 'Refresh Zalo OA access token using refresh token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oaId = config('zalo.oa_id');
        $oaSecret = config('zalo.oa_secret');
        $refreshToken = config('zalo.refresh_token');

        if (empty($oaId) || empty($oaSecret) || empty($refreshToken)) {
            $this->error('Zalo configuration is missing. Please check your .env file.');
            return 1;
        }

        $this->info('Refreshing Zalo access token...');

        try {
            $response = Http::asForm()->post('https://oauth.zaloapp.com/v4/oa/access_token', [
                'app_id' => $oaId,
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['access_token'])) {
                    $this->info('New Access Token: ' . $data['access_token']);
                    
                    if (isset($data['refresh_token'])) {
                        $this->info('New Refresh Token: ' . $data['refresh_token']);
                    }
                    
                    $this->info('Expires in: ' . ($data['expires_in'] ?? 'N/A') . ' seconds');
                    $this->newLine();
                    $this->warn('Please update these values in your .env file:');
                    $this->line('ZALO_ACCESS_TOKEN=' . $data['access_token']);
                    
                    if (isset($data['refresh_token'])) {
                        $this->line('ZALO_REFRESH_TOKEN=' . $data['refresh_token']);
                    }
                    
                    return 0;
                } else {
                    $this->error('Error: ' . ($data['error_description'] ?? 'Unknown error'));
                    return 1;
                }
            } else {
                $this->error('Request failed: ' . $response->body());
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('Exception: ' . $e->getMessage());
            return 1;
        }
    }
}
