<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemDatabaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name_english,
            'type' => $this->getType(),
            'subtype' => $this->getSubtypes(),
            'price_buy' => $this->price_buy,
            'price_sell' => $this->price_sell,
            'weight' => $this->weight,
            'attack' => $this->attack,
            'defense' => $this->defense,
            'range' => $this->range,
            'slots' => $this->slots,
            'refinable' => $this->refineable,
            'jobs' => $this->getJobs(),
            'locations' => $this->getLocations(),
            'trade_restrictions' => $this->getTradeRestrictions(),
            'weapon_level' => $this->weapon_level,
            'armor_level' => $this->armor_level,
            'equip_level' => $this->equip_level_min,
        ];
    }
}
