<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $fillable = ['name', 'alias', 'parent'];
}
