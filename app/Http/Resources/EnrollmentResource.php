<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'student_ID' => $this->student_ID,
            'enroll_time' => $this->enroll_time,
            'Student_Status' => $this->Student_Status,
        ];
    }
}
