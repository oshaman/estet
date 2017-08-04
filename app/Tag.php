<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function blogs()
    {
        return $this->belongsToMany('Fresh\Estet\Blog', 'blog_tag');
    }

    public function articles()
    {
        return $this->belongsToMany('Fresh\Estet\Article', 'article_tag');
    }
}
