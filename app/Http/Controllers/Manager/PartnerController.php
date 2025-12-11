<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveTagRequest;
use App\Http\Requests\WithdrawStoreRequest;
use App\Services\PartnerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    private PartnerService $partnerService;

    public function __construct()
    {
        $this->partnerService = new PartnerService();
    }

    public function saveTag(SavetagRequest $request): JsonResponse
    {
        $tag = $request->input('tag');

        $response = $this->partnerService->saveTag($tag);

        return response()->json(['message' => $response]);
    }

    public function withdrawStore(WithdrawStoreRequest $request): JsonResponse
    {
        $user = $request->user();

        $response = $this->partnerService->requestWithdraw($request->all(), $user);

        return response()->json([
            'data' => $response,
            'message' => 'Solicitação de resgate realizada com sucesso!'
        ]);
    }


}
