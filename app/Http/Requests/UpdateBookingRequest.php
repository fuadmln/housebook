<?php

namespace App\Http\Requests;

use App\Models\Booking;
use App\Enums\BookingStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
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
            'schedule_id' => 'sometimes|required|exists:schedules,id',
            'status' => [
                'sometimes',
                Rule::enum(BookingStatus::class),
                Rule::excludeIf(!$this->user()->is_admin),
            ],
        ];
    }
}
