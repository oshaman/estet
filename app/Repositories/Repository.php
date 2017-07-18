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

        $result->transform(function($item,$key) {

            if (is_string($item->img) && is_object(json_decode($item->img)) && (json_last_error() == JSON_ERROR_NONE)) {
                $item->img = json_decode($item->img);
            }

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

}

?>