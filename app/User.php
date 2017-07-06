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
        'name', 'email', 'password', 'email_token',
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
     *  Get the role associated with the user.
     */

    public function roles()
    {
        return $this->belongsToMany('Fresh\Estet\Role','role_user');
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

}
