<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'country_id'];
    public $timestamps = false;
}
