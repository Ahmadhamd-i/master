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
        'Full_Name',
        'Image',
        'Phone',
        'Email',
    ];
}
