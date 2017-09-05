<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Advertising;
use Validator;
use Cache;

class AdvertisingRepository extends Repository
{
    /**
     * construct
     */
    public function __construct(Advertising $advertising)
    {
        $this->model = $advertising;
    }

    /**
     * @param $request
     * @param $advertising
     * @return array
     */
    public function updateAdvertising($request, $advertising)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return ['error'=>$validator];
        }

        try {
            $advertising->fill($request->except('_token'))->save();
        } catch (Exception $e) {
            \Log::info('Ошибка записи advertising: ', $e->getMessage());
            $error[] = ['advertising' => 'Ошибка записи рекламы'];
            return $error;
        }
        Cache::forget('main');
        return ['status' => trans('admin.material_updated')];
    }

    public function getMainPatient()
    {
        $collection = $this->model->select('text', 'placement')->where('own', 'patient')->get();
        $result = [];
        foreach ($collection as $item) {
            if ('main_1' == $item->placement) {
                $result['main_1'] = $item->text;
            } elseif ('main_2' == $item->placement) {
                $result['main_2'] = $item->text;
            } else {
                continue;
            }
        }
        return $result;
    }
}