<?php

namespace App\Services;

use App\Http\Resources\CharResource;
use App\Models\Char;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CharService
{
    public function getChars($accountId): AnonymousResourceCollection
    {
        $chars =  Char::where('account_id', $accountId)->orderBy('char_num')->get();

        return CharResource::collection($chars);
    }
}