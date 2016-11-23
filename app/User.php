<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

//    public function hasPermission(Permission $permission){
//        return $this->hasAnyRoles($permission->roles);
//    }
//
//    public function hasAnyRoles($roles)
//    {
//        if ( is_array($roles) || is_object($roles) )
//        {
//            return !! $roles->intersect($this->roles)->count();
//        }
//
//        return $this->roles->contains('name', $roles);
//
//    }
}
