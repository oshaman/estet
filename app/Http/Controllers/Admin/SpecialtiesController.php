<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Fresh\Estet\Http\Controllers\Admin\AdminController;
//use Fresh\Estet\Specialty;
use Validator;
use Fresh\Estet\Repositories\SpecialtiesRepository;
use Gate;

class SpecialtiesController extends AdminController
{
    protected $spec_rep;

    public function __construct(SpecialtiesRepository $rep)
    {
        $this->spec_rep = $rep;
    }

    /**
     * View or Create Specialties
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'spec' => 'unique:specialties,name|required|alpha_dash|between:5, 32',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $result = $this->spec_rep->addSpec($request);

            if ($result) {
                return back()->with(['status'=>'Новая специальность добавлена.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка добавления специальности, повторите попытку позже.']);
            }

        }

        $spec = $this->spec_rep->get(['name', 'id'], false, true);
        $this->content = view('admin.specialties.content')->with('specialties', $spec);

        return $this->renderOutput();
    }

    /**
     * Specialty update
     * @param Request $request
     * @param $spec spec_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $spec)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'spec' => 'unique:specialties,name|required|alpha_dash|between:5, 32',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $result = $this->spec_rep->updateSpec($request, $spec);
            if ($result) {
                return back()->with(['status'=>'Cпециальность обновлена.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка изменения специальности, повторите попытку позже.']);
            }
        }

        $specialty = $this->spec_rep->findById($spec);

        $this->content = view('admin.specialties.edit')->with('specialty', $specialty);
        return $this->renderOutput();
    }
}
