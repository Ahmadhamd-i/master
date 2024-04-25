<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
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
            'Parent_Name' => $this->Full_Name,
            'Child_Name' => $this->Child_Name,
            'Email' => $this->Email,
            'Phone' => $this->Phone,
            'address' => $this->address,
            'Supervisor_ID' => $this->Supervisor_ID,
        ];
    }
}
