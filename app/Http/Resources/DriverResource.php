<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ID' => $this->ID,
            'Driver Name' => $this->Full_Name,
            'Phone' => $this->Phone,
            'Email' => $this->Email,
            'Driver Image' => base64_encode($this->Image),
        ];
    }
}
