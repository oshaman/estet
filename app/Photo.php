<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['article_id', 'path'];
    public $timestamps = false;
}
