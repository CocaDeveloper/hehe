<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\PersonalDataUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\PersonalDataService;
use Illuminate\Http\JsonResponse;

class PersonalDataController extends Controller
{
    private PersonalDataService $personalDataService;

    public function __construct()
    {
        $this->personalDataService = new PersonalDataService();
    }

    public function update(PersonalDataUpdateRequest $request)
    {
       $response = $this->personalDataService->update($request->validated());

       return redirect()->back()->with('message', $response);
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $request->user()->update([
            'user_pass' => $request['password'],
        ]);

        return response()->json(['message' => 'Senha alterada com sucesso.']);
    }
}
