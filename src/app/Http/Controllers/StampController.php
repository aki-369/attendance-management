<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakModel;

class StampController extends Controller
{
    // ビューの表示
    public function index()
    {
        $userId = Auth::id();

        $attendance = Attendance::where('user_id', $userId)
                                ->latest()
                                ->first();

        $break = BreakModel::whereHas('attendance', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->latest()
        ->first();

        return view('index', compact('attendance', 'break'));
    }

    // 勤務開始処理
    public function clockIn() 
    {
        $userId = Auth::id();

        // 最新の勤務記録を取得
        $latestAttendance = Attendance::where('user_id', $userId)
                                  ->latest()
                                  ->first();

        // 勤務終了していない場合はリダイレクト
        if ($latestAttendance && !$latestAttendance->clock_out) {
            return redirect()->route('index')->with('status', '既に勤務中です。');
        }

        // 勤務開始処理
        Attendance::create([
            'user_id' => $userId,
            'clock_in' => now(),
        ]);

        return redirect()->route('index')->with('status', '勤務開始です！');
    }

    // 勤務終了処理
    public function clockOut()
    {
        $userId = Auth::id();

        // 最新の勤務レコードを取得
        $attendance = Attendance::where('user_id', $userId)
                                ->latest()
                                ->first();
        
        // 勤務終了時間を設定
        if($attendance && !$attendance->clock_out) {
            $attendance->update([
                'clock_out' => now(),
            ]);
        }

        return redirect()->route('index')->with('status', 'お疲れ様でした！');
    }

    // 休憩開始処理
    public function breakStart()
    {
        $userId = Auth::id();

        // 最新の勤務開始レコードの取得
        $attendance = Attendance::where('user_id', $userId)
                                ->latest()
                                ->first();

        // 最新の休憩開始レコードの取得
        $latestBreak = BreakModel::whereHas('attendance', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->latest()
        ->first();

        // 勤務開始時間が記録されているか確認し、最新の休憩が終了している場合のみ新しい休憩レコードを作成
        if ($attendance && (!$latestBreak || $latestBreak->break_end)) {
            $attendance->breaks()->create([
                'break_start' => now(),
            ]);
        }

        return redirect()->route('index')->with('status', '休憩開始です！');
    }

    // 休憩終了処理
    public function breakEnd()
    {
        $userId = Auth::id();

        // 最新の休憩レコードを取得
        $break = BreakModel::whereHas('attendance', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->latest()
        ->first();

        // 休憩終了時間を設定
        if($break && !$break->break_end) {
            $break->update([
                'break_end' => now(),
            ]);
        }

        return redirect()->route('index')->with('status', '休憩終了です！');
    }
}
