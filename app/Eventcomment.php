<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Eventcomment extends Model
{
    protected $fillable = ['name', 'email', 'text', 'event_id', 'parent_id', 'approved'];
}
