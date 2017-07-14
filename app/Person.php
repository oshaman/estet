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

    public function specialties()
    {
        return $this->belongsToMany('Fresh\Estet\Specialty', 'specialty_person');
    }

    public function hasSpecialty($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $specName) {
                $hasSpecialty = $this->hasRole($specName);
                if ($hasSpecialty && !$require) {
                    return true;
                } elseif (!$hasSpecialty && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->specialties as $specialtiy) {
                if ($specialtiy->name == $name) {
                    return true;
                }
            }
        }
        return false;
    }
}
