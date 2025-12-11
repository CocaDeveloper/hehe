<?php

namespace App\Services;

use App\Http\Resources\RankingCharsResource;
use App\Http\Resources\RankingGuildResource;
use App\Http\Resources\RankingZenysResource;
use App\Models\Char;
use App\Models\Guild;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RankingService
{
    public function getRankingZenys(): AnonymousResourceCollection
    {
        $zenys = Char::orderByDesc('zeny')->take(20)->get();

        return RankingZenysResource::collection($zenys);
    }

    public function getRankingChars(): AnonymousResourceCollection
    {
        $chars = Char::orderByDesc('base_level')
            ->orderByDesc('job_level')
            ->orderByDesc('base_exp')
            ->take(20)
            ->get();

        return RankingCharsResource::collection($chars);
    }

    public function getRankingGuilds(): AnonymousResourceCollection
    {
        $chars = Guild::with('members')
            ->withCount('members')
            ->orderByDesc('guild_lv')
            ->orderByDesc('exp')
            ->orderByDesc('members_count')
            ->take(20)
            ->get();

        return RankingGuildResource::collection($chars);
    }
}