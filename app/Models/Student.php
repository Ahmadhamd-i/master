<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ID',
        'FullName',
        'Parent_ID',
        'Image',
        'grade',
        'class',
        'Supervisor_ID'
    ];

    public function parent()
    {
        return $this->belongsTo(Parents::class, 'Parent_ID', 'ID');
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'Supervisor_ID', 'ID');
    }

    public function enrollment()
    {
        return $this->hasOne(Enrollment::class, 'student_ID', 'ID');
    }
}
