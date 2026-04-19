<?php

namespace App\Http\Resources\Main;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftsResource extends JsonResource
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
            'user' => $this->user->name ?? "",
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'from' => $this->from,
            'to' => $this->to,
            'opened_by' => $this->opened_by,
            'closed_by' => $this->closed_by,
            'notes' => $this->notes,
        ];
    }
}
