<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     *  Get the role associated with the permisions.
     */

    public function roles()
    {
        return $this->belongsToMany('Fresh\Estet\Role','permission_role');
    }
}
