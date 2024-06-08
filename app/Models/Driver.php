<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $table = 'driver';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ID',
        'Full_Name',
        'Phone',
        'Email',
        'Image',
    ];

    public function bus()
    {
        return $this->hasOne(BusInfo::class, 'Bus_Driver_ID', 'ID');
    }
}
