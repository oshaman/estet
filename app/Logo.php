<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $fillable = ['title', 'path', 'alt', 'article_id'];
}
