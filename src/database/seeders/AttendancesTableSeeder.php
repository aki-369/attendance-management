<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\BreakModel;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 50のAttendanceレコードを生成し、各Attendanceに関連するBreakModelレコードを生成する
        Attendance::factory()->count(50)->create()->each(function ($attendance) {
            // 各Attendanceにランダムな数のBreakを関連付ける
            BreakModel::factory()->count(rand(1, 3))->make()->each(function ($break) use ($attendance) {
                $break->attendance_id = $attendance->id;
                $break->save();
            });
        });
    }
}
