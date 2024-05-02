<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parents

extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'parent';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ID',
        'Full_Name',
        'Password',
        'Email',
        'Phone',
        'address',
    ];

    public function children()
    {
        return $this->hasMany(Student::class, 'Parent_ID', 'ID');
    }
}
