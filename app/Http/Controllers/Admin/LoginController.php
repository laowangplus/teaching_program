<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/10
 * Time: 22:49
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Service\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller {
    public function index(){
        return view('admin.login.index');
    }

    public function check(Request $request){
        $data = $request->post();
        $this->validate($request, [
            'captcha' => 'required|captcha'
        ], [
            'captcha' => '验证码错误',
        ]);
        $data = DB::table('users')
            ->where('tearcher_no', '=', $data['username'])
            ->where('password', '=', md5($data['password']))
            ->select()
            ->first();
        if (!empty($data)){
            Session::put([
                'tearcher_name' => $data->tearcher_name,
                'id' => $data->id,
                'tearcher_no' => $data->tearcher_no,
                'jurisdiction' => $data->jurisdiction,
                'message_count' => (new Message())->getCount($data->id),
            ]);
            return \Response::json([
                'code' => 0,
                'msg'  => "登陆成功"
            ], 200);
        }else{
            return \Response::json([
                'code' => 1,
                'msg'  => "用户名或者密码错误"
            ], 200);
        }
    }

    public function logout(){
        Session::pull('id');
        return Redirect::to('login');
    }
}