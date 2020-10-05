<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name'           => $this->name,
            'component'      => $this->component,
            'previous_value' => $this->value,
            'value'          => $this->value,
            'updated_at'     => $this->updated_at,
            'updating'       => false,
            'success'        => false,
            'error'          => false,
        ];
    }
}
