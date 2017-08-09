<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Establishment;
use Gate;



class EstablishmentsRepository extends Repository
{
    public function __construct(Establishment $establishment)
    {
        $this->model = $establishment;
    }

    public function getParents()
    {
        $results = $this->model->where([['parent', null], ['category', 'distributor']])
            ->select(['id', 'title'])
            ->get();
        $parents = [];
        foreach ($results as $result) {
            $parents[$result->id] = $result->title;
        }
        return $parents;
    }

}