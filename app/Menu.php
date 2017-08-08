<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['category_id', 'own'];

    public $timestamps = false;

    /**
     *  Get the category associated with the menu.
     */
    public function category()
    {
        return $this->belongsTo('Fresh\Estet\Category');
    }
}
