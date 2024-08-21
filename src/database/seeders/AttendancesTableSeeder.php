<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\BreakModel;
use Carbon\Carbon;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startDate = Carbon::parse('2024-08-01')->setTime(9, 0); // 勤務開始時間を9:00に設定; 

        Attendance::factory()->count(50)->create()->each(function ($attendance) use ($startDate) {
            // 開始日を更新
            $attendance->clock_in = $startDate->copy()->addDays($attendance->id - 1);
            $attendance->clock_out = $attendance->clock_in->copy()->addHours(8); 
            $attendance->save();

            // 休憩時間
            BreakModel::factory()->count(rand(1, 3))->make()->each(function ($break) use ($attendance) {
            // 勤務開始から4時間後に休憩を開始
            $breakStartTime = $attendance->clock_in->copy()->addHours(4);

            // 休憩開始時間と終了時間を設定
            $break->break_start = $breakStartTime;
            $break->break_end = $break->break_start->copy()->addMinutes(30); 
            $break->attendance_id = $attendance->id;
            $break->save();
            });
        });
    }
}
