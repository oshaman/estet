<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class BlogImg extends Model
{
    protected $fillable = ['blog_id', 'path'];
    public $timestamps = false;
}
