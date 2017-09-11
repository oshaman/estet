<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['title', 'path', 'alt', 'article_id'];
    public $timestamps = false;
}
