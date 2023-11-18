<?php

namespace App\Models;

use App\Models\User;
use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'house_id',
        'schedule_id',
        'status'
    ];

    protected $attributes = [
        'status' => BookingStatus::PENDING,
    ];

    protected $casts = [
        'status' => BookingStatus::class,
    ];

    protected $appends = [
        'status_name',
    ];

    protected $hidden = ['updated_at'];

    protected function statusName(): Attribute
    {
        return new Attribute(
            get: fn () => BookingStatus::getString($this->status)
        );
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function house(): BelongsTo
    {
        return $this->BelongsTo(House::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->BelongsTo(Schedule::class);
    }
}
