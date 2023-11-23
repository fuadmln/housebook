<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'address' => $this->address,
            'description' => $this->description,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'building_area' => $this->building_area,
            'land_length' => $this->land_length,
            'land_width' => $this->land_width,
            'bedroom' => $this->bedroom,
            'bathroom' => $this->bathroom,
            'floor' => $this->floor,
            'headline' => $this->headline,
            'iframe' => $this->iframe,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'subdistrict_id' => $this->subdistrict_id,
            'house_spesifications' => $this->houseSpesifications,
            'residence_spesifications' => $this->residenceSpesifications,
            'house_accessibilities' => $this->houseAccessibilities,
            'house_images' => $this->houseImages,
        ];
    }
}
