<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Country;
use Validator;

class CountriesRepository extends Repository
{
    public function __construct(Country $country)
    {
        $this->model = $country;
    }

    public function addCountry($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'unique:countries,name|required|string|max:40',
        ]);

        if ($validator->fails()) {
            return ['error'=>$validator];
        }

        $this->model->name = $request->get('name');
        $result = $this->model->save();

        if ($result) {
            return ['status' => 'Записи обновлены'];
        }
        return ['error'=>'Ошибка записи'];
    }
}