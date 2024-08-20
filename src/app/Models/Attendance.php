<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clock_in',
        'clock_out',
    ];

    protected $casts = [
        'clock_in' => 'datetime',
        'clock_out' => 'datetime', 
    ];    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function breaks() : Hasmany
    {
        return $this->hasMany(BreakModel::class);
    }

    public function getWorkDurationAttribute()
    {
        $start = Carbon::parse($this->clock_in);
        $end = Carbon::parse($this->clock_out);

        $diffInSeconds = $end->diffInSeconds($start);

        // hh:mm:ss形式に変換
        $duration = Carbon::parse($diffInSeconds)->format('H:i:s');

        return $duration;
    }
}
