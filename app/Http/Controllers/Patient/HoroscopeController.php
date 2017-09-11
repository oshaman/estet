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
        Cache::flush();
        $signs = Cache::remember('horoscope', 60*24*30, function () {
           return array_except(Horoscope::first()->toArray(), ['id', 'created_at', 'updated_at']);
        });

        //          most displayed
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient']);
        $bests = $this->a_rep->get(['title', 'alias', 'created_at'], 3, false, $where, ['view', 'desc'], ['image', 'category']);


        $this->getSidebar();
        $this->content = view('patient.horoscope')->with(['signs' => $signs, 'bests' => $bests,'sidebar' => $this->sidebar])->render();

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
