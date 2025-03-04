<?php

namespace App\Console\Commands;

use App\Helpers\LunarCalendarHelper;
use App\Helpers\TelegramHelper;
use Illuminate\Console\Command;

class CheckMocTon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-moc-ton';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check ngày cuối tháng âm lịch';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $lunarCalendar = LunarCalendarHelper::isDaysBeforeEndOfLunarMonth();
        $chatId = env('TELEGRAM_CHAT_ID');
        if ($lunarCalendar) {
            info('Đến ngày đi ăn mộc tồn rồi');
            $telegram = new TelegramHelper();
            // $message = "📢 Còn 3 ngày là cuối tháng rồi, \n các khầy làm tí mộc tồn nhỉ 📅🙌";
            // $telegram->replyToMessage($chatId, $message);
            $telegram->sendPoll(
                $chatId,
                "📢 Còn 3 ngày là cuối tháng rồi,
                \n các khầy làm tí mộc tồn nhỉ 📅 🙌",
                ["Đi ăn mộc tồn", "Không đi", "Thế nào cũng được"],
                [
                    'is_anonymous' => false,
                    'allows_multiple_answers' => false,
                    'open_period' => 86400,
                ]
            );
        } else {
            info('Không phải ngày cuối tháng âm lịch');
        }
    }
}
