<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HaveControl
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    public function handle($request, Closure $next)
    {
        if(is_null($this->user)) {
            return redirect('login');
        }
        if($this->user->control & config('soj.admin.control')) {
            return $next($request);
        }
        return redirect('/');
    }
}
