<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'Student_Name' => $this->FullName,
            'grade' => $this->grade,
            'class' => $this->class,
            'Student Image' => $this->Image,
            'Parent_ID' => $this->Parent_ID,
        ];
    }
}
