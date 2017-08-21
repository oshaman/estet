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
use Cache;

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
        $this->sidebar = Cache::remember('eventSidebar', 60,function() {
            //        Last 2 publications
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')]);
            $articles = $this->repository->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);
//        Last 2 events
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')]);
            $lasts = $this->repository->get(['title', 'alias', 'created_at'], 2, false, $where, ['created_at', 'desc']);

            return view('doc.events.sidebar')->with(['lasts'=>$lasts, 'articles'=>$articles])->render();
        });

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





        $prems_ids = Cache::remember('event_prem', 60, function() {
            return $this->prem->getPremIds('event');
        });

        $where = false;
        if (!empty($request->all())) {
            $data = $request->all();
            if(!empty($data['country'])) {
                $where[] = ['country_id', $data['country']];
            }

            if(!empty($data['city'])) {
                $where[] = ['city_id', $data['city']];
            }

            if(!empty($data['cat'])) {
                $where[] = ['cat_id', $data['cat']];
            }

            if(!empty($data['organizer'])) {
                $where[] = ['organizer_id', $data['organizer']];
            }
        }
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
            'countries'=>Cache::remember('countries', 600, function() {
                return $this->countries->getCountriesSelect();
                }),
            'cities'=>$this->cities->citiesSelect(),
            'cats'=>Cache::remember('eventCats', 600, function() {
                return $this->cats->catSelect();
            }),
            'organizer'=>Cache::remember('organizer', 600, function() {
                return $this->organizer->organizerSelect();
            }),
            'prems'=>Cache::remember('prems', 600, function() use ($prems_ids) {
                return $this->repository->getPrems($prems_ids);
            }),
        ];

        $this->content = view('doc.events.index')->with($vars)->render();
        return $this->renderOutput();
    }
}
