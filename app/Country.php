<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;
}
