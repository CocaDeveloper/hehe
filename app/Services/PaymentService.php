<?php

namespace App\Services;

use App\Exceptions\InvalidDataException;
use App\Models\DonateClient;
use App\Models\DonateHistory;
use App\Models\Pack;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    private User $user;
    private MercadoPagoService $gateway;

    public function __construct()
    {
        $this->gateway = new MercadoPagoService();
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    private function getUser(): User
    {
        return $this->user;
    }

    /**
     * @throws InvalidDataException
     * @throws ConnectionException
     */
    public function generateQrCode(array $data): array
    {
        $fullName = explode(' ', $data['name'], 2);
        $firstName = $fullName[0];
        $lastName = $fullName[1] ?? '';

        $data['name'] = $firstName;
        $data['last_name'] = $lastName;
        $data['value'] = $this->formatCurrencyToValue($data['value']) * 10;

        if($data['tag']){
            $partner = $this->findPartner($data['tag']);

            if($partner){
                $data['partner_id'] = $partner->account_id;
            }
        }

        $client = $this->createClient($data);

        $response = $this->gateway->generatePixQrCode($data);

        if($data['store_id']){
            $store = Store::find($data['store_id']);
            $data['value'] = $store->value;
        } else if($data['pack_id']){
            $pack = Pack::find($data['pack_id']);
            $data['value'] = $pack->price;
        }

        $paymentHistoryData = [
            'client_id' => $client->id,
            'reference' => $response['reference'],
            'status' => $response['status'],
            'value' => $data['value'],
            'payment_method' => DonateHistory::PAYMENT_METHOD_PIX,
            'partner_id' => $data['partner_id'] ?? null,
            'store_id' => $data['store_id'] ?? null,
            'pack_id' => $data['pack_id'] ?? null,
        ];

        $this->createPaymentHistory($paymentHistoryData);

        return $response;
    }

    public function getPaymentByReference(string $referenceId)
    {
        return DonateHistory::whereHas('client', function ($query) {
            $query->where('account_id', $this->getUser()->account_id);
        })->where('reference', $referenceId)->first();
    }

    private function createClient(array $data)
    {
        return DonateClient::updateOrCreate(
            [
                'account_id' => $this->getUser()->account_id
            ],
            [
                'cpf' => $data['tax_id'],
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
            ]
        );
    }

    private function createPaymentHistory(array $data)
    {
        return DonateHistory::create($data);
    }

    private function formatCurrencyToValue($value): float
    {
        $value = str_replace(['R$', ' ', '.'], '', $value);

        $value = str_replace(',', '.', $value);

        return floatval($value);
    }

    private function findPartner(string $tag)
    {
        return User::where('tag', $tag)->first();
    }
}