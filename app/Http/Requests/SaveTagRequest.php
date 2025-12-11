<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveTagRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $accountId = auth()->user()->account_id;

        return [
            'tag' => 'required|unique:login,tag,' . $accountId . ',account_id'
        ];
    }


    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'tag.required' => 'A tag é obrigatoria.',
            'tag.unique' => 'Essa tag já está sendo utilizada por outro parceiro.',
        ];
    }
}
