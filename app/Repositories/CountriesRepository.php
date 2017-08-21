<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Country;
use Validator;
use Cache;

class CountriesRepository extends Repository
{
    public function __construct(Country $country)
    {
        $this->model = $country;
    }

    /**
     * @param $request
     * @return array Status
     */
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
            Cache::forget('countries');
            return ['status' => 'Записи обновлены'];
        }
        return ['error'=>'Ошибка записи'];
    }

    /**
     * @param $request
     * @param $country Instance of Country
     * @return array Stetus
     */
    public function updateCountry($request, $country)
    {
        if ($country->name !== $request->get('country')) {
            $validator = Validator::make($request->all(), [
                'country' => 'unique:countries,name|required|string|max:40',
            ]);

            if ($validator->fails()) {
                return ['error'=>$validator];
            }
            $country->name = $request->get('country');
            $result = $country->save();

            if ($result) {
                Cache::forget('countries');
                return ['status' => 'Запись обновлена'];
            }
            return ['error'=>'Ошибка записи'];
        }
        return ['status' => 'Запись обновлена'];
    }

    public function getCountriesSelect()
    {
        $models = $this->get();
        $result =[];
        foreach ($models as $item) {
            $result[$item->id] = $item->name;
        }
        return $result;
    }
}