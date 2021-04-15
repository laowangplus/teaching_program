<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/10
 * Time: 19:25
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Request;

class UserController extends Controller {
    public function index() {
        $data = DB::table('users')
            ->select()
            ->get()
            ->toArray();
        return view('admin.user.index', [
            'users' => $data
        ]);
    }

    public function personal() {
        $data = DB::table('users')
            ->where('id', '=', Session::get('id'))
            ->select()
            ->first();
        return view('admin.user.personal', [
            'user' => $data
        ]);
    }

    public function personal_update($id) {
        try {
            $data = Request::post();
            DB::table('users')
                ->where('id', '=', $id)
                ->where('password', '=', $data['old_password'])
                ->update([
                    "tearcher_name"            => $data['name'],
                    "tearcher_no"           => $data['number'],
                    "academy"             => $data['academy'],
                    "password"             => $data['password'],
                    "updated_at" => date("Y-m-d H:i:s"),
                ]);
            return \Response::json([
                'code' => 0,
                'msg'  => "修改成功"
            ], 200);
        }catch (\Exception $e){
            return \Response::json([
                'code' => 0,
                'msg'  => "修改异常"
            ], 400);
        }
    }

    public function add() {
        return view('admin.user.add');
    }

    public function create() {
        try {
            $data = Request::post();
            $user = DB::table('users')
                ->where('tearcher_no', '=', $data['number'])
                ->select()
                ->count();
            if ($user > 0){
                return \Response::json([
                    'code' => 1,
                    'msg'  => "用户已注册，请勿重复操作"
                ], 200);
            }
            DB::table('users')
                ->insert([
                    "tearcher_name"            => $data['name'],
                    "tearcher_no"           => $data['number'],
                    "academy"             => $data['academy'],
                    "jurisdiction"             => $data['jurisdiction'],
                    "password" => md5($data['password']),
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                ]);
            return \Response::json([
                'code' => 0,
                'msg'  => "注册成功"
            ], 200);
        }catch (\Exception $e){
            return \Response::json([
                'code' => 0,
                'msg'  => "注册异常"
            ], 400);
        }
    }

    public function edit($id){
        $data = DB::table('users')
            ->where('id', '=', $id)
            ->first();
        return view('admin.user.edit', [
            'user' => $data
        ]);
    }

    public function update($id){
        try {
            $data = Request::post();
            DB::table('users')
                ->where('id', '=', $id)
                ->update([
                    "tearcher_name"            => $data['name'],
                    "tearcher_no"           => $data['number'],
                    "academy"             => $data['academy'],
                    "jurisdiction"             => $data['jurisdiction'],
                    "updated_at" => date("Y-m-d H:i:s"),
                ]);
            return \Response::json([
                'code' => 0,
                'msg'  => "修改成功"
            ], 200);
        }catch (\Exception $e){
            return \Response::json([
                'code' => 0,
                'msg'  => "修改异常"
            ], 400);
        }
    }

    public function show($id){
        $data = DB::table('borrows')
            ->join('users', 'users.id', '=', 'borrows.user_id')
            ->join('books', 'books.id', '=', 'borrows.book_id')
            ->Where('borrows.user_id', '=', $id)
            ->select('borrows.*', 'users.*', 'books.*', 'users.name as username', 'borrows.id as borrow_id')
            ->get();
        return view('admin.user.show', [
            'borrows' => $data
        ]);
    }

    public function delete($id){
        $status = DB::table('users')
            ->delete($id);
        if ($status == 1){
            return \Response::json([
                'code' => 0,
                'msg'  => "删除成功"
            ], 200);
        }else{
            return \Response::json([
                'code' => 1,
                'msg'  => "删除失败，请勿重复操作"
            ], 200);
        }
    }
}