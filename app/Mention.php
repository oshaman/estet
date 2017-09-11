<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    protected $fillable = ['article_id', 'establishment_id'];
    public $timestamps = false;
}
