<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $table = 'users';
    public $remember_token=false;
    protected $fillable = [
        'user_id', 'user_pass',
    ];

    public function getAuthPassword(){  
        return $this->user_pass;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['user_pass'] = bcrypt($value);
    }

    public function getId()
    {
        return $this->user_id;
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_pass', 'remember_token', 'pq_maso'
    ];
}
