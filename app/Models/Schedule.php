<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
