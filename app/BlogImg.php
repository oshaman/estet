<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class BlogImg extends Model
{
    protected $fillable = ['title', 'path', 'alt', 'blog_id'];
    public $timestamps = false;
}
