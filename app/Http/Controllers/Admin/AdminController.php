<?php

namespace App\Http\Controllers\Admin;

use App\Mail\AddAdmin;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController as Controller;
use Illuminate\Support\Facades\DB;
use Mail;

class AdminController extends Controller
{
    public function help($title) {
        if(view()->exists('admin.help.'.$title)) {
            return view('admin.help.'.$title);
        }
        return '';
    }

    public function admins(Request $request) {
        $page = getCurrentPage($request->input('page'));
        $perPage = 50;
        $total = DB::table('admins')->count();
        $admins = DB::table('admins')
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->join('users', 'admins.id', '=', 'users.id')
            ->select('users.name', 'admins.id','admins.presenter_name','admins.remark')
            ->get();
        return response()->json(array_merge(['content' => $admins], ['total' => $total]));
    }

    public function addAdmin(Request $request) {
        $name = $request->input('name');
        $email = $request->input('email');
        $type = (int)$request->input('type');
        if($this->isStudent()) {
            return response()->json(['failed' => '你没有权限']);
        }
        if($name && $email && $type >= 1 && $type <= 3) {
            if($this->isTeacher() && $type != config('soj.admin.student')) {
                return response()->json(['failed' => '教师只能添加学生管理员']);
            }
            $new = DB::table('users')->where(['name' => $name, 'email' => $email])->first();
            if($new == null) {
                return response()->json(['failed' => '用户不存在']);
            }
            if(DB::table('admins')->where(['id' => $new->id])->first() != null) {
                return response()->json(['failed' => '管理员已存在']);
            }
            $pass = str_random(6);
            DB::table('admins')->insert([
                'id' => $new->id,
                'presenter_name' => Auth::user()->name,
                'password' => bcrypt($pass),
                'remark' => $request->input('remark') ? $request->input('remark') : ''
            ]);
            DB::table('users')->where(['name' => $name, 'email' => $email])->update([
                'control' => config('soj.admin_map')[$type]
            ]);
            Mail::to($email)
                ->queue(new AddAdmin((object)[
                    'name' => $name,
                    'presenter_name' => Auth::user()->name,
                    'password' => $pass,
                    'type' => $type
                ]));
            return response()->json(['success' => '添加成功，请让新管理员查收邮件']);
        }
        return response()->json(['failed' => '请填入新管理员用户名和注册邮箱']);
    }

    public function delAdmin(Request $request) {
        $id = $request->input('id');
        if($id == null) {
            abort(404);
        }
        $control = Auth::user()->control;
        $user = DB::table('users')->where(['id' => $id])->first();
        if($user->id == Auth::user()->id) {
            return response()->json(['failed' => '别闹了~']);
        }
        if($user == null) return response()->json(['failed' => '管理员不存在']);
        if(
            ($control & config('soj.admin.student')) ||
            (($control & config('soj.admin.teacher')) && ($user->control & config('soj.admin.teacher'))) ||
            (($control & config('soj.admin.teacher')) && ($user->control & config('soj.admin.all')))
        ) {
            return response()->json(['failed' => '权限不够']);
        }
        if(DB::table('admins')->delete(['id' => $id])) {
            return response()->json(['success' => '删除成功']);
        }
        return response()->json(['failed' => '管理员不存在']);
    }

    public function changePassword(Request $request) {
        $pass = $request->input('password');
        $old = DB::table('admins')->where(['id' => Auth::user()->id])->first();
        if($old == null || !Hash::check($request->input('old_password'), $old->password)) {
            return response()->json(['failed' => '密码输入错误']);
        }
        if($pass != null && strlen($pass) >= 6) {
            if($pass != $request->input('password_confirmation')) {
                return response()->json(['failed' => '两次密码不相同']);
            }
            DB::table('admins')->where(['id' => Auth::user()->id])->update(['password' => Hash::make($pass)]);
            return response()->json(['success' => '更改成功']);
        }
        return response()->json(['failed' => '新密码过短']);
    }
}
