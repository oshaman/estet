<?php

namespace Fresh\Estet;

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
    protected $fillable = [
        'email', 'password', 'email_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     *  Get the tmp_person associated with the user.
     */

    public function tmpPerson()
    {
        return $this->hasOne('Fresh\Estet\TmpPerson');
    }
     /**
     *  Get the person associated with the user.
     */

    public function person()
    {
        return $this->hasOne('Fresh\Estet\Person');
    }

    /**
     *  Get the role associated with the user.
     */

    public function roles()
    {
        return $this->belongsToMany('Fresh\Estet\Role','role_user');
    }
/**
     *  Get the blog associated with the user.
     */

    public function blogs()
    {
        return $this->hasMany('Fresh\Estet\Blog');
    }

    /**
     *
     *  set $requre = true if all of permissions has to be checked
     */

    public function canDo($permission, $require = FALSE)
    {
        if(is_array($permission)) {
            foreach($permission as $permName) {

                $permName = $this->canDo($permName);
                if($permName && !$require) {
                    return TRUE;
                }
                else if(!$permName && $require) {
                    return FALSE;
                }
            }
            return  $require;
        }
        else {
            foreach($this->roles as $role) {
                foreach($role->perms as $perm) {
                    if(str_is($permission,$perm->name)) {
                        return TRUE;
                    }
                }
            }
        }
    }
    // string  ['role1', 'role2']
    public function hasRole($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);
                if ($hasRole && !$require) {
                    return true;
                } elseif (!$hasRole && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->roles as $role) {
                if ($role->name == $name) {
                    return true;
                }
            }
        }
        return false;
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($user) { // before delete() method call this
            $user->person()->delete();
            // do the rest of the cleanup...
        });
    }

}
