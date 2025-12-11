<?php

namespace App\Http\Controllers;

use App\Models\DonateHistory;
use App\Models\ItemDelivery;
use App\Models\Store;
use App\Models\User;
use App\Services\MercadoPagoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    private MercadoPagoService $mercadoPagoService;

    public function __construct()
    {
        $this->mercadoPagoService = new MercadoPagoService();
    }

    public function mercadoPago(Request $request): JsonResponse
    {
        try {
            if ($request->type == 'payment') {
                $transactionId = $request['data']['id'];
                $response = $this->mercadoPagoService->getTransactionById($transactionId);

                $paymentHistory = DonateHistory::where('reference', $transactionId)->first();

                if($response['status'] == 'approved' && $paymentHistory->status != 'approved'){
                    $user = User::where('account_id', $paymentHistory->client->account_id)->first();

                    $store = $paymentHistory->store;
                    $pack = $paymentHistory->pack;

                    if($store){
                        ItemDelivery::create([
                            'store_id' => $store->id,
                            'account_id' => $user->account_id,
                            'item_id' => $paymentHistory->item_id,
                            'item_quantity' => $paymentHistory->quantity,
                        ]);
                    } else if($pack){
                        foreach ($pack->items as $item){
                            ItemDelivery::create([
                                'pack_id' => $pack->id,
                                'account_id' => $user->account_id,
                                'item_id' => $item->item_id,
                                'item_quantity' => $item->quantity,
                            ]);
                        }
                    } else {
                        $baseAmount = floatval($response['transaction_amount']) * 1000;

                        $userCash = $baseAmount;

                        if($paymentHistory->partner){
                            $partner = $paymentHistory->partner;

                            $partnerBonus = $baseAmount * 0.20;
                            $partner->cash += $partnerBonus;
                            $partner->save();
                        }

                        $user->cash += $userCash;
                        $user->save();
                    }

                    $paymentHistory->status = $response['status'];
                    $paymentHistory->save();
                }
            }

            return response()->json(['success' => 'success']);
        } catch (\Exception $exception) {
            Log::error('Failed to get mercado pago webhook: ' . $exception);
            return response()->json(['message' => 'failed'], 500);
        }
    }
}
