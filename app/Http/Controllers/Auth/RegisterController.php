<?php

namespace Fresh\Estet\Http\Controllers\Auth;

use Fresh\Estet\User;
use Fresh\Estet\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Fresh\Estet\Jobs\SendVerificationEmail;
use Fresh\Estet\Jobs\SendUserAddEmail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'email_token' => str_random(64)
        ]);
    }
    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        dispatch(new SendVerificationEmail($user));
        return view('auth.verification');
    }
    /**
     * Handle a registration request for the application.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token, Request $request)
    {
        $user = User::where('email_token',$token)->first();
        if (!$user) {
            $request->session()->flash('status', 'wrong_token');
            return redirect()->route('resend_activation');
        }
        if (1 == $user->verified) {
            $request->session()->flash('status', 'You are already confirmed');
            return view('auth.emailconfirm');
        }
        $user->verified = 1;
        if($user->save()){
            dispatch(new SendUserAddEmail($user->id));
            $request->session()->flash('status', 'Confirmed');
            return view('auth.emailconfirm', ['status'=>'confirm']);
        }
    }
}
