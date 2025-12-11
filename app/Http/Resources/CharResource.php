<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharResource extends JsonResource
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
            'class_id' => $this->class,
            'class_name' => $this->getClass(),
            'level' => $this->base_level . '/' . $this->job_level,
            'last_login' => Carbon::parse($this->last_login)->timezone('America/Sao_Paulo')->locale('pt_BR')->diffForHumans()
        ];
    }
}
