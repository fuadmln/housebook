<?php

namespace App\Http\Requests;

use App\Enums\PropertyType;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
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
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'subdistrict_id' => 'required|exists:subdistricts,id',
            'price' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'sometimes|nullable|string',
            'type' => [
                'required',
                Rule::enum(PropertyType::class),
            ],
            'building_area' => 'required|numeric',
            'land_length' => 'required|numeric',
            'land_width' => 'required|numeric',
            'bedroom' => 'required|integer',
            'bathroom' => 'required|integer',
            'floor' => 'required|integer',
            'headline' => 'required|string',
            'iframe' => 'sometimes|nullable|string',

            'house_specifications' => 'sometimes|array',
            'house_specifications.*.name' => 'required_if:house_specifications,array|required|string',
            'house_specifications.*.value' => 'required_if:house_specifications,array|required|string',

            'residence_specifications' => 'sometimes|array',
            'residence_specifications.*.name' => 'required_if:residence_specifications,array|required|string',
            'residence_specifications.*.value' => 'required_if:residence_specifications,array|required|string',
            
            'house_images' => 'sometimes|array',
            'house_images.*.image' => [
                'required_if:house_images,array',
                'required',
                File::image()
                    ->max(2 * 1024)
            ],
            'house_images.*.sequence' => 'required_if:house_images,array|required|integer|distinct',

            'house_accessibilities' => 'sometimes|array',
            'house_accessibilities.*.place' => 'required_if:house_accessibilities,array|required|string',
            'house_accessibilities.*.duration' => 'required_if:house_accessibilities,array|required|string',
        ];
    }
}
