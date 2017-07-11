<?php

namespace Fresh\Estet\Http\Controllers;

use Auth;
use Fresh\Estet\Http\Requests\TmpPersonRequest;
use Fresh\Estet\Repositories\TmpPersonRepository;
use Fresh\Estet\Jobs\SendUserAddEmail;

class ProfileController extends Controller
{
    protected $tmp_rep;

    public function __construct(TmpPersonRepository $tmp_rep)
    {
        $this->tmp_rep = $tmp_rep;
    }

    /**
     *
     * @return view profile
     */
    public function index ()
    {
        $user = Auth::user();
        $id = $user->id;
        $sql = $this->tmp_rep->findByUserId($id);
        if ($sql) {
            $sql->email = $user->email;
        }
        return view('profile.index')->with('profile', $sql);
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

            $result = $this->tmp_rep->update($request);

            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }
            dispatch(new SendUserAddEmail($id));
            $request->session()->flash('status', $result);
            return redirect('profile');
        }


        $sql = $this->tmp_rep->findByUserId($id);

        return view('profile.edit')->with('profile', $sql);

    }
}
