<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Services\DatabaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ItemDatabaseController extends Controller
{
    private DatabaseService $databaseService;

    public function __construct()
    {
        $this->databaseService = new DatabaseService();
    }

    public function index(Request $request): Response|JsonResponse
    {
        $page = $request->input('page', 1);
        $search = (string)$request->input('search', '');
        $items = $this->databaseService->getItems($page, $search);

        if ($request->wantsJson()) {
            return response()->json([
                'items' => $items
            ]);
        }

        return Inertia::render('Database/Items', [
            'items' => $items
        ]);
    }
}
