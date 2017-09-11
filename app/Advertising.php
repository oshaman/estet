<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Advertising extends Model
{
    protected $fillable = ['placement', 'text', 'own'];
}
