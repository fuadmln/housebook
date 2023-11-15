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
            'building_area' => $this->building_area,
            'land_length' => $this->land_length,
            'land_width' => $this->land_width,
            'bedroom' => $this->bedroom,
            'bathroom' => $this->bathroom,
            'floor' => $this->floor,
            'headline' => $this->headline,
            'iframe' => $this->iframe,
            'province' => [
                'id' => $this->province->id,
                'name' => $this->province->name,
            ],
            'city' => [
                'id' => $this->city->id,
                'name' => $this->city->name,
            ],
            'subdistrict' => [
                'id' => $this->subdistrict->id,
                'name' => $this->subdistrict->name,
            ],
            'house_spesification' => $this->houseSpesifications,
        ];
    }
}
