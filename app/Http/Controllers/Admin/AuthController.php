<?php

namespace App\Http\Controllers\Admin;

use App\Mail\AdminPasswordWarning;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ThrottlesLogins;

    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function login(Request $request)
    {
        $this->user = Auth::user();
        $this->validate($request, [
            'password' => 'required',
        ]);
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        $user = DB::table('admins')->find($this->user->id);
        if(is_null($user))
            return redirect()->back()->with('failed', '您没有管理权限');
        if (Hash::check($request->input('password'), $user->password)) {
            $this->clearLoginAttempts($request);
            $str = str_random(16);
            session(['control' => $str]);
            return redirect('admin')->cookie('control', $str);
        }
        $this->incrementLoginAttempts($request);
        $time = $this->maxAttempts() - $this->limiter()->attempts($this->throttleKey($request));
        if($time == 0) {
            Mail::to($this->user->email)
                ->queue(new AdminPasswordWarning((object)[
                    'user_name' => $this->user->name,
                    'ip' => $request->getClientIp(),
                    'time' =>  date("Y-m-h H:i:s"),
                ]));
            return $this->sendLockoutResponse($request);
        }
        return redirect()->back()->with('failed', '密码错误，你还有'.$time.'次尝试机会.');
    }

    protected function incrementLoginAttempts(Request $request)
    {
        // in 30min reset
        $this->limiter()->hit($this->throttleKey($request) ,30);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
        return redirect()->back()->with('failed', '登录次数过多，请在'.$seconds.'秒后再尝试');
    }

    protected function throttleKey(Request $request)
    {
        return $this->user->email.'|'.$request->ip();
    }

    public function logout(Request $request)
    {
        $request->session()->forget('control');
        $request->cookie('control');
        return redirect('/');
    }
}
