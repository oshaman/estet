<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    protected $fillable = ['title', 'alias', 'logo', 'address', 'phones', 'site',
                        'parent', 'extra', 'services', 'about', 'category', 'spec'];


}
