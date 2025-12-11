<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RankingGuildResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'emblem' => $this->getEmblem(),
            'level' => $this->guild_lv,
            'exp' => $this->exp,
            'total_members' => $this->members_count,
        ];
    }
}
