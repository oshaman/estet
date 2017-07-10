<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class TmpPerson extends Model
{
    protected $table = 'tmp_persons';

    public function user()
    {
        return $this->belongsTo('Fresh\Estet\User');
    }

}
