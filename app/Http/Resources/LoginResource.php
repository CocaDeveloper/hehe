<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'login' => $this->userid,
            'email' => $this->email,
            'sex' => $this->sex,
            'birthdate' => $this->birthdate,
            'email_verified_at' => $this->email_verified_at,
            'votes' => $this->vote ?? 0,
            'has_partner' => $this->has_partner,
            'tag' => $this->tag,
            'payout_balance' => $this->payout_balance
        ];
    }
}
