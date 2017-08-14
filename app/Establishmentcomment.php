<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Establishmentcomment extends Model
{
    protected $fillable = ['name', 'email', 'text', 'establishment_id', 'parent_id', 'approved'];
}
