<?php

namespace App\Http\Resources\System\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'role' => $this->role,
            'coffee_id' => $this->coffee_id,
            "salary" => $this->salary,
            'is_cashier' => $this->is_cashier,
            'his_job' => $this->his_job,
            'phone' => $this->phone,
            'address' => $this->address,
        ];
    }
}
