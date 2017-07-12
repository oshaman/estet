<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons';
    protected $fillable = [
        'user_id', 'name', 'lastname', 'phone', 'category', 'job', 'address',
        'expirience', 'shedule', 'services', 'alias', 'site', 'content', 'photo'
    ];

    public function user()
    {
        return $this->belongsTo('Fresh\Estet\User');
    }

    public function specialty()
    {
        return $this->belongsToMany('Fresh\Estet\Specialty', 'specialty_person');
    }

}
