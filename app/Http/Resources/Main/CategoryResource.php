<?php

namespace App\Http\Resources\Main;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'slug' => $this->slug,
            'coffee_id' => $this->coffee->name ?? null,
            'description' => $this->description,
            'image' => $this->image ? asset($this->image) : null,
            'is_active' => $this->is_active,
            'added_by' => $this->addedBy->name ?? null,
            'updated_by' => $this->updatedBy->name ?? null,
        ];
    }
}
