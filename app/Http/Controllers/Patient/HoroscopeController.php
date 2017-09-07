<?php

namespace Fresh\Estet\Http\Controllers\Patient;

use Fresh\Estet\Horoscope;
use Cache;
use DB;


class HoroscopeController extends ArticlesController
{
    /**
     * @return $this
     */
    public function index()
    {
        $signs = Cache::remember('horoscope', 60*24*30, function () {
           return array_except(Horoscope::first()->toArray(), ['id', 'created_at', 'updated_at']);
        });

        $this->sidebar = $this->getSidebar();

        $this->content = view('patient.horoscope')->with(['signs' => $signs, 'sidebar' => $this->sidebar])->render();

        $this->title = 'Гороскоп';
        $this->seo = Cache::remember('seo_horo', 24 * 60, function () {
            return $this->seo_rep->getSeo('goroscop');
        });

        $this->title = 'Гороскоп красоты';
        $this->seo = Cache::remember('seo_horoscope', 24 * 60, function () {
            return $this->seo_rep->getSeo('goroscop');
        });

        $this->css = '
            <link rel="stylesheet" type="text/css" href="' . asset('css') . '/patient.css">
            <link rel="stylesheet" type="text/css" href="' . asset('css') . '/patient-media.css">
            <link rel="stylesheet" type="text/css" href="' . asset('css') . '/horoscope.css">
            <link rel="stylesheet" type="text/css" href="' . asset('css') . '/horoscope-media.css">
        ';
        $this->js = '
            <script src="' . asset('js') . '/main-artur.js"></script>
        ';

        return $this->renderOutput();
    }
}
