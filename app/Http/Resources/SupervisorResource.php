<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupervisorResource extends JsonResource
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
            'Supervisor Name' => $this->Full_Name,
            'Supervisor Image' => $this->Image, //base64_encode($this->Image),
            'Email' => $this->Email,
            'Phone' => $this->Phone,
            'Address' => $this->Address,
            'location' => $this->location,
        ];
    }
}
