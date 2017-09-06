<?php

namespace Fresh\Estet\Http\Controllers\Patient;

use Fresh\Estet\Horoscope;
use Cache;
use DB;


class HoroscopeController extends ArticlesController
{
    public function index()
    {
        $signs = Cache::remember('horoscope', 60*24*30, function () {
           return array_except(Horoscope::first()->toArray(), ['id', 'created_at', 'updated_at']);
        });

        $this->content = view('patient.horoscope')->with(['signs' => $signs])->render();

        $this->getSidebar();
        $this->seo = Cache::remember('seo_horoscope', 24 * 60, function () {
            return $this->seo_rep->getSeo('goroscop');
        });

        return $this->renderOutput();
    }
}
