<?php

namespace App\Http\Requests;

use App\Rules\CpfFormat;
use App\Rules\PhoneFormat;
use App\Services\PartnerService;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): true
    {
        $partnerService = new PartnerService();

        $value = $this->input('value');
        $valueFormated = $partnerService->formatCurrencyToValue($value) * 10;
        $partnerPayoutValance = floatval($this->user()->payout_balance);

        if($valueFormated > $partnerPayoutValance){
            abort(403, 'Você não possui esse valor para solicitar.');
        }

        if($partnerService->hasWithdrawnThisWeek($this->user()->account_id)){
            abort(403, 'Você já fez uma solicitação de resgate de saldo nessa semana.');
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'key' => ['required', $this->getKeyValidationRule()],
            'type_key' => ['required', 'in:cpf,email,phone'],
            'value' => ['required'],
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
            'key.required' => 'É necessário informar a chave pix.',
            'type_key.required' => 'É necessário informar o tipo de chave pix.',
            'type_key.in' => 'O tipo de chave pix pode ser apenas cpf, telefone ou e-mail.',
            'value.required' => 'É necessário informar o valor.'
        ];
    }

    protected function getKeyValidationRule(): CpfFormat|PhoneFormat|string
    {
        if ($this->input('type_key') === 'cpf') {
            return new CpfFormat();
        }

        if ($this->input( 'type_key') === 'phone') {
            return new PhoneFormat();
        }

        return 'string';
    }
}
