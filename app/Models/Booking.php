<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    public static $STATUS = [
        'PENDING',
        'ACCEPTED',
        'REJECTED',
        'DONE',
    ];

    protected $fillable = ['user_id', 'house_id', 'schedule_id', 'status'];

    protected $attributes = [
        'status' => 'PENDING',
    ];

    protected $hidden = ['updated_at'];

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
