<?php

namespace Fresh\Estet\Http\Controllers\Patient;

use Fresh\Estet\Horoscope;
use Cache;
use DB;


class HoroscopeController extends ArticlesController
{
    public function index()
    {
        $signs = array_except(Horoscope::first()->toArray(), ['id', 'created_at', 'updated_at']);

        $this->sidebar = Cache::remember('horoscopeSidebar', 60, function () {
//                Last 2 publications
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient']);
            $lasts = $this->a_rep->getLast(['title', 'alias', 'created_at'], $where, 2, ['created_at', 'desc']);

            //          most displayed
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient']);
            $articles = $this->a_rep->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);
            return view('patient.sidebar')->with(['lasts'=>$lasts, 'articles'=>$articles])->render();
        });

        $this->content = view('patient.horoscope')->with(['signs' => $signs, 'sidebar' => $this->sidebar])->render();

        return $this->renderOutput();
    }
}
