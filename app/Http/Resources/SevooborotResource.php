<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SevooborotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if(is_null($this->resource)){
            return [];
        } else {
            return [
                'id' => $this->id,
                'nomenklature' => $this->nomenklature->name . ' ' . $this->reproduktion->name,
                'square' => $this->square,
            ];
        }
    }
}
