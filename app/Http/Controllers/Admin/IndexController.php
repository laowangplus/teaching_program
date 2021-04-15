<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/10
 * Time: 19:18
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller {
    public function index() {
        return view('admin.index.index');
    }

    public function welcome(){
        return view('admin.index.welcome');
    }

    public function error(){
        return view('admin.public.error');
    }

    public function api_error(){
        return \Response::json([
            'code' => 1,
            'msg'  => "权限不足"
        ], 400);
    }
}