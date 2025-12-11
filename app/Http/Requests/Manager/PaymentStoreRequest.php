<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'store_id' => ['nullable', 'exists:stores,id'],
            'pack_id' => ['nullable', 'exists:packs,id'],
            'value' => ['required_without_all:store_id,pack_id'],
            'payment_method' => ['required', 'in:pix'],
            'name' => ['required'],
            'email' => ['required', 'email'],
            'tax_id' => ['required'],
            'tag' => ['nullable', 'string'],
        ];
    }
}
