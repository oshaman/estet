<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Role;

class RolesRepository extends Repository {


    public function __construct(Role $role) {
        $this->model = $role;
    }

}