<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class TelegramHelper
{

    protected $token;
    protected $client;

    protected $apiUrl;
    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->client = new Client();
        $this->apiUrl = "https://api.telegram.org/bot{$this->token}/";
    }

    public function replyToMessage($chatId, $text)
    {
        $url = $this->apiUrl . "sendMessage";
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
        $url = $this->apiUrl . "setWebhook";
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


    public function sendPoll($chatId, $question, $options, $params = [])
    {
        $url = $this->apiUrl . "sendPoll";

        $data = [
            'chat_id' => $chatId,
            'question' => $question,
            'options' => json_encode($options),
            'is_anonymous' => $params['is_anonymous'] ?? true,
            'allows_multiple_answers' => $params['allows_multiple_answers'] ?? false,
            'open_period' => $params['open_period'] ?? null,  // Thời gian mở (giây)
            'close_date' => $params['close_date'] ?? null,    // Thời gian đóng (Unix timestamp)
            'explanation' => $params['explanation'] ?? null,  // Giải thích
            'is_closed' => $params['is_closed'] ?? false      // Đã đóng hay chưa
        ];

        try {
            $response = $this->client->post($url, [
                'form_params' => $data
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
