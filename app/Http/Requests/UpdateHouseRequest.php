<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseRequest extends FormRequest
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
            'province_id' => 'sometimes|required|exists:provinces,id',
            'city_id' => 'sometimes|required|exists:cities,id',
            'subdistrict_id' => 'sometimes|required|exists:subdistricts,id',
            'price' => 'sometimes|required|numeric',
            'address' => 'sometimes|required|string',
            'description' => 'sometimes|sometimes|nullable|string',
            'type' => [
                'sometimes',
                'required',
                Rule::enum(PropertyType::class),
            ],
            'building_area' => 'sometimes|required|numeric',
            'land_length' => 'sometimes|required|numeric',
            'land_width' => 'sometimes|required|numeric',
            'bedroom' => 'sometimes|required|integer',
            'bathroom' => 'sometimes|required|integer',
            'floor' => 'sometimes|required|integer',
            'headline' => 'sometimes|required|string',
            'iframe' => 'sometimes|nullable|string', // admin only
            'is_published' => 'sometimes|required|boolean', // admin only

            'house_specifications' => 'sometimes|array',
            'house_specifications.*.action' => [
                'sometimes',
                'required_if:house_specifications, array',
                'required',
                Rule::in(['update', 'delete']),
            ],
            'house_specifications.*.id' => 'sometimes|required_if:house_specifications, array|required|numeric',
            'house_specifications.*.name' => 'sometimes|required_if:house_specifications, array|required|string',
            'house_specifications.*.value' => 'sometimes|required_if:house_specifications, array|string',

            'residence_specifications' => 'sometimes|array',
            'residence_specifications.*.action' => [
                'sometimes',
                'required_if:residence_specifications, array',
                'required',
                Rule::in(['update', 'delete']),
            ],
            'residence_specifications.*.id' => 'sometimes|required_if:residence_specifications, array|required|numeric',
            'residence_specifications.*.name' => 'sometimes|required_if:residence_specifications, array|required|string',
            'residence_specifications.*.value' => 'sometimes|required_if:residence_specifications, array|string',

        ];
    }
}
