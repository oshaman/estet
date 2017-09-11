<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Blogphoto extends Model
{
    protected $fillable = ['blog_id', 'path'];
    public $timestamps = false;
}
