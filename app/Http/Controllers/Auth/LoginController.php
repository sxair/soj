<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request)
    {
        if($request->has('to')) {
            session(['url.intended' => urldecode($request->input('to'))]);
        } else if(url()->current() != url()->previous()){
            session(['url.intended' => url()->previous()]);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
//            if($user->locked == 1) {
//                $this->guard()->logout();
//                return redirect()->back();
//            } else if($user->locked){
//                $this->guard()->logout();
//                return redirect()->back();
//            }
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request)
    {
        if(strrchr($request->input('email'), '@')) {
            return $this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            );
        }
        return $this->guard()->attempt(
            ['name' => $request->input('email'), 'password' => $request->input('password')],
            $request->filled('remember')
        );
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->back();
    }
}
