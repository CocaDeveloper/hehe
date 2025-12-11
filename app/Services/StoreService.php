<?php

namespace App\Services;

use App\Http\Resources\RankingCharsResource;
use App\Http\Resources\RankingGuildResource;
use App\Http\Resources\RankingZenysResource;
use App\Http\Resources\StoreResource;
use App\Models\Char;
use App\Models\Guild;
use App\Models\Store;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoreService
{
    public function getStores(): array
    {
        $stores = Store::with('item')->get();

        return StoreResource::collection($stores)->resolve();
    }
}