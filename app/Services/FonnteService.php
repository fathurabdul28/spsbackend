<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected string $token;
    protected string $apiUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = env('FONNTE_TOKEN', '');
    }

    /**
     * Send a WhatsApp message via Fonnte.
     *
     * @param  string  $phone   Recipient phone number (e.g. 08xxxxxxxxxx)
     * @param  string  $message Message body
     * @return bool
     */
    public function send(string $phone, string $message): bool
    {
        if (empty($this->token) || empty($phone)) {
            Log::warning('[Fonnte] Token or phone number is empty, skipping WA notification.');
            return false;
        }

        // Normalise phone: remove leading zeros/+62 and re-add 62 prefix
        $phone = preg_replace('/^(\+62|62|0)/', '62', trim($phone));

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->apiUrl, [
                'target'  => $phone,
                'message' => $message,
                'countryCode' => '62',
            ]);

            $body = $response->json();

            if ($response->successful() && ($body['status'] ?? false)) {
                Log::info("[Fonnte] WA sent to {$phone}");
                return true;
            }

            Log::warning('[Fonnte] Failed to send WA: ' . json_encode($body));
            return false;

        } catch (\Throwable $e) {
            Log::error('[Fonnte] Exception: ' . $e->getMessage());
            return false;
        }
    }
}
