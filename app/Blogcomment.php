<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Blogcomment extends Model
{
    protected $fillable = ['name', 'email', 'text', 'blog_id', 'parent_id', 'approved'];
}
