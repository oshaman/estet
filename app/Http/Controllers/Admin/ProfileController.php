<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Fresh\Estet\Repositories\TmpPersonRepository;
use Fresh\Estet\Repositories\PersonsRepository;
use Gate;
use Config;
use Fresh\Estet\User;
use Illuminate\View\View;
use Fresh\Estet\Http\Requests\EditPerson;
use Fresh\Estet\Repositories\ProfieRepository;

class ProfileController extends AdminController
{
    protected $tmp_rep;
    protected $pers_rep;

    public function __construct(TmpPersonRepository $rep, PersonsRepository $pers, ProfieRepository $profile)
    {
        $this->tmp_rep = $rep;
        $this->pers_rep = $pers;
        $this->profile_rep = $profile;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(EditPerson $request)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $data = $request->except('_token');
//            dd($data);
            if (1 == $data['param']) {
                if (!$profiles = $this->pers_rep->get(['name', 'lastname', 'phone', 'user_id'], false, true, ['lastname', $data['value']])) {
                    $profiles = null;
                }
            } elseif (2 == $data['param']) {

                if ($profile = $this->pers_rep->one($data['value'])) {
                    $profiles[0] = $profile;
                } else {
                    $profiles = null;
                }
            } elseif (3 == $data['param']) {
                if ($profile = $this->pers_rep->findByUserId($data['value'])) {
                    $profiles[0] = $profile;
                } else {
                    $profiles = null;
                }
            } else {
                $profiles = $this->pers_rep->get(['name', 'lastname', 'phone', 'user_id'], false, true);
            }
            $this->content = view('admin.profiles.index')->with('profiles', $profiles)->render();
            return $this->renderOutput();
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
    public function edit (EditPerson $request, User $user)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $request->request->set('user_id', session('user_id'));
            if (!empty(session('photo'))) {
                $request->request->set('photo', session('photo'));
            }
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
                $result = $this->pers_rep->updatePerson($request, $person, $user);
                $res = $this->tmp_rep->deleteTmp(session('user_id'));
                $request->session()->forget('photo');
                $request->session()->forget('user_id');
                return redirect(route('admin_profile'))->with($result, $res);

            } else {
                $result = $this->pers_rep->createPerson($request, $user);
                $res = $this->tmp_rep->deleteTmp(session('user_id'));
                $request->session()->forget('photo');
                $request->session()->forget('user_id');
                return redirect(route('admin_profile'))->with($result, $res);
            }
        }

//        View Form

        if (empty($user->id)) {
            abort(404);
        }

        $this->title = 'Редактирование профиля';

        $person = $this->pers_rep->findByUserId($user->id);

        $profile = $this->profile_rep->getProfile($user, true);

        $spec = $this->profile_rep->getSpecialties();

        $request->session()->put('user_id', $profile->user_id);

        if ($this->profile_rep->isAuthor($user)) {
            $profile->confirmed = true;
        }
        // если юзер добавил новую
        if (!empty($profile->photo)) {
            if (empty($person) || ($profile->photo != $person->photo)) {
                $request->session()->put('photo', $profile->photo);
            }
        }

        $this->content = view('admin.profiles.edit')->with(['title'=>$this->title, 'profile'=>$profile, 'specialties'=>$spec, 'person'=>$person])->render();
        return $this->renderOutput();
    }
}
