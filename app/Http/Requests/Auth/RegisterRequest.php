<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Rules\PhoneFormat;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string|max:15|regex:/^[a-zA-Z0-9]+$/|unique:login,userid',
            'email' => 'required|string|lowercase||email:rfc,dns,filter|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', new PhoneFormat()]
        ];
    }
}
