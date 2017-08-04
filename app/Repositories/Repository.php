<?php

namespace Fresh\Estet\Repositories;

use Config;

abstract class Repository {

    protected $model = false;


    public function get($select = '*', $take = false, $pagination = false, $where = false, $order = false, $with=false)
    {
        $builder = $this->model->select($select);

        if ($with) {
            $builder = $this->model->with($with);
        }

        if ($take) {
            $builder->take($take);
        }

        if ($where) {
            if (is_array($where[0])) {
                $builder->where([$where[0], $where[1]]);
            } else {
                $builder->where($where[0], $where[1], $where[2] = false);
            }
        }

        if ($order) {
            $builder->orderBy($order[0], $order[1]);
        }

        if($pagination) {
            return $this->check($builder->paginate(Config::get('settings.paginate')));
        }

        return $this->check($builder->get());
    }

    protected function check($result)
    {

        if($result->isEmpty()) {
            return FALSE;
        }

        $result->transform(function($item) {
            $midnight = strtotime('today midnight');
            $created = strtotime($item->created_at);

            if ($created > $midnight) {
                $item->created = date('H:i', $created);
            } else {
                $item->created = date('d-m-Y H:i:s', $created);
            }

            /*if (is_string($item->seo) && is_object(json_decode($item->seo)) && (json_last_error() == JSON_ERROR_NONE)) {
                $item->seo = json_decode($item->seo);
            }*/

            return $item;

        });

        return $result;

    }

    public function one($alias, $attr = array())
    {
        $result = $this->model->where('alias', $alias)->first();

        return $result;
    }

    public function findById($id, $attr = array())
    {
        $result = $this->model->where('id', $id)->first();

        return $result;
    }

    public function findByUserId($id, $attr = array())
    {
        $result = $this->model->where('user_id', $id)->first();

        return $result;
    }

    public function transliterate($string)
    {
        $str = mb_strtolower($string, 'UTF-8');

        $leter_array = array(
            'a' => 'а',
            'b' => 'б',
            'v' => 'в',
            'g' => 'г,ґ',
            'd' => 'д',
            'e' => 'е,э',
            'jo' => 'ё',
            'zh' => 'ж',
            'z' => 'з',
            'i' => 'и',
            'j' => 'й',
            'k' => 'к',
            'l' => 'л',
            'm' => 'м',
            'n' => 'н',
            'o' => 'о',
            'p' => 'п',
            'r' => 'р',
            's' => 'с',
            't' => 'т',
            'u' => 'у',
            'f' => 'ф',
            'kh' => 'х',
            'ts' => 'ц',
            'ch' => 'ч',
            'sh' => 'ш',
            'shch' => 'щ',
            '' => 'ъ',
            'y' => 'ы',
            '' => 'ь',
            'yu' => 'ю',
            'ya' => 'я',
        );

        foreach ($leter_array as $leter => $kyr) {
            $kyr = explode(',',$kyr);

            $str = str_replace($kyr,$leter, $str);
        }

        //  A-Za-z0-9-
        $str = preg_replace('/(\s|[^A-Za-z0-9\-_])+/','-',$str);

        $str = trim($str,'-');

        return $str;
    }

    public function convertSeo($seo)
    {
        if (is_string($seo) && is_object(json_decode($seo)) && (json_last_error() == JSON_ERROR_NONE)) {
            $seo = json_decode($seo);
        }
        return $seo;
    }

    public function convertDate($date)
    {
        $midnight = strtotime('today midnight');
        $created = strtotime($date);

        if ($created > $midnight) {
            $date = date('H:i', $created);
        } else {
            $date = date('d-m-Y H:i:s', $created);
        }
        return $date;
    }

}

?>