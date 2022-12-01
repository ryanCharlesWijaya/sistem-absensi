<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "lat",
        "long",
        "status",
        "catatan"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function scopeToday(Builder $query) : Builder
    {
        $today_date = Carbon::now()->format("Y-m-d");

        return $query->where("created_at", ">", $today_date." 00:00:00")
            ->where("created_at", "<", $today_date." 23:59:59");
    }
}
