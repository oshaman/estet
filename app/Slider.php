<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['title', 'path', 'alt', 'event_id'];
}
