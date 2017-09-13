<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Blogratio extends Model
{
    protected $fillable = ['blog_id', 'data_key', 'value'];
    public $timestamps = false;
}
