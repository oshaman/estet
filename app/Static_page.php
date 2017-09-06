<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Static_page extends Model
{
    protected $table = 'statics';
    protected $fillable = ['seo', 'title', 'text'];
}
