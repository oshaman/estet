<?php

namespace Fresh\Estet\Http\Controllers;

use Auth;
use Fresh\Estet\Http\Requests\TmpPersonRequest;
use Fresh\Estet\Repositories\TmpPersonRepository;
use Fresh\Estet\Jobs\SendUserAddEmail;
use Fresh\Estet\Repositories\PersonsRepository;

class ProfileController extends Controller
{
    protected $tmp_rep;
    protected $person_rep;

    public function __construct(TmpPersonRepository $tmp_rep, PersonsRepository $pers)
    {
        $this->tmp_rep = $tmp_rep;
        $this->person_rep = $pers;
    }

    /**
     *
     * @return view profile
     */
    public function index ()
    {
        $user = Auth::user();
        $id = $user->id;
        $tmp = $this->tmp_rep->findByUserId($id);
        $person = $this->person_rep->findByUserId($id);

        if ($tmp && !empty($tmp->expirience)) {
            $tmp->expirience = date_create()->diff(date_create($tmp->expirience))->y;
        } elseif ($person && !empty($person->expirience)) {
            $person->expirience = date_create()->diff(date_create($person->expirience))->y;
        }

        if ($tmp) {
            $tmp->email = $user->email;
        } elseif ($person) {
            $person->email = $user->email;
        }

        return view('profile.index')->with(['profile' => $tmp, 'person' => $person]);
    }

    /**
     * update or create user's profile
     * @param TmpPersonRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update (TmpPersonRequest $request)
    {
        $id = Auth::user()->id;
        if ($request->isMethod('post')) {

            if ($request->request->has('month') && $request->request->has('year')) {
                $month = $request->request->get('month');
                $year = $request->request->get('year');
                if (($month < 1 || $month > 12) || (($year < 1970 || $month > 2020))) {
                    return back()->withErrors(['Ошибка в поле Дата'])->withInput();
                }
                $exp = date("Y-m-d H:i:s", strtotime($year . '-' . str_pad((int)$month, 2, 0, STR_PAD_LEFT) . '-01'));

                $request->request->add(['expirience'=>$exp]);
            }

            $result = $this->tmp_rep->update($request);
            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }
            dispatch(new SendUserAddEmail($id));
            $request->session()->flash('status', $result);
            return redirect('profile');
        }


        $sql = $this->tmp_rep->findByUserId($id);
        if ($sql && $sql->expirience) {
            $sql->month = (int)date('m', strtotime($sql->expirience));
            $sql->year = (int)date('Y', strtotime($sql->expirience));
        }

        return view('profile.edit')->with('profile', $sql);

    }
}
