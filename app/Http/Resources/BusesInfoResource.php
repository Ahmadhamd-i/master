<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusesInfoResource extends JsonResource
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
            'Bus_Supervisor_ID' => $this->Bus_Supervisor_ID,
            'Bus_Driver_ID' => $this->Bus_Driver_ID,
            'Bus-Line' => $this->Bus_Line_Name,
            'Bus_License' => $this->Bus_License,

        ];
    }
}
