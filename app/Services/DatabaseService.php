<?php

namespace App\Services;

use App\Http\Resources\ItemDatabaseResource;
use App\Http\Resources\MonsterDatabaseResource;
use App\Models\ItemDatabase;
use App\Models\MonsterDatabase;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DatabaseService
{
    public function getItems(int $page = 1, string $search = ''): AnonymousResourceCollection
    {
        $items = ItemDatabase::when('search', function ($query) use ($search) {
            $query->where('name_english', 'like', '%' . $search . '%');
                if(is_numeric($search)){
                    $query->orWhere('id', $search);
                }
        })->paginate(10, ['*'], 'page', $page);

        return ItemDatabaseResource::collection($items);
    }

    public function getMonsters(int $page = 1, string|int $search = ''): AnonymousResourceCollection
    {
        $monsters = MonsterDatabase::with([
            'drop1',
            'drop2',
            'drop3',
            'drop4',
            'drop5',
            'drop6',
            'drop7',
            'drop8',
            'drop9',
            'drop10',
        ])->when('search', function ($query) use ($search) {
            $query->where('name_english', 'like', '%' . $search . '%');
                if(is_numeric($search)){
                    $query->orWhere('id', $search);
                }
        })->paginate(10, ['*'], 'page', $page);

        return MonsterDatabaseResource::collection($monsters);
    }
}