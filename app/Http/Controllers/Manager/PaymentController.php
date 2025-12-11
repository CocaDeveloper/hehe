<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\InvalidDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\PaymentStoreRequest;
use App\Services\PaymentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private PaymentService $paymentService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
    }

    public function store(PaymentStoreRequest $request): JsonResponse
    {
        try {

            DB::beginTransaction();

            $data = $request->validated();
            $user = $request->user();

            $this->paymentService->setUser($user);

            $response = $this->paymentService->generateQrCode($data);

            DB::commit();

            return response()->json($response);

        } catch (InvalidDataException $ide) {

            DB::rollBack();

            return response()->json([
                'errors' => [
                    'tax_id' => [$ide->getMessage()],
                ]
            ], 422);
        } catch (Exception $exception) {

            Log::error('Failed to create payment: ' . $exception);

            DB::rollBack();

            return response()->json(['message' => 'Não foi possível processar o pagamento, por favor, tente novamente mais tarde.'], 500);
        }
    }

    public function verify(Request $request, $referenceId): JsonResponse
    {
        $user = $request->user();

        $this->paymentService->setUser($user);

        $payment = $this->paymentService->getPaymentByReference($referenceId);

        return response()->json(['status' => $payment->status]);
    }
}
