<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class TmpPerson extends Model
{
    protected $fillable = [
        'user_id', 'name', 'lastname', 'phone', 'specialty', 'category', 'job', 'address',
        'expirience', 'shedule', 'services', 'alias', 'site', 'content', 'photo', 'approved'
    ];

    protected $table = 'tmp_persons';

    public function user()
    {
        return $this->belongsTo('Fresh\Estet\User');
    }

}
