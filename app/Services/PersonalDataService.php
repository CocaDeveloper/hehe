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

class PersonalDataService
{
    public function update(array $data): string
    {
        $user = Auth::user();
        $user->sex = $data['gender'];
        $user->birthdate = $data['birthdate'];
        $user->save();

        return 'Dados pessoais atualizados com sucesso.';
    }
}