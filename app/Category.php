<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'alias'];

    public function articles()
    {
        return $this->belongsToMany('Fresh\Estet\Article', 'article_tag');
    }

}
