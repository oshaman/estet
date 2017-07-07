<?php

namespace Fresh\Estet\Http\Controllers\Auth;

use Fresh\Estet\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $decayMinutes = 30;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        Session::put('backUrl', URL::previous());
    }

    protected function authenticated($request=null, $user)
    {

        if($user->hasRole('admin') || $user->hasRole('moderator')) {
            return redirect('admin');
        }
        return redirect(Session::get('backUrl') ? Session::get('backUrl') :   'home');
    }

    protected function credentials(Request $request)
    {
//        return $request->only($this->username(), 'password');
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'verified' => 1];
    }
}
