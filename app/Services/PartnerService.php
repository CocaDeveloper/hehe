<?php

namespace App\Services;

use App\Exceptions\AlreadyVoteException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UserNotLoginException;
use App\Http\Resources\VoteSiteResource;
use App\Models\PayoutBalance;
use App\Models\Vote;
use App\Models\VoteSite;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PartnerService
{
    public function saveTag(string $tag): string
    {
        $user = Auth::user();
        $user->tag = $tag;
        $user->save();

        return 'Tag salva com sucesso.';
    }

    public function formatCurrencyToValue($value): float
    {
        $value = str_replace(['R$', ' ', '.'], '', $value);

        $value = str_replace(',', '.', $value);

        return floatval($value);
    }

    public function hasWithdrawnThisWeek(string $accountId): bool
    {
        $startWeek = Carbon::now()->setTimezone('America/Sao_Paulo')->startOfWeek();
        $endWeek = Carbon::now()->setTimezone('America/Sao_Paulo')->endOfWeek();

        return PayoutBalance::where('account_id', $accountId)
        ->whereBetween('created_at', [$startWeek, $endWeek])
        ->where('status', '!=', 'failed')
        ->exists();
    }

    public function requestWithdraw(array $data, $user): PayoutBalance
    {
        $value = $this->formatCurrencyToValue($data['value']) * 15;

        $user->payout_balance-= $value;
        $user->save();

        return PayoutBalance::create([
            'account_id' => $user->account_id,
            'value' => $value,
            'pix_key' => $data['type_key'],
            'status' => PayoutBalance::STATUS_CREATED
        ]);
    }
}