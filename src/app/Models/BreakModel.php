<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class BreakModel extends Model
{
    use HasFactory;

    protected $table = 'break_models';

    protected $fillable = [
        'attendance_id',
        'break_start',
        'break_end',
    ];

    public function attendance() : BelongsTo
    {
        return $this->belongsTo(Attendance::class);    
    }

    public function getTotalBreakDurationAttribute()
    {
        $breaks = self::where('attendance_id', $this->attendance_id)
                        ->whereDate('break_start', Carbon::parse($this->break_start)->toDateString())
                        ->get();

        $totalSeconds = 0;

        foreach ($breaks as $break) {
            $start = Carbon::parse($break->break_start);
            $end = Carbon::parse($break->break_end);

            $totalSeconds += $end->diffInSeconds($start);
        }

        // 秒数を時間、分、秒に変換
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        // hh:mm:ss形式に変換
        $totalDuration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        return $totalDuration;
    }
}
