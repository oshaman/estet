<?php

namespace Fresh\Estet;

use Illuminate\Database\Eloquent\Model;

class Docsratio extends Model
{
    protected $fillable = ['doc_id', 'data_key', 'value'];
    public $timestamps = false;
}
