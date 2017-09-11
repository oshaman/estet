<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Horocomment extends Model
{
    protected $fillable = ['name', 'email', 'text', 'parent_id', 'approved'];
}
