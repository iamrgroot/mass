<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleOptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'text'  => $this->name,
            'value' => $this->id,
        ];
    }
}
