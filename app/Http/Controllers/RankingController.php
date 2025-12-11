<?php

namespace App\Http\Controllers;

use App\Services\RankingService;
use Inertia\Inertia;
use Inertia\Response;

class RankingController extends Controller
{
    private RankingService $rankingService;

    public function __construct()
    {
        $this->rankingService = new RankingService();
    }

    public function index(): Response
    {
        $zenys = $this->rankingService->getRankingZenys();
        $chars = $this->rankingService->getRankingChars();
        $guilds = $this->rankingService->getRankingGuilds();

        return Inertia::render('Rankings/Rankings', [
            'zenys' => $zenys,
            'chars' => $chars,
            'guilds' => $guilds
        ]);
    }
}
