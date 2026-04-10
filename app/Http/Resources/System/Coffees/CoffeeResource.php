<?php

namespace App\Http\Resources\System\Coffees;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoffeeResource extends JsonResource
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
            'name' => $this->name,
            'join_date' => $this->join_date,
            'address' => $this->address,
            'type' => $this->type,
            'website' => $this->website,
            'phone' => $this->phone,
            'logo' => $this->logo,
            'created_by' => $this->createdBy->name ?? null,
            'updated_by' => $this->updatedBy->name ?? null,
        ];
    }
}
