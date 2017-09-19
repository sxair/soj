<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Control
{
    protected $user;
    public function __construct()
    {
        $this->user = Auth::guard(null)->user();
    }

    public function handle($request, Closure $next)
    {
        if(is_null($this->user)) {
            return redirect('login');
        }
        if($this->user->control & config('soj.control.control')) {
            if(session()->has('control') && session('control') == $request->cookie('control')) {
                return $next($request);
            }
        }
        return redirect('/control/login');
    }
}
