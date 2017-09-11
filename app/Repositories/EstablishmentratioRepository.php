<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Establishmentratio;
use DB;

class EstablishmentratioRepository
{
    protected $model;

    public function __construct(Establishmentratio $rep)
    {
        $this->model = $rep;
    }

    public function getRatio($id)
    {
        return DB::select("SELECT COUNT(*) as count, ROUND(AVG(value), 1) as avg FROM `establishmentratios` WHERE establishment_id=".$id);
    }

}