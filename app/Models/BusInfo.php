<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusInfo extends Model
{
    use HasFactory;
    protected $table = 'buses_info';
    protected $primaryKey = 'Bus_ID';
    public $timestamps = false;

    protected $fillable = [
        'ID',
        'Bus_Supervisor_ID',
        'Bus_Driver_ID',
        'Bus_Line_Name',
    ];

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'Bus_Supervisor_ID', 'ID');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'Bus_Driver_ID', 'ID');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'Bus_ID', 'Bus_ID');
    }
}
