<?php

namespace App\Http\Controllers;

use App\Helpers\LunarCalendarHelper;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use LucNham\LunarCalendar\LunarDateTime;
use Jenssegers\Date\Date;

class TelegramController extends Controller
{
    protected $telegram;
    protected $client;
    protected $token;
    protected $chatId;
    public function __construct()
    {
        $this->client = new Client();
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }

    public function sendMessage($message)
    {
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";

        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'chat_id' => $this->chatId,
                    'text' => $message,
                ]
            ]);
            return response()->json($response->getBody());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sendMessageToTelegram()
    {
        $message = "Hello, World!";
        $this->sendMessage($message);
    }

}
