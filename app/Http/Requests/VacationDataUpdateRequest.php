<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacationDataUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'unused_vacation' => 'numeric|min:0',
            'used_vacation' => 'numeric|min:0',
            'paid_leave' => 'numeric|min:0',
        ];
    }
}
