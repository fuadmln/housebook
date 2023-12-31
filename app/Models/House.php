<?php

namespace App\Models;

use App\Models\City;
use App\Models\User;
use App\Models\HouseImage;
use App\Enums\PropertyType;
use App\Models\Subdistrict;
use App\Models\HouseAccessibility;
use App\Models\HouseSpesification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use App\Models\Utilities\QueryHelper;

class House extends Model
{
    use HasFactory, SoftDeletes; //QueryHelper, 

    protected $attributes = [
        'is_published' => false,
    ];

    protected $fillable = [
        'user_id',
        'province_id',
        'city_id',
        'subdistrict_id',
        'price',
        'address',
        'description',
        'type',
        'building_area',
        'land_length',
        'land_width',
        'bedroom',
        'bathroom',
        'floor',
        'headline',
        'iframe',
        'is_published',
    ];

    protected $hidden = ['deleted_at'];

    protected $appends = [
        'type_name',
    ];

    protected $casts = [
        'type' => PropertyType::class,
        'is_published' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected function typeName(): Attribute
    {
        return new Attribute(
            get: fn () => PropertyType::getString($this->type)
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function subdistrict(): BelongsTo
    {
        return $this->belongsTo(Subdistrict::class);
    }

    public function houseSpesifications(): HasMany
    {
        return $this->hasMany(HouseSpesification::class);
    }

    public function residenceSpesifications(): HasMany
    {
        return $this->hasMany(ResidenceSpesification::class);
    }

    public function houseImages(): HasMany
    {
        return $this->hasMany(HouseImage::class);
    }

    public function houseAccessibilities(): HasMany
    {
        return $this->hasMany(HouseAccessibility::class);
    }
}
