<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    public function person()
    {
        return $this->belongsToMany('Fresh\Estet\Person', 'specialty_person');
    }
}
