<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Tmpblog extends Model
{
    protected $fillable = ['title', 'category', 'content', 'image', 'moderate', 'blog_id'];

    public function user()
    {
        return $this->belongsTo('Fresh\Estet\User');
    }
}
