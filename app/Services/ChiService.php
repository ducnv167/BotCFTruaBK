<?php

namespace App\Services;

use App\Helpers\TelegramHelper;

class ChiService
{
    protected $telegram;
    public function __construct()
    {
        $this->telegram = new TelegramHelper();
        
    }
    public function handleExpense($chatId, $expenseText, $userId, $userName)
    {
        // Phân tích chuỗi chi tiêu với tag người nhận
        // Kiểm tra mẫu: /chi @username 20k [mô tả]
        if (preg_match('/^@([a-zA-Z0-9_]+)\s+(\d+\.?\d*)([km]?)(?:\s+(.*))?$/i', trim($expenseText), $matches)) {
            $recipient = $matches[1]; // Người nhận tiền
            $amount = $matches[2];    // Số tiền
            $unit = strtolower($matches[3] ?? '');  // Đơn vị (k, m)
            $description = $matches[4] ?? '';       // Mô tả nếu có

            // Chuyển đổi số tiền theo đơn vị
            switch ($unit) {
                case 'k':
                    $amount *= 1000;
                    break;
                case 'm':
                    $amount *= 1000000;
                    break;
            }

            // Làm tròn số
            $amount = round($amount);

            // Lưu chi tiêu vào database (giả định)
            $this->saveExpenseWithRecipient($userId, $recipient, $amount, $description);

            // Chuẩn bị phản hồi
            $response = "{$userName} đã chi {$this->formatMoney($amount)} cho @{$recipient}";
            if (!empty($description)) {
                $response .= " ({$description})";
            }

            return $this->telegram->replyToMessage($chatId, $response);
        }
        // Kiểm tra mẫu không có tag: /chi 20k [mô tả]
        else if (preg_match('/^(\d+\.?\d*)([km]?)(?:\s+(.*))?$/i', trim($expenseText), $matches)) {
            $amount = $matches[1];
            $unit = strtolower($matches[2] ?? '');
            $description = $matches[3] ?? '';

            // Chuyển đổi số tiền theo đơn vị
            switch ($unit) {
                case 'k':
                    $amount *= 1000;
                    break;
                case 'm':
                    $amount *= 1000000;
                    break;
            }

            // Làm tròn số
            $amount = round($amount);

            // Lưu chi tiêu vào database (giả định)
            // $this->saveExpense($userId, $amount, $description);

            // Chuẩn bị phản hồi
            $response = "{$userName} đã chi {$this->formatMoney($amount)}";
            if (!empty($description)) {
                $response .= " cho {$description}";
            }

            return $this->telegram->replyToMessage($chatId, $response);
        } else {
            return $this->telegram->replyToMessage($chatId, "Định dạng không đúng. Vui lòng nhập theo định dạng: /chi [@người_nhận] [số tiền] [mô tả]");
        }
    }


    protected function formatMoney($amount)
    {
        return number_format($amount, 0, ',', '.') . ' đồng';
    }

    // Phương thức để lưu chi tiêu có người nhận vào database
    protected function saveExpenseWithRecipient($userId, $recipient, $amount, $description)
    {
        info("Thông tin lấy được : " . json_encode([
            'user_id' => $userId,
            'amount' => $amount,
            'recipient' => $recipient,
            'description' => $description,
            'created_at' => now()
        ]));

        // Code để lưu vào database
        // Ví dụ:
        // Expense::create([
        //     'user_id' => $userId,
        //     'recipient' => $recipient,
        //     'amount' => $amount,
        //     'description' => $description,
        //     'created_at' => now()
        // ]);
    }
}
