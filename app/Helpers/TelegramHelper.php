<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class TelegramHelper
{

    protected $token;
    protected $client;

    public function __construct()
    {
        $this->token = config('services.telegram.token');
        $this->client = new Client();
    }

    public function replyToMessage($chatId, $text)
    {
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";

        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'chat_id' => $chatId,
                    'text' => $text,
                ]
            ]);
            return response()->json($response->getBody());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function setWebhook()
    {
        $url = "https://api.telegram.org/bot{$this->token}/setWebhook";
        $webhookUrl = env('APP_URL') . 'api/telegram/webhook';
        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'url' => $webhookUrl,
                ]
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
