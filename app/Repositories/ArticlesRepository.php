<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Article;
use Gate;
use File;
use Image;
use Config;
use Validator;

class ArticlesRepository extends Repository
{
    public function __construct(Article $rep)
    {
        $this->model = $rep;
    }


}