<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Establishmentratio extends Model
{
    protected $fillable = ['establishment_id', 'data_key', 'value'];
    public $timestamps = false;
}
