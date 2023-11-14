<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'province' => [
                'id' => $this->province->id,
                'name' => $this->province->name,
            ],
            'name' => $this->name,
            'postal_code' => $this->postal_code,
        ];
    }
}
