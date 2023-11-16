<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'start_time', 'end_time', 'is_booked'];
    
    protected $attributes = [
        'is_booked' => false,
    ];

    protected $casts = [
        'is_booked' => 'boolean',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
