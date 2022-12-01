<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowableArea extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "polygons"
    ];

    protected $casts = [
        "polgyons" => "array"
    ];
}
