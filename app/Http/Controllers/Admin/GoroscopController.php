<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Fresh\Estet\Http\Controllers\Controller;
use Fresh\Estet\Horoscope;

class GoroscopController extends Controller
{
    protected $model;

    public function __construct(Horoscope $horoscope)
    {
        $this->model = $horoscope;
    }

    public function index()
    {

        $signs = array_except($this->model->first()->toArray(), ['id', 'created_at', 'updated_at']);

        return view('admin.horoscope')->with('signs', $signs)->render();
    }
}
