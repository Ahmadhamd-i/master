<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Supervisor as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supervisor extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'supervisor';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ID',
        'Full_Name',
        'Password',
        'Image',
        'Email',
        'Phone',
        'Address',
        'location'
    ];

    public function buses()
    {
        return $this->hasMany(BusInfo::class, 'Bus_Supervisor_ID', 'ID');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'Supervisor_ID', 'ID');
    }

    public function parents()
    {
        return $this->hasManyThrough(Parents::class, Student::class, 'Supervisor_ID', 'Supervisor_ID', 'ID', 'ID');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}
