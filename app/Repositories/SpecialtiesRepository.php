<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Specialty;
use Gate;

class SpecialtiesRepository extends Repository {


    protected $spec_rep;


    public function __construct(Specialty $specialty) {
        $this->model = $specialty;
    }

}

?>