<?php

namespace App\Services;

use App\Models\Char;
use App\Models\User;

class HomeService
{
    public function getInfos(): array
    {
        $totalOnline = 50 + Char::where('online', 1)->count();
        $totalAccounts = 300 + User::count();

        return [
            'total_online' => $totalOnline,
            'total_accounts' => $totalAccounts,
        ];
    }
}