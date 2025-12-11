<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonalDataUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'gender' => ['required', Rule::in(['M', 'F'])],
            'birthdate' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}
