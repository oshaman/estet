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

        $model = $this->model->where('user_id', $data['user_id'])->first();

        array_forget($data,'specialty');
        array_forget($data,'month');
        array_forget($data,'year');
        dd($data);
        if ($model) {
            $model->fill($data)->update();
            return ['status' => 'Профиль обновлен'];
        } else {
            $this->model->updateOrCreate($data);
            return ['status' => 'Профиль создан'];
        }
//        $this->person->specialies()->sync($data['specialty_id']);


    }
}

?>