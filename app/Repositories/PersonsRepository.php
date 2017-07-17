<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Person;
use Gate;

class PersonsRepository extends Repository {


    public function __construct(Person $person)
    {
        $this->model = $person;
    }

    public function updatePerson($request, $person, $user)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }
        $data = $request->except('_token');

        if (!empty($data['services'])) {
            $data['services'] = json_encode($data['services']);
        }

        $person->fill($data)->update();
        $person->specialties()->sync($data['specialty']);
dd($user);
        if (!empty($data->confirmed)) {
            $user->roles()->sync([2]);
        }
        return ['status' => 'Профиль обновлен'];
    }

    public function createPerson($request)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }
//        dd("CREATE");
        $data = $request->except('_token');

        if (!empty($data['services'])) {
            $data['services'] = json_encode($data['services']);
        }

        $person = $this->model->create($data);

        if($person->id) {
            $person->specialties()->attach($data['specialty']);
        }
        return ['status' => 'Профиль создан'];
    }
}

?>