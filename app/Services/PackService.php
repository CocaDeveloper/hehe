<?php

namespace App\Services;

use App\Http\Resources\PackResource;
use App\Models\Pack;

class PackService
{
    public function getPacks(): array
    {
        $packs = Pack::with(['items', 'items.item'])->get();

        return PackResource::collection($packs)->resolve();
    }
}