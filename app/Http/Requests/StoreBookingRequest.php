<?php

namespace App\Http\Requests;

use App\Enums\BookingStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'house_id' => 'required|exists:houses,id',
            'schedule_id' => 'required|exists:schedules,id', //tambah pengecekan apakah pernah ada house di schedule ini
            'status' => [
                'sometimes',
                Rule::enum(BookingStatus::class),
            ],
        ];
    }
}
