<?php

namespace App\Helpers;

use DateTime;
use LucNham\LunarCalendar\LunarDateTime;

class LunarCalendarHelper
{
    /**
     * Lấy thông tin ngày âm lịch hiện tại
     * 
     * @return array Thông tin về ngày âm lịch hôm nay
     */
    // public static function getLunarToday()
    // {
    //     $calendar = new LunarDateTime();
    //     $today = new DateTime();

    //     $lunar = LunarDateTime::fromGregorian($today->format('Y-m-d H:i:s'));
    //     return $lunar;
    // }


    /**
     * Kiểm tra xem ngày hiện tại có phải là ngày cuối tháng âm lịch hay không
     * 
     * @return bool True nếu là ngày cuối tháng âm lịch
     */
    public static function isEndOfLunarMonth()
    {
        $lunar = LunarDateTime::now();

        // Phương pháp 1: Sử dụng ký tự định dạng 't'
        $currentDay = (int)$lunar->format('j');
        $totalDaysInMonth = (int)$lunar->format('t');

        return $currentDay === $totalDaysInMonth;
    }

    /**
     * Lấy thông tin ngày âm lịch hiện tại
     * 
     * @return array Thông tin về ngày âm lịch hôm nay
     */
    public static function getLunarToday()
    {
        $lunar = LunarDateTime::now();

        return [
            'day' => $lunar->format('j'),
            'month' => $lunar->format('n'),
            'year' => $lunar->format('Y'),
            'is_leap_month' => $lunar->format('k') !== '',
            'formatted' => $lunar->format('d/m/Y'),
            'text' => "Ngày {$lunar->format('j')} tháng {$lunar->format('n')} năm {$lunar->format('Y')} âm lịch",
            'is_end_of_month' => self::isEndOfLunarMonth()
        ];
    }

    /**
     * Kiểm tra xem ngày hiện tại có phải là X ngày trước ngày cuối tháng âm lịch hay không
     * 
     * @param int $days Số ngày trước ngày cuối tháng
     * @return bool True nếu đúng là X ngày trước ngày cuối tháng âm lịch
     */
    public static function isDaysBeforeEndOfLunarMonth($days = 3)
    {
        $lunar = LunarDateTime::now();

        // Lấy ngày hiện tại và tổng số ngày trong tháng
        $currentDay = (int)$lunar->format('j');
        $totalDaysInMonth = (int)$lunar->format('t');

        // Kiểm tra nếu ngày hiện tại đúng là X ngày trước ngày cuối tháng
        return ($totalDaysInMonth - $currentDay) === $days;
    }
}
