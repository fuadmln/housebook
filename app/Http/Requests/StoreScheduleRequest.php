<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
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
            'date' => 'required_without:schedules|date_format:Y-m-d',
            'start_time' => 'required_without:schedules|date_format:H:i:s',
            'end_time' => 'required_without:schedules|date_format:H:i:s',

            'schedules' => 'required_without:date,start_time,end_time|array',
            'schedules.*.date' => 'required_if:schedules,array|date_format:Y-m-d',
            'schedules.*.start_time' => 'required_if:schedules,array|date_format:H:i:s',
            'schedules.*.end_time' => 'required_if:schedules,array|date_format:H:i:s',

        ];
    }
}
