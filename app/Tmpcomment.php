<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Tmpcomment extends Model
{
    protected $fillable = ['name', 'email', 'text', 'article_id', 'parent_id'];
}
