<?php

namespace App\Http\Resources\System\Subscriptions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'coffee_name' => $this->coffee->name ?? "",
            'name' => $this->name ?? "",
            'price' => $this->price ?? 0,
            'duration' => $this->duration ?? 0,
            'description' => $this->description ?? "",
        ];
    }
}
