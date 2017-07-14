<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Repositories\Repository;
use Fresh\Estet\TmpPerson;

use Auth;
use Config;
use Image;
use File;

class TmpPersonRepository extends Repository {

    public function __construct(TmpPerson $model)
    {
        $this->model = $model;
    }

    public function update ($tmp_request)
    {
        $request = $tmp_request->except('_token', 'img');

        if (empty($request)) {
            return array('error' => trans('admin.no_data'));
        }
        $id = Auth::user()->id;
        $data = $this->findByUserId($id);

        if (!$data) {
            $data = $this->model;
            $data->user_id = $id;
        }

        if ($request['name'] != $data->name) {
            $data->name = $request['name'];
        }

        if ($request['lastname'] != $data->lastname) {
            $data->lastname = $request['lastname'];
        }

        if ($request['phone'] != $data->phone) {
            $data->phone = $request['phone'];
        }

        if ($request['specialty'] != $data->specialty) {
            $data->specialty = $request['specialty'];
        }

        if ($request['category'] != null && $request['category'] != $data->category) {
            $data->category = $request['category'];
        }

        if ($request['job'] != null && $request['job'] != $data->job) {
            $data->job = $request['job'];
        }
        
        if ($request['address'] != null && $request['address'] != $data->address) {
            $data->address = $request['address'];
        }

        if (!empty($request['expirience']) && $request['expirience'] != $data->expirience) {
            $data->expirience = $request['expirience'];
        }

        if ($request['shedule'] != null && $request['shedule'] != $data->shedule) {
            $data->shedule = $request['shedule'];
        }

        if ($request['services'] != null && $request['services'] != $data->services) {
            $data->services = $request['services'];
        }

        if (empty($data->alias)) {
            $data->alias = $this->transliterate($request['lastname']) . '-' . $this->transliterate($request['name']) ;
        }

        if ($request['site'] != null && $request['site'] != $data->site) {
            $data->site = $request['site'];
        } else {
            $data->site = url('/catalog/vrachi/') . '/' . $data->alias;
        }
        
        if ($request['content'] != null && $request['content'] != $data->content) {
            $data->content = $request['content'];
        }


        if ($tmp_request->hasFile('img')) {
            $image = $tmp_request->file('img');

            if($image->isValid()) {

                $str = substr($data->alias, 0, 32) . '-' . time();

                $path = $str.'.jpg';

                $img = Image::make($image);

                $img->widen(Config::get('settings.profile_img')['width'])->save(public_path().'/'.config('settings.theme').'/img/tmp_profile/'.$path, 100);

                if (!empty($data->photo)) {
                    $old_img = $data->photo;
                    if (File::exists(config('settings.theme').'/img/tmp_profile/'.$old_img)) {
                        File::delete(config('settings.theme').'/img/tmp_profile/'.$old_img);
                    }
                }

                $data->photo = $path;
            }
        }

        if ($data->save()) {
            return 'Данные отправлены на модерацию';
        } else {
            return 'Ошибка отправки данных';
        }

    }

    public function deleteTmp($id)
    {
        if($this->model->where('user_id', $id)->delete()) {
            return ['error' => 'Ошибка удаления tmp'];
        }
    }
}