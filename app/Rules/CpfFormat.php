<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = preg_replace('/\D/', '', $value);

        if (strlen($value) !== 11) {
            $fail('O CPF deve ter 11 dígitos.');
            return;
        }

        if (preg_match('/(\d)\1{10}/', $value)) {
            $fail('O CPF não pode ser uma sequência de números repetidos.');
            return;
        }

        if (!$this->isValidCpf($value)) {
            $fail('O CPF informado é inválido.');
            return;
        }
    }

    private function isValidCpf(string $cpf): bool
    {
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int) $cpf[$i] * (10 - $i);
        }
        $digit1 = $sum % 11;
        if ($digit1 < 2) {
            $digit1 = 0;
        } else {
            $digit1 = 11 - $digit1;
        }

        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += (int) $cpf[$i] * (11 - $i);
        }
        $digit2 = $sum % 11;
        if ($digit2 < 2) {
            $digit2 = 0;
        } else {
            $digit2 = 11 - $digit2;
        }

        return ($cpf[9] == $digit1) && ($cpf[10] == $digit2);
    }

    public function message(): string
    {
        return 'O CPF informado precisa ser válido.';
    }
}
