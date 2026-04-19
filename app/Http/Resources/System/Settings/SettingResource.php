<?php

namespace App\Http\Resources\System\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'active_theme' => $this->active_theme ?? "",
            'active_lang' => $this->active_lang ?? "",
            'active_currency' => $this->active_currency ?? "",
            'active_timezone' => $this->active_timezone ?? "",
            'active_direction' => $this->active_direction ?? "",
        ];
    }
}
