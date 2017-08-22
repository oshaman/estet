<?php

namespace Fresh\Estet\Http\Controllers\Admin\Events;

use Fresh\Estet\Event;
use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Fresh\Estet\Http\Requests\EventRequest;
use Fresh\Estet\Repositories\CitiesRepository;
use Fresh\Estet\Repositories\CountriesRepository;
use Fresh\Estet\Repositories\EventCategoriesRepository;
use Fresh\Estet\Repositories\EventsRepository;
use Fresh\Estet\Repositories\OrganizersRepository;
use Gate;
use Validator;
use Illuminate\Http\Request;

class EventsController extends AdminController
{
    protected $repository;
    /**
     * EventsController constructor.
     */
    public function __construct(EventsRepository $repository)
    {
        $this->template = 'admin.events.index';
        $this->repository = $repository;
    }

    public function show(EventRequest $request)
    {
        if (Gate::denies('UPDATE_EVENTS')) {
            abort(404);
        }

        $data = $request->except('_token');
        if (!empty($data['param'])) {
            $data['value'] = $data['value'] ?? null;
            switch ($data['param']) {
                case 1:
                    $events[] = $this->repository->one($data['value']);
                    break;
                case 2:
                    $events = $this->repository->get(['id', 'title', 'start', 'stop'], false, true, ['organizer_id', $data['value']]);
                    if ($events) $events->appends(['param' => $data['param'], 'value' => $data['value']])->links();
                    break;
                case 3:
                    $events = $this->repository->get(['id', 'title', 'start', 'stop'], false, true, ['cat_id', $data['value']]);
                    if ($events) $events->appends(['param' => $data['param'], 'value' => $data['value']])->links();
                    break;
                default:
                    $events = $this->repository->get(['id', 'title', 'start', 'stop'], false, true, false, ['created_at', 'desc']);
                    if ($events) $events->appends(['param' => $data['param']])->links();
            }
        } else {
            $events = $this->repository->get(['id', 'title', 'start', 'stop'], false, true, false, ['created_at', 'desc']);
        }

        $this->content = view('admin.events.show')->with('events', $events)->render();
        return $this->renderOutput();
    }

    public function create(
        EventCategoriesRepository $cat_rep,
        OrganizersRepository $org_rep,
        CitiesRepository $city_rep,
        CountriesRepository $country_rep,
        EventRequest $request
    ) {
        if (Gate::denies('UPDATE_EVENTS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->repository->addEvent($request);

            if(is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result);
            }
            return redirect()->route('events_admin')->with($result);
        }

        $cats = $cat_rep->catSelect();
        $organizers = $org_rep->organizerSelect();
        $countries = $country_rep->getCountriesSelect();
        $cities = $city_rep->citiesSelect();

        $this->content = view('admin.events.create')->with(['cats' => $cats, 'organizers' => $organizers, 'countries' => $countries, 'cities' => $cities])->render();
        return $this->renderOutput();
    }

    public function destroy($event)
    {
        if (Gate::denies('UPDATE_EVENTS')) {
            abort(404);
        }
        $result = $this->repository->deleteEvent($event);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('events_admin')->with($result);
    }

    public function edit(
        EventCategoriesRepository $cat_rep,
        OrganizersRepository $org_rep,
        CitiesRepository $city_rep,
        CountriesRepository $country_rep,
        EventRequest $request,
        $event
    )
    {
        if (Gate::denies('UPDATE_EVENTS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->repository->updateEvent($request, $event);

            if(is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result);
            }
            return redirect()->route('events_admin')->with($result);
        }
//$this->repository->delSlider(26);
        $cats = $cat_rep->catSelect();
        $organizers = $org_rep->organizerSelect();
        $countries = $country_rep->getCountriesSelect();
        $cities = $city_rep->citiesSelect();

        $logo = $event->logo;
        $slider = $event->slider;

        $event->seo = $this->repository->convertSeo($event->seo);

        $this->content = view('admin.events.update')
                ->with(['cats' => $cats, 'organizers' => $organizers, 'countries' => $countries, 'cities' => $cities,
                    'logo' => $logo, 'slider' => $slider, 'event' => $event])
                ->render();
        return $this->renderOutput();
    }


    public function slider(Request $request)
    {
        if (Gate::denies('UPDATE_EVENTS')) {
            abort(404);
        }
        $validator = Validator::make($request->all(),[
            'slider_id' => 'integer|required',
        ]);

        if($validator->fails()) {
            return \Response::json(['error'=>$validator->errors()->all()]);
        }

        $result = $this->repository->delSlider($request->get('slider_id'));

        return \Response::json($result);
    }
}
