<?php

namespace App\Http\Resources;

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
        if ($this->is_active) {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'country' => $this->country->name,
            ];
        } else {
            return [];
        }

    }
}
