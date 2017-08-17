<?php

namespace Fresh\Estet\Http\Controllers\Admin\Events;

use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Fresh\Estet\Http\Requests\EventRequest;
use Fresh\Estet\Repositories\CitiesRepository;
use Fresh\Estet\Repositories\CountriesRepository;
use Fresh\Estet\Repositories\EventCategoriesRepository;
use Fresh\Estet\Repositories\EventsRepository;
use Fresh\Estet\Repositories\OrganizersRepository;
use Gate;

class EventsController extends AdminController
{
    /**
     * EventsController constructor.
     */
    public function __construct(EventsRepository $repository)
    {
        $this->template = 'admin.events.index';
        $this->repository = $repository;
    }

    public function show()
    {
        if (Gate::denies('UPDATE_EVENTS')) {
            abort(404);
        }


        $this->content = view('admin.events.show')->render();
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

    public function edit()
    {
        if (Gate::denies('UPDATE_EVENTS')) {
            abort(404);
        }
        dd('del');
    }
}
