<?php

namespace Fresh\Estet\Http\Controllers\Doctors;

use Fresh\Estet\Http\Requests\EventRequest;
use Fresh\Estet\Repositories\ArticlesRepository;
use Fresh\Estet\Repositories\CitiesRepository;
use Fresh\Estet\Repositories\CountriesRepository;
use Fresh\Estet\Repositories\EventCategoriesRepository;
use Fresh\Estet\Repositories\EventsRepository;
use DB;
use Fresh\Estet\Repositories\OrganizersRepository;
use Fresh\Estet\Repositories\PremiumsRepository;

class EventsController extends DocsController
{
    protected $repository;
    protected $countries;
    protected $cities;
    protected $cats;
    protected $organizer;
    protected $prem;

    public function __construct(
        ArticlesRepository $article,
        EventsRepository $repository,
        CountriesRepository $countries,
        CitiesRepository $cities,
        EventCategoriesRepository $cats,
        OrganizersRepository $organizer,
        PremiumsRepository $prem
    )
    {
        parent::__construct($article);
        $this->repository = $repository;
        $this->countries = $countries;
        $this->cities = $cities;
        $this->cats = $cats;
        $this->organizer = $organizer;
        $this->prem = $prem;
    }

    public function show(EventRequest $request, $event=false)
    {

        //        Last 2 publications
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs']);
        $articles = $this->a_rep->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);
//        Last 2 events
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')]);
        $lasts = $this->repository->get(['title', 'alias', 'created_at'], 2, false, $where, ['created_at', 'desc']);

        $this->sidebar = view('doc.events.sidebar')->with(['lasts'=>$lasts, 'articles'=>$articles])->render();


        if ($event) {
            if (!empty($event->seo)) {
                $event->seo = $this->repository->convertSeo($event->seo);
            }
            $event->created = $this->repository->convertDate($event->created_at);
            $event->load('logo');
            $event->load('slider');
            $event->load('comments');

            $this->repository->displayed($event->id);

            $this->content = view('doc.events.event')->with(['event'=>$event, 'sidebar'=>$this->sidebar])->render();
            return $this->renderOutput();
        }





        $prems_ids = $this->prem->getPremIds('event');


        $where = false;
        if ($request->isMethod('post')) {
            dd($request->all());
        }

        $where = false;

//
//        $now = \Carbon::now();
//        $month = $now->format('m');
//        dd(date($month));
//
//        $where1 = [
//            ['start', '>=', date('Y-m-d', now())]
//        ];

       /* $calendar = $this->repository->get(['title'], false, false, $where1, false, ['logo']);
        dd($calendar);*/
        $events = $this->repository->getWithoutPrems(true, $where, $prems_ids);
//        dd($events);

        $vars = [
            'events'=>$events,
            'sidebar'=>$this->sidebar,
            'countries'=>$this->countries->getCountriesSelect(),
            'cities'=>$this->cities->citiesSelect(),
            'cats'=>$this->cats->catSelect(),
            'organizer'=>$this->organizer->organizerSelect(),
            'prems'=>$this->repository->getPrems($prems_ids),
        ];

        $this->content = view('doc.events.index')->with($vars)->render();
        return $this->renderOutput();
    }
}
