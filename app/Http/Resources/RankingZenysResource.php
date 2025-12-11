<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RankingZenysResource extends JsonResource
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
            'guild' => new GuildResource($this->guild),
            'class_id' => $this->class,
            'class_name' => $this->getClass(),
            'status' => $this->online,
            'zenys' => $this->zeny
        ];
    }
}
