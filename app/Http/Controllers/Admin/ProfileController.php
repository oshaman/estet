<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Fresh\Estet\TmpPerson;
use Fresh\Estet\Person;
use Fresh\Estet\Repositories\TmpPersonRepository;
use Fresh\Estet\Repositories\PersonsRepository;
use Gate;
use Config;
use Fresh\Estet\Specialty;
use Illuminate\View\View;

class ProfileController extends AdminController
{
    protected $tmp_rep;
    protected $pers_rep;

    public function __construct(TmpPersonRepository $rep, PersonsRepository $pers)
    {
        $this->tmp_rep = $rep;
        $this->pers_rep = $pers;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            dd($request);
        }



        $profiles = $this->tmp_rep->get(['name', 'lastname', 'phone', 'specialty', 'user_id'], false, true);

        $this->content = view('admin.profiles.index')->with('profiles', $profiles)->render();
        return $this->renderOutput();
    }

    /**
     * UPDATE or CREATE PROFILE by MODERATOR
     * @param Request $request
     * @param null $id
     * @return result
     */
    public function edit (Request $request, $id = null)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $request->request->set('user_id', session('user_id'));
            $request->request->set('photo', session('photo'));
//            формирование поля expirience
            if ($request->request->has('month') && $request->request->has('year')) {
                $month = $request->request->get('month');
                $year = $request->request->get('year');
                if (($month < 1 || $month > 12) || (($year < 1970 || $month > 2020))) {
                    return back()->withErrors(['Ошибка в поле Дата'])->withInput();
                }
                $exp = date("Y-m-d H:i:s", strtotime($year . '-' . str_pad((int)$month, 2, 0, STR_PAD_LEFT) . '-01'));

                $request->request->add(['expirience'=>$exp]);
            }

            if (!session('user_id')) {
                return back()->withErrors('Ошибка получения данных профиля');
            }

            $person = $this->pers_rep->findByUserId(session('user_id'));
            if ($person) {
                $result = $this->pers_rep->updatePerson($request, $person);
                return redirect(route('admin_profile'))->with($result);

            } else {
                $result = $this->pers_rep->createPerson($request);
                return redirect(route('admin_profile'))->with($result);
            }
        }

//        View Form

        $this->title = 'Редактирование профиля';

        $person = $this->pers_rep->findByUserId($id);

        $spec = $this->getSpecialties()->reduce(function ($returnSpec, $spec) {
            $returnSpec[$spec->id] = $spec->name;
            return $returnSpec;
        }, []);

        $profile = $this->tmp_rep->findByUserId($id);

        if (!$profile && !$person) {
            abort(404);
        }
        if ($profile->expirience) {
            $profile->month = (int)date('m', strtotime($profile->expirience));
            $profile->year = (int)date('Y', strtotime($profile->expirience));
        }

        $request->session()->put('user_id', $profile->user_id);
        $request->session()->put('photo', $profile->photo);
//        dd($profile);

        $this->content = view('admin.profiles.edit')->with(['title'=>$this->title, 'profile'=>$profile, 'specialties'=>$spec, 'person'=>$person])->render();
        return $this->renderOutput();
    }

    public function getSpecialties()
    {
        return Specialty::all();
    }
}
