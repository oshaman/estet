<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Person;
use Gate;
use File;

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

        if (!empty($data['services'])) {
            $data['services'] = json_encode($data['services']);
        }

        if (!empty($data['photo_status'])) {
            $data = $this->uploadImg($data);
        }
//        dd($res);
        $person->fill($data)->update();
        $person->specialties()->sync($data['specialty']);

        if (!empty($data['confirmed'])) {
            $person->user->roles()->sync([2]);
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
            if (!empty($data['confirmed'])) {
                $person->user->roles()->sync([2]);
            }
        }
        return ['status' => 'Профиль создан'];
    }

    public function uploadImg($data)
    {
        if ('aply' == $data['photo_status']) {

            $str = substr($data['alias'], 0, 32) . '-' . time();

            $path = $str.'.jpg';
            
            if (File::exists(config('settings.theme').'/img/tmp_profile/'.$data['photo'])) {
                File::move(config('settings.theme').'/img/tmp_profile/'.$data['photo'], config('settings.theme').'/img/profile/'.$path);
                $data['photo'] = $path;
                return $data;
            } else {
                return 'Ошибка добавления фото';
            }

        }
        return $data;
    }
}

?>