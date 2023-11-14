<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subdistrict extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'name'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
