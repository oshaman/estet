<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Specialty;
use Gate;

class SpecialtiesRepository extends Repository {


    public function __construct(Specialty $specialty) {
        $this->model = $specialty;
    }

    /**
     * Create new Spetialty
     * @param $request
     * @return bool
     */
    public function addSpec($request)
    {
        $data['name'] = $request->only('spec')['spec'];
        $res = $this->model->fill($data)->save();

        return $res;
    }

    public function updateSpec($request, $id)
    {
        $model = $this->findById($id);
        $model->name = $request->spec;

        $res = $model->save();
        return $res;
    }


}

?>