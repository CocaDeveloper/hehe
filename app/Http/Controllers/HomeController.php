<?php

namespace App\Http\Controllers;

use App\Services\CharService;
use App\Services\HomeService;
use App\Services\PackService;
use App\Services\StoreService;
use App\Services\VoteService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    private HomeService $homeService;
    private VoteService $voteSiteService;
    private CharService $charService;
    private StoreService $storeService;
    private PackService $packService;

    public function __construct()
    {
        $this->homeService = new HomeService();
        $this->voteSiteService = new VoteService();
        $this->charService = new CharService();
        $this->storeService = new StoreService();
        $this->packService = new PackService();
    }

    public function index(): Response
    {
        $infos = $this->homeService->getInfos();
        $stores = $this->storeService->getStores();

        return Inertia::render('Home', [
            'infos' => $infos,
            'stores' => $stores,
        ]);
    }

    public function managerAccount(Request $request): Response
    {
        $user = $request->user();
        $tab = $request->query('tab', '');

        $voteSites = $this->voteSiteService->getVoteSites();
        $chars = $this->charService->getChars($user->account_id);
        $packs = $this->packService->getPacks();
        $stores = $this->storeService->getStores();

        return Inertia::render('ManagerAccount/Manager', [
            'voteSites' => $voteSites,
            'chars' => $chars,
            'tab' => $tab,
            'packs' => $packs,
            'stores' => $stores
        ]);
    }

    public function download()
    {
        return Inertia::render('Downloads/Download');
    }
}
