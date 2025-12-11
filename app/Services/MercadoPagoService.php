<?php

namespace App\Services;

use App\Exceptions\InvalidDataException;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MercadoPagoService
{
    private string $accessToken;

    public function __construct()
    {
        $this->setAccessToken();
    }

    private function setAccessToken(): void
    {
        $mercadoPagoMode = config('mercado-pago.mode');
        $accessToken = env('ACCESS_TOKEN');
        $accessTokenSandbox = config('mercado-pago.access_token_sandbox');

        $this->accessToken = $mercadoPagoMode == 1 ? $accessToken : $accessTokenSandbox;
    }

    private function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @throws InvalidDataException
     * @throws ConnectionException
     * @throws Exception
     */
    public function generatePixQrCode(array $data): array
    {
        $idempotencyKey = (string)Str::uuid();

        $response = Http::withToken($this->getAccessToken())
            ->withHeaders(['X-Idempotency-Key' => $idempotencyKey])
            ->post('https://api.mercadopago.com/v1/payments', [
                'transaction_amount' => $data['value'],
                'description' => 'Doação ' . config('app.name'),
                'payment_method_id' => 'pix',
                'payer' => [
                    'email' => $data['email'],
                    'first_name' => $data['name'],
                    'last_name' => $data['last_name'],
                    'identification' => [
                        'type' => 'CPF',
                        'number' => $data['tax_id'],
                    ],
                ],
                'notification_url' => config('app.url') . '/webhooks/mercado-pago',
            ]);

        if($response->failed()) {

            $response = $response->json();

            if($response['cause'][0]['code'] === 2067){
                throw new InvalidDataException('O CPF digitado é inválido, verifique e tente novamente.');
            }

            throw new Exception();
        }

        $response = $response->json();

        return [
            'qrCode' => $response['point_of_interaction']['transaction_data']['qr_code_base64'],
            'status' => $response['status'],
            'reference' => $response['id'],
        ];
    }

    public function getTransactionById($id)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)->get('https://api.mercadopago.com/v1/payments/'.$id);

        if($response->failed()){
            Log::error('Failed to get transaction by id: '.collect($response->json()));
        }

        return $response->json();
    }
}
