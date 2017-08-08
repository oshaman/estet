<?php

namespace Fresh\Estet\Http\Controllers\Patient;

use Fresh\Estet\Horoscope;


class HoroscopeController extends ArticlesController
{
    public function index()
    {
        $signs = array_except(Horoscope::first()->toArray(), ['id', 'created_at', 'updated_at']);

        $this->content = view('patient.horoscope')->with('signs', $signs)->render();

        return $this->renderOutput();
    }
}
