<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResidenceSpesification extends Model
{
    use HasFactory;

    protected $fillable = ['house_id', 'name', 'value'];

    protected $hidden = ['created_at', 'updated_at'];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }
}
