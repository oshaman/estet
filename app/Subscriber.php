<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['email', 'source'];
}
