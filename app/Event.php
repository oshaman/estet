<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'alias', 'country_id', 'city_id', 'start',
        'stop', 'content', 'description', 'seo', 'approved', 'organizer_id', 'cat_id'];

    /**
     *  Get the main_img associated with the blog.
     */
    public function logo()
    {
        return $this->hasOne('Fresh\Estet\Logo');
    }
    /**
     *  Get the slider_imgs associated with the blog.
     */
    public function slider()
    {
        return $this->hasMany('Fresh\Estet\Slider');
    }

    /**
     * @return $this
     */
    public function comments()
    {
        return $this->hasMany('Fresh\Estet\Eventcomment')->where('approved', 1);
    }
}
