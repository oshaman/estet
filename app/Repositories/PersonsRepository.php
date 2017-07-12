<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Person;
use Gate;

class PersonsRepository extends Repository {


    public function __construct(Person $person)
    {
        $this->model = $person;
    }

    public function updatePerson($request)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }

        $data = $request->except('_token');
//dd($data);
        array_forget($data,'specialty');
        array_forget($data,'services');
        $this->model->updateOrCreate($data);
//        $this->person->roles()->sync($data['specialty_id']);

        return ['status' => trans('Профиль обновлен')];

    }
}

?>