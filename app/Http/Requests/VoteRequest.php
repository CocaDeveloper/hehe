<?php

namespace App\Http\Requests;

use App\Exceptions\AlreadyVoteException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UserNotLoginException;
use App\Models\Vote;
use App\Models\VoteSite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class VoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @throws AlreadyVoteException
     * @throws UserNotLoginException
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $voteSite = $this->voteSite;

        //$this->checkIfUserLoggedIn($user);
        $this->checkIfUserHasAlreadyVoted($user, $voteSite);

        return true;
    }

    /**
     * Check if the user has logged in at least once.
     * @param  $user
     * @throws UserNotLoginException
     */
    protected function checkIfUserLoggedIn($user): void
    {
        if (!$user->lastlogin) {
            throw new UserNotLoginException('Você precisa ter feito login pelo menos uma vez no jogo para votar com essa conta.');
        }
    }

    /**
     * Check if the user has already voted.
     * @param  $user
     * @param  $voteSite
     * @throws AlreadyVoteException
     */
    protected function checkIfUserHasAlreadyVoted($user, $voteSite): void
    {
        $vote = $this->getVote($user, $voteSite);

        if ($vote) {
            $this->throwAlreadyVotedException($vote, $voteSite);
        }
    }

    /**
     * Get the vote record for the user.
     * @param  $user
     * @param  $voteSite
     * @return mixed
     */
    protected function getVote($user, $voteSite): mixed
    {
        return Vote::where('created_at', '>', Carbon::now()->subHours($voteSite->time))
            ->where('vote_site_id', $voteSite->id)
            ->where(function ($query) use ($user) {
                $query->where('ip', $this->ip())
                    //->orWhere('mac_id', $user->last_unique_id)
                    ->orWhere('account_id', $user->account_id);
            })
            ->first();
    }

    /**
     * Throw an exception if the user has already voted.
     * @param  $vote
     * @param  $voteSite
     * @throws AlreadyVoteException
     */
    protected function throwAlreadyVotedException($vote, $voteSite): void
    {
        $nextVoteTime = Carbon::parse($vote->created_at)
            ->timezone('America/Sao_Paulo')
            ->addHours($voteSite->time);

        throw new AlreadyVoteException(
            'Você já votou, aguarde até ' .
            $nextVoteTime->format('d/m/Y') .
            ' às ' .
            $nextVoteTime->format('H:i:s') .
            ' para votar novamente.'
        );
    }
}