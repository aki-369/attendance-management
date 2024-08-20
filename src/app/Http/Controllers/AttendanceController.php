<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakModel;

class AttendanceController extends Controller
{
    public function showAttendanceView(Request $request)
    {
        // データが存在する日付のリストを取得し、ソートする
        $datesWithData = Attendance::selectRaw('DATE(clock_in) as date')
            ->distinct()
            ->pluck('date')
            ->sort()
            ->values();

        // デフォルトの日付を最初の要素に設定
        $defaultDate = $datesWithData->first();

        // リクエストパラメータから日付を取得、またはデフォルト日付を使用
        $date = $request->input('date', $defaultDate);

        // 指定された日付の出席データを取得してページネーション
        $attendances = Attendance::with('user', 'breaks')
            ->whereDate('clock_in', $date)
            ->paginate(5);
        
        return view('attendance', compact('attendances', 'date', 'datesWithData'));
    }
}
