<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function PHPUnit\Framework\isEmpty;

class ProductMonitoringResource extends JsonResource
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
                'tuberTemperatureMorning' => $this->tuberTemperatureMorning,
                'humidity' => $this->humidity,
                'condensate' => $this->condensate,
                'comment'   => $this->comment,
            ];
        }
    }
}
