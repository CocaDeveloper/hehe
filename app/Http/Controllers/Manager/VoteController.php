<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\AlreadyVoteException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UserNotLoginException;
use App\Http\Controllers\Controller;
use App\Http\Requests\VoteRequest;
use App\Models\VoteSite;
use App\Services\VoteService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class VoteController extends Controller
{
    private VoteService $voteSiteService;

    public function __construct()
    {
        $this->voteSiteService = new VoteService();
    }

    public function store(VoteSite $voteSite, VoteRequest $request): JsonResponse
    {
        try {
            $response = $this->voteSiteService->vote($voteSite, $request->ip(), $request->user()->last_unique_id);

            return response()->json($response);
        } catch(NotFoundException $exception){
            return response()->json(['message' => $exception->getMessage()], 404);
        } catch(UserNotLoginException|AlreadyVoteException $exception){
            return response()->json(['message' => $exception->getMessage()], 400);
        } catch(Exception $exception){
            Log::error('Failed to vote: ' . $exception);
            return response()->json(['message' => 'Não foi pssível votar, por favor, tente novamente mais tarde.'], 500);
        }
    }
}
