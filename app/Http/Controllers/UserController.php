<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Validator;

class UserController extends Controller
{
    public function userInfo($name)
    {
        $user = DB::table('users')->select('id')->where('name', $name)->first();
        if (is_null($user)) {
            return;
        }
        $userInfo = DB::table('user_infos')->where('id', $user->id)->first();
        $user = (object)array_merge((array)$userInfo, (array)$user);
        $user->name = $name;
        $solveds = DB::table('oj_solved_problems')
            ->select(['problem_id', 'submitted', 'accepted'])
            ->where('user_id', $user->id)->get();
        return view('user.userInfo', ['user' => $user, 'solveds' => $solveds]);
    }

    public function changeUserInfoPage()
    {
        $user = Auth::user();
        $userInfo = DB::table('user_infos')->where('id', $user->id)->first();
        return view('user.change', ['user' => $user, 'info' => $userInfo]);
    }

    public function changeUserInfo(Request $request)
    {
        $name = $request->input('name');
        $old = $request->input('old');
        $password = $request->input('password');
        $school = $request->input('school');
        $motto = $request->input('motto');
        $fail = '';
        $user = Auth::user();
        if ($name != $user->name) {
            if (Validator::make($request->all(), [
                'name' => 'required|string|max:20|unique:users',
            ])->fails()
            ) {
                $fail = '用户名已被使用';
            }
        }
        if ($old) {
            if (Hash::check($old, $user->password)) {
                if (strlen($password) < 6) {
                    $fail = '新密码过短';
                }
                if ($password != $request->input('password_confirmation')) {
                    $fail = '两次密码输入不同';
                }
            } else $fail = '旧密码不匹配';
        } else if ($password) {
            $fail = '请输入旧密码';
        }
        if ($motto && strlen($motto) > 255) {
            $fail = 'quote过长。请在255字内';
        }
        if ($fail != '') {
            return response()->json(['failed' => $fail]);
        }
        $newUser = [];
        if (Auth::user()->name != $name) {
            $newUser['name'] = $name;
        }
        if ($old && $password) {
            $newUser['password'] = $password;
        }
        if ($newUser != [])
            DB::table('users')->where('id', $user->id)->update($newUser);
        if ($school) $newInfo['school'] = $school;
        if ($motto) $newInfo['motto'] = $motto;
        DB::table('user_infos')->where('id', $user->id)->update($newInfo);
        return response()->json('success');
    }

    public function broker()
    {
        return Password::broker();
    }

    public function confirmEmail($token, $email) {
        $user = User::where('email', $email)->first();
        $t = DB::table('password_resets')->where('email', $email)->first();
        if($t && Hash::check($token, $t->token)) {
            $user->locked = ($user->locked | 1) ^ 1;
            DB::table('users')->where('email', $email)->update(['locked' => $user->locked]);
            $this->broker()->deleteToken($user);
            Auth::guard()->login($user);
        }
        return redirect('/');
    }
}
