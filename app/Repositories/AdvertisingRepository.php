<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Advertising;
use Validator;

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
        return ['status' => trans('admin.material_updated')];
    }
}