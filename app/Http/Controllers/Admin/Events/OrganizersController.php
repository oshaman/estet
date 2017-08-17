<?php

namespace Fresh\Estet\Http\Controllers\Admin\Events;

use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Fresh\Estet\Http\Requests\OrganizersRequest;
use Fresh\Estet\Repositories\OrganizersRepository;
use Gate;

class OrganizersController extends AdminController
{
    protected $org_rep;

    public function __construct(OrganizersRepository $rep)
    {
        $this->template = 'admin.events.index';
        $this->org_rep = $rep;
    }

    /**
     * View or Create Organizers
     * @param Request $request
     * @return View
     */
    public function show(OrganizersRequest $request)
    {
        if (Gate::denies('UPDATE_EVENTS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->org_rep->addOrganizer($request);

            if ($result) {
                return back()->with(['status'=>'Новый организатор добавлен.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка добавления организатора, повторите попытку позже.']);
            }

        }

        $organizers = $this->org_rep->get(['name', 'id', 'alias', 'parent'], false, true);
        $this->content = view('admin.events.organizer.content')->with('organizers', $organizers);

        return $this->renderOutput();
    }

    /**
     * Category update
     * @param Request $request
     * @param $organizer Instance of Organizer
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(OrganizersRequest $request, $organizer)
    {
        if (Gate::denies('UPDATE_EVENTS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->org_rep->updateOrganizer($request, $organizer);

            if(is_array($result) && !empty($result['error'])) {
                return redirect()->back()->withErrors($result['error'])->withInput();
            }

            if ($result) {
                return redirect()->route('organizers_admin')->with(['status'=>'Организатор обновлен.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка изменения организатора, повторите попытку позже.']);
            }
        }

        $this->content = view('admin.events.organizer.edit')->with('organizer', $organizer);
        return $this->renderOutput();
    }
}
