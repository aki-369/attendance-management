<?php

namespace Database\Factories;

use App\Models\BreakModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BreakModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
            $break_start = $this->faker->dateTimeThisMonth();
            $break_end = (clone $break_start)->modify('+1 hour');

        return [
            'attendance_id' => null, // 後で設定するためにプレースホルダーにする
            'break_start' => $break_start,
            'break_end' => $break_end,
        ];
    }
}
