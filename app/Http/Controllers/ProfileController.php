<?php

namespace Fresh\Estet\Http\Controllers;

use Auth;
use Fresh\Estet\Http\Requests\TmpPersonRequest;
use Fresh\Estet\Jobs\SendUserAddEmail;
use Fresh\Estet\Repositories\ProfieRepository;

class ProfileController extends Controller
{

    protected $profile_rep;

    public function __construct(ProfieRepository $rep)
    {
        $this->profile_rep = $rep;
    }

    /**
     *
     * @return view profile
     */
    public function index ()
    {
        $user = Auth::user();

        $profile = $this->profile_rep->getProfile($user);


        return view('profile.index')->with(['profile' => $profile]);
    }

    /**
     * update or create user's profile
     * @param TmpPersonRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update (TmpPersonRequest $request)
    {
        $user = Auth::user();
        if ($request->isMethod('post')) {

            $result = $this->profile_rep->updateProfile($request);

            if(is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result)->withInput();
            }
            dispatch(new SendUserAddEmail($user->id));
            $request->session()->flash('status', $result);
            return redirect('profile');
        }

        $profile = $this->profile_rep->getProfile($user, true);

        return view('profile.edit')->with('profile', $profile);

    }
}
