<?php

namespace App\Http\Controllers\Admin;

use App\Mail\AddAdmin;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mail;

class AdminController extends Controller
{
    public function help($title) {
        $content = DB::table('soj_helps')->where('name', 'admin.'.$title)->first();
        return view('admin.help', ['content' => $content]);
    }

    public function addAdmin(Request $request) {
        $name = $request->input('name');
        $email = $request->input('email');
        $type = (int)$request->input('type');
        if($name && $email && $type >= 1 && $type <= 3) {
            $new = DB::table('users')->where(['name' => $name, 'email' => $email])->first();
            if($new == null) {
                return response()->json(['failed' => '管理员不存在']);
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
                    'type' => $type
                ]));
            return response()->json(['success' => '添加成功，请让新管理员查收邮件']);
        }
        return response()->json(['failed' => '请填入新管理员用户名和注册邮箱']);
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
