<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'type'       => $this->type,
            'text'       => $this->text,
            'image_url'  => str_replace('http://', 'https://', $this->image_url),
            'status'     => new RequestStatusResource($this->whenLoaded('status')),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ];
    }
}
