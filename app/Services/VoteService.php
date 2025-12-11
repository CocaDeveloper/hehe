<?php

namespace App\Services;

use App\Exceptions\AlreadyVoteException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UserNotLoginException;
use App\Http\Resources\VoteSiteResource;
use App\Models\Vote;
use App\Models\VoteSite;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class VoteService
{
    public function getVoteSites(): AnonymousResourceCollection
    {
        $voteSites = VoteSite::get();

        return VoteSiteResource::collection($voteSites);
    }

    public function vote(VoteSite $voteSite, string $ip, string $macAddress): array
    {
        $vote = new Vote();
        $vote->account_id = Auth::id();
        $vote->vote_site_id = $voteSite->id;
        $vote->ip = $ip;
        $vote->mac_id = $macAddress;
        $vote->save();

        $user = Auth::user();
        $user->vote+= 3;
        $user->save();

        return [
            'url' => $voteSite->url,
        ];
    }
}