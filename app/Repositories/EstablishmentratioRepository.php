<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Establishmentratio;
use DB;

class EstablishmentratioRepository
{
    protected $model;

    public function __construct(Establishmentratio $rep)
    {
        $this->model = $rep;
    }

    public function getRatio($id)
    {
        return DB::select("SELECT COUNT(*) as count, ROUND(AVG(value), 1) as avg FROM `establishmentratios` WHERE establishment_id=".$id);
    }

    public function setRatio($request)
    {
        $data['data_key'] = md5($request->ip() . $request->header('User-Agent') . substr(session()->getId(), 0, 5));
        if (session()->has($data['data_key'])) {
            return ['val' => $data['data_key']];
        }

        $data['establishment_id'] = $request->get('data_id');
        $data['value'] = $request->get('ratio');

        if ($val = $this->model->where(['establishment_id' => $data['establishment_id'], 'data_key' => $data['data_key']])->first()) {
            session()->put($data['data_key'], $val->value);
            return ['val' => $val->value];
        }

        try {
            $this->model->fill($data)->save();
        } catch (Exception $e) {
            return ['val' => $data['data_key']];
        }
        session()->put($data['data_key'], $data['value']);
        return ['val' => $data['value'], 'establishment_id' => $data['establishment_id']];
    }

}