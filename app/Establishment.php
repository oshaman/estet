<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    protected $fillable = ['title', 'alias', 'logo', 'address', 'phones', 'site',
                        'parent', 'extra', 'services', 'about', 'category', 'spec'];

    /**
     *  Get the establishment associated with the articles.
     */

    public function articles()
    {
        return $this->belongsToMany('Fresh\Estet\Article','mentions')->select(['alias', 'title']);
    }

}
