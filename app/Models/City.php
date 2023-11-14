<?php

namespace App\Models;

use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['province_id', 'name', 'postal_code'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
