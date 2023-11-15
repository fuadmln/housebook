<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'user_id' => 'required|exists:users,id', //auth
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'subdistrict_id' => 'required|exists:subdistricts,id',
            'price' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'sometimes|nullable|string',
            'type' => 'required|integer|max_digits:1',
            // 'type' => [Rule::enum(PropertyType::class)],
            'building_area' => 'required|numeric',
            'land_length' => 'required|numeric',
            'land_width' => 'required|numeric',
            'bedroom' => 'required|integer',
            'bathroom' => 'required|integer',
            'floor' => 'required|integer',
            'headline' => 'required|string',
            'iframe' => 'sometimes|nullable|',

            /*
            house_image[s]
            house_spec[s]
            residence_spec[s]
            */

        ];
    }
}
