<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title', 'alias', 'content', 'category_id', 'created_at', 'approved', 'seo', 'user_id'];


    /**
     *  Get the user associated with the blog.
     */
    public function user()
    {
        return $this->belongsTo('Fresh\Estet\User');
    }

    /**
     *  Get the category associated with the blog.
     */
    public function category()
    {
        return $this->belongsTo('Fresh\Estet\Category');
    }

    /**
     *  Get the main_img associated with the blog.
     */
    public function blog_img()
    {
        return $this->hasOne('Fresh\Estet\BlogImg');
    }

    /**
     *  Get the content_imgs associated with the blog.
     */
    public function blogphoto()
    {
        return $this->hasMany('Fresh\Estet\Blogphoto');
    }

    public function tags()
    {
        return $this->belongsToMany('Fresh\Estet\Tag', 'blog_tag');
    }

    public function hasTag($id)
    {
        foreach ($this->tags as $tag) {
            if ($tag->id == $id) {
                return true;
            }
        }
        return false;
    }
    /* public function comments()
    {
        return $this->hasMany('Fresh\Estet\Comment');
    } */
}
