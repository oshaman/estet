<?php

namespace Fresh\Estet\Http\Controllers\Doctors;

use Fresh\Estet\Http\Requests\EventRequest;
use Fresh\Estet\Repositories\AdvertisingRepository;
use Fresh\Estet\Repositories\ArticlesRepository;
use Fresh\Estet\Repositories\CitiesRepository;
use Fresh\Estet\Repositories\CountriesRepository;
use Fresh\Estet\Repositories\EventCategoriesRepository;
use Fresh\Estet\Repositories\EventsRepository;
use DB;
use Fresh\Estet\Repositories\OrganizersRepository;
use Fresh\Estet\Repositories\PremiumsRepository;
use Cache;
use Carbon\Carbon;
use Fresh\Estet\Repositories\SeoRepository;

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
        PremiumsRepository $prem,
        AdvertisingRepository $adv,
        SeoRepository $seo_rep
    )
    {
        parent::__construct($article, $adv, $seo_rep);
        $this->repository = $repository;
        $this->countries = $countries;
        $this->cities = $cities;
        $this->cats = $cats;
        $this->organizer = $organizer;
        $this->prem = $prem;
    }

    public function show(EventRequest $request, $event = false)
    {
        Cache::flush();
        $this->getSidebar();

        if ($event) {

            $this->title = $event->title;

            $this->css = '
            <link rel="stylesheet" type="text/css" href="' . asset('css') . '/meropryyatyya-vnutrennyaya.css">
        ';

        $this->content = Cache::remember('event_content-' . $event->alias, 60, function () use ($event) {
            if (!empty($event->seo)) {
                $event->seo = $this->repository->convertSeo($event->seo);
            }
            $event->created = $this->repository->convertDate($event->created_at);
            $event->load('logo');
            $event->load('slider');
            $event->load('comments');
            $similar = $this->repository->getSimilar($event->id, $event->organizer_id, $event->cat_id);

            return view('doc.events.event')->with(['event' => $event, 'similars' => $similar, 'sidebar' => $this->sidebar])->render();
        });

        $this->repository->displayed($event);

            return $this->renderOutput();
        }

        $prems_ids = Cache::remember('event_prem', 60, function () {
            return $this->prem->getPremIds('event');
        });

        $where = false;
        $where_in = false;
        $children = false;
        if (!empty($request->all())) {
            $data = $request->all();
            if (!empty($data['country'])) {
                $where[] = ['country_id', $data['country']];
            }

            $request->session()->forget('city');
            if (!empty($data['city'])) {
                $request->session()->flash('city', $data['city']);
                $where[] = ['city_id', $data['city']];
            }

            if (!empty($data['cat'])) {
                $where[] = ['cat_id', $data['cat']];
            }

            if (!empty($data['organizer'])) {
                $children = $this->organizer->getChildren($data['organizer']);
                $where_in[] = $data['organizer'];
                if ($children->isNotEmpty()) {
                    foreach ($children as $child) {
                        $where_in[] = $child->id;
                    }
                }
            }
        }

        if ($request->has('year')) {
            $year = $request->get('year');
        } else {
            $year = date('Y');
        }

        if ($request->has('month')) {
            $month = $request->get('month');
        } else {
            $month = date('m');
        }

        $firs_day = date('D', mktime(0, 0, 0, $month, 1, $year));
        $last_number = date('t', mktime(0, 0, 0, $month, 1, $year));

//        $day_number = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $where1 = [
            ['stop', '>=', date('Y-m-01', mktime(0, 0, 0, $month, 1, $year))],
            ['start', '<=', date('Y-m-t', mktime(0, 0, 0, $month, 1, $year))],
        ];
        dd($where1);

        $calendar = $this->repository->get(['title', 'stop', 'start'], false, false, $where1, false, ['logo']);
        $events = $this->repository->getWithoutPrems(true, $where, $prems_ids, false, $where_in);
        $calendar = $this->repository->convertStop($calendar);

        $vars = [
            'events' => $events,
            'countries' => Cache::remember('countries', 600, function () {
                return $this->countries->getCountriesSelect();
            }),
            'cities' => $this->cities->citiesSelect(),
            'cats' => Cache::remember('eventCats', 600, function () {
                return $this->cats->catSelect();
            }),
            'organizer' => Cache::remember('organizer', 600, function () {
                return $this->organizer->organizerSelect();
            }),
            'prems' => Cache::remember('prems', 600, function () use ($prems_ids) {
                return $this->repository->getPrems($prems_ids);
            }),
            'children' => $children,
            'calendar' => $calendar,
        ];
        $this->content = view('doc.events.index')->with($vars)->render();
        return $this->renderOutput();
    }
    /**
     * @return bool
     */
    public function getSidebar()
    {
        $this->sidebar = Cache::remember('eventSidebar', 60, function () {
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')]);
            $lasts = $this->repository->get(['title', 'alias', 'created_at'], 2, false, $where, ['created_at', 'desc']);

            $advertising = $this->adv_rep->getSidebar('doc');
            //          most displayed
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs']);
            $articles = $this->a_rep->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);
            return view('doc.events.sidebar')
                ->with(['lasts' => $lasts, 'articles' => $articles, 'advertising' => $advertising])
                ->render();
        });
        return true;
    }
}
