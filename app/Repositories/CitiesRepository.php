<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\City;
use Validator;
use Config;

class CitiesRepository extends Repository
{
    public function __construct(City $city)
    {
        $this->model = $city;
    }

    public function getCities($request)
    {
        if ($request->has('param')) {
            $validator = Validator::make($request->all(), [
                'param' => 'integer|min:1',
            ]);

            if ($validator->fails()) {
                return ['error'=>$validator];
            }
        } else {
            return null;
        }

        $cities = $this->model->where('country_id', $request->get('param'))->paginate(Config::get('settings.paginate'));

        if ($cities->firstItem()) {
            return $cities;
        } else {
            return null;
        }


    }

    /**
     * @param $request
     * @return array Status
     */
    public function addCity($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:40',
            'country' => 'exists:countries,id|integer|min:1',
        ]);

        if ($validator->fails()) {
            return ['error'=>$validator];
        }

        $this->model->country_id = $request->get('country');
        $this->model->name = $request->get('name');
        $result = $this->model->save();

        if ($result) {
            return ['status' => 'Записи обновлены'];
        }
        return ['error'=>'Ошибка записи'];
    }

    /**
     * @param $request
     * @param $city Instance of city
     * @return array Stetus
     */
    public function updateCity($request, $city)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required|string|max:40',
            'country' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return ['error'=>$validator];
        }
        $city->name = $request->get('city');
        $this->model->name = $request->get('name');

        $result = $city->save();

        if ($result) {
            return ['status' => 'Запись обновлена'];
        }
        return ['error'=>'Ошибка записи'];
    }
}