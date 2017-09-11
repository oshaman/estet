<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     *  Get the user associated with the role.
     */
    public function users()
    {
        return $this->belongsToMany('Fresh\Estet\User','role_user');
    }

    /**
     *  Get the permission associated with the role.
     */
    public function perms()
    {
        return $this->belongsToMany('Fresh\Estet\Permission','permission_role');
    }

    /**
     *
     *
     * return boolean
     */
    public function hasPermission($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $permissionName) {
                $hasPermission = $this->hasPermission($permissionName);
                if ($hasPermission && !$require) {
                    return true;
                } elseif (!$hasPermission && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->perms as $permission) {
                if ($permission->name == $name) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     *
     *
     * return boolean
     */
    public function savePermissions($inputPermissions) {

        if(!empty($inputPermissions)) {
            $this->perms()->sync($inputPermissions);
        }
        else {
            $this->perms()->detach();
        }

        return true;
    }
}
