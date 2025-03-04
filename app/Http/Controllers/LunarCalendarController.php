<?php

namespace App\Http\Controllers;

use App\Helpers\LunarCalendarHelper;
use Illuminate\Http\Request;

class LunarCalendarController extends Controller
{
    public function checkMocTon()
    {
        $lunarCalendar = LunarCalendarHelper::isDaysBeforeEndOfLunarMonth();
        return response()->json($lunarCalendar);
    }
}
