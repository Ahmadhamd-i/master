<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;
    protected $table = 'enrollment';
    public $timestamps = false;
    protected $fillable = [
        'student_ID',
        'Student_Status',
    ];
}
