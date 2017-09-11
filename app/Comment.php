<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['name', 'email', 'text', 'article_id', 'parent_id', 'approved'];

}
