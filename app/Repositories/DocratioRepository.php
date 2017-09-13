<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\Docsratio;
use DB;

class DocratioRepository
{
    protected $model;

    public function __construct(Docsratio $rep)
    {
        $this->model = $rep;
    }

    public function getRatio($id)
    {
        return DB::select("SELECT COUNT(*) as count, ROUND(AVG(value), 1) as avg FROM `docratios` WHERE doc_id=" . $id);
    }

    public function setRatio($request)
    {
        $data['data_key'] = md5($request->ip() . $request->header('User-Agent'));

        $data['doc_id'] = $request->get('data_id');
        $data['value'] = $request->get('ratio');

        if ($this->model->where(['doc_id' => $data['doc_id'], 'data_key' => $data['data_key']])->first()) {
            return false;
        }

        try {
            $this->model->fill($data)->save();
        } catch (Exception $e) {
            return false;
        }
        return $data['doc_id'];
    }

}