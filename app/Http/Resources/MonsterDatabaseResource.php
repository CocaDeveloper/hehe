<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MonsterDatabaseResource extends JsonResource
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
            'level' => $this->level,
            'hp' => $this->hp,
            'sp' => $this->sp,
            'base_exp' => $this->base_exp,
            'job_exp' => $this->job_exp,
            'mvp_exp' => $this->mvp_exp,
            'attack' => $this->attack . '~' . $this->attack2,
            'defense' => $this->defense,
            'magic_defense' => $this->magic_defense,
            'str' => $this->str,
            'agi' => $this->agi,
            'vit' => $this->vit,
            'int' => $this->int,
            'dex' => $this->dex,
            'luk' => $this->luk,
            'attack_range' => $this->attack_range,
            'size' => $this->getSize(),
            'race' => $this->getRace(),
            'element' => $this->getElement(),
            'element_level' => $this->element_level,
            'attack_delay' => $this->attack_delay,
            'modes' => $this->getModes(),
            'drop1_item' => new ItemDatabaseSimpleResource($this->drop1),
            'drop1_rate' => $this->drop1_rate,
            'drop2_item' => new ItemDatabaseSimpleResource($this->drop2),
            'drop2_rate' => $this->drop2_rate,
            'drop3_item' => new ItemDatabaseSimpleResource($this->drop3),
            'drop3_rate' => $this->drop3_rate,
            'drop4_item' => new ItemDatabaseSimpleResource($this->drop4),
            'drop4_rate' => $this->drop4_rate,
            'drop5_item' => new ItemDatabaseSimpleResource($this->drop5),
            'drop5_rate' => $this->drop5_rate,
            'drop6_item' => new ItemDatabaseSimpleResource($this->drop6),
            'drop6_rate' => $this->drop6_rate,
            'drop7_item' => new ItemDatabaseSimpleResource($this->drop7),
            'drop7_rate' => $this->drop7_rate,
            'drop8_item' => new ItemDatabaseSimpleResource($this->drop8),
            'drop8_rate' => $this->drop8_rate,
            'drop9_item' => new ItemDatabaseSimpleResource($this->drop9),
            'drop9_rate' => $this->drop9_rate,
            'drop10_item' => new ItemDatabaseSimpleResource($this->drop10),
            'drop10_rate' => $this->drop10_rate,
            'mvpdrop1_item' => new ItemDatabaseSimpleResource($this->mvpDrop1),
            'mvpdrop1_rate' => $this->mvpdrop1_rate,
            'mvpdrop2_item' => new ItemDatabaseSimpleResource($this->mvpDrop2),
            'mvpdrop2_rate' => $this->mvpdrop2_rate,
            'mvpdrop3_item' => new ItemDatabaseSimpleResource($this->mvpDrop3),
            'mvpdrop3_rate' => $this->mvpdrop3_rate,
        ];
    }
}
