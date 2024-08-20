<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $clock_in = $this->faker->dateTimeThisMonth();
        $clock_out = (clone $clock_in)->modify('+8 hours');

        return [
            'user_id' => User::factory(),
            'clock_in' => $clock_in,
            'clock_out' => $clock_out, 
        ];
    }
}
