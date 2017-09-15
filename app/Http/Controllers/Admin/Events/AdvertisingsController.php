<?php

namespace Fresh\Estet\Http\Controllers\Admin\Events;

use Fresh\Estet\Eadv;
use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Fresh\Estet\Repositories\EventsRepository;
use Illuminate\Http\Request;
use Gate;

class AdvertisingsController extends AdminController
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

    /**
     * @return $this
     */
    public function show()
    {
        if (Gate::denies('UPDATE_ADVERTISING')) {
            abort(404);
        }

        $advertisings = $this->repository->getAd();
        $this->content = view('admin.events.ad.show')->with(['advertisings' => $advertisings])->render();
        return $this->renderOutput();
    }

    /**
     * @param Request $request
     * @param Eadv $advertising
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, Eadv $advertising)
    {
        if (Gate::denies('UPDATE_ADVERTISING')) {
            abort(404);
        }
        if ($request->isMethod('post')) {

            $result = $this->repository->updateAdvertising($request, $advertising);

            if (is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result['error']);
            }
            return redirect()->route('create_events_slider')->with($result);
        }

        $this->content = view('admin.events.ad.edit')->with(['advertising' => $advertising])->render();
        return $this->renderOutput();

    }

    public function del(Eadv $advertising)
    {
        if (Gate::denies('UPDATE_ADVERTISING')) {
            abort(404);
        }

        $result = $this->repository->delAdvertising($advertising);

        if (is_array($result) && !empty($result['error'])) {
            return back()->withErrors($result['error']);
        }
        return redirect()->route('create_events_slider')->with($result);
    }
}
