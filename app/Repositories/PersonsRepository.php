<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Person;
use Gate;

class PersonsRepository extends Repository {


    public function __construct(Person $person)
    {
        $this->model = $person;
    }

    public function updatePerson($request, $person)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }
        $data = $request->except('_token');

        $person->fill($data)->update();
        $person->specialties()->sync($data['specialty']);
        return ['status' => 'Профиль обновлен'];


    }

    public function createPerson($request)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }
//        dd("CREATE");
        $data = $request->except('_token');

        $person = $this->model->create($data);

        if($person->id) {
            $person->specialties()->attach($data['specialty']);
        }
        return ['status' => 'Профиль создан'];
    }
}

?>