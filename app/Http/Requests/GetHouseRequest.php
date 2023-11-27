<?php

namespace App\Http\Requests;

use App\Enums\PropertyType;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GetHouseRequest extends FormRequest
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
            'user_id' => 'sometimes|required|integer',
            'has_iframe' => 'sometimes|required|boolean',
            'is_published' => 'sometimes|required|boolean',
            'type' => [
                'sometimes',
                'required',
                'integer',
                Rule::enum(PropertyType::class),
            ],
        ];
    }
}
