<?php

namespace App\Http\Controllers;

use App\Helpers\LunarCalendarHelper;
use App\Helpers\TelegramHelper;
use App\Services\ChiService;
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
    protected $chiService;
    public function __construct()
    {
        $this->telegram = new TelegramHelper();
        $this->chiService = new ChiService();
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

    public function handleWebhook(Request $request)
    {
        $update = $request->all();

        // Ghi log để kiểm tra dữ liệu
        // info('Telegram update', $update);

        // Kiểm tra xem có tin nhắn hay không
        if (isset($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = $message['text'] ?? '';
            $userId = $message['from']['id'] ?? null;
            $userName = $message['from']['first_name'] ?? 'User';

            // Kiểm tra lệnh /chi
            if (preg_match('/^\/chi(?:@[a-zA-Z0-9_]+bot)?(?:\s+(.*))?$/i', $text, $matches)) {
                if (isset($matches[1]) && !empty($matches[1])) {
                    // Xử lý tham số chi tiêu
                    return $this->chiService->handleExpense($chatId, $matches[1], $userId, $userName);
                } else {
                    // Không có tham số
                    return $this->telegram->replyToMessage($chatId, "Vui lòng nhập theo định dạng: /chi [@người_nhận] [số tiền]");
                }
            }
            
            // Xử lý các tin nhắn khác nếu cần
        }
        
        return response()->json(['status' => 'success']);
    }


}
