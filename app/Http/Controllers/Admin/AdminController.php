<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/12
 * Time: 22:46
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class AdminController extends Controller {
    public function index() {
        $data = DB::table('admins')
            ->get();
        return view('admin.admin.index', [
            'admins' => $data
        ]);
    }

    public function add() {
        return view('admin.admin.add');
    }

    public function create() {
        try {
            $data = Request::post();
            $user = DB::table('admins')
                ->where('number', '=', $data['number'])
                ->orWhere('phone', '=', $data['phone'])
                ->orWhere('name', '=', $data['name'])
                ->select()
                ->count();
            if ($user > 0) {
                return \Response::json([
                    'code' => 1,
                    'msg'  => "管理员信息重复，请勿重复操作"
                ], 200);
            }
            DB::table('admins')
                ->insert([
                    "name"         => $data['name'],
                    "phone"        => $data['phone'],
                    "sex"          => $data['sex'],
                    "age"          => $data['age'],
                    "password"     => md5($data['password']),
                    "number"       => $data['number'],
                    "jurisdiction"      => $data['jurisdiction'],
                ]);
            return \Response::json([
                'code' => 0,
                'msg'  => "添加成功"
            ], 200);
        } catch (\Exception $e) {
            return \Response::json([
                'code' => 0,
                'msg'  => "添加异常"
            ], 400);
        }
    }

    public function edit($id) {
        $data = DB::table('admins')
            ->where('id', '=', $id)
            ->first();
        return view('admin.admin.edit', [
            'admin' => $data
        ]);
    }

    public function update($id) {
        try {
            $data = Request::post();
            DB::table('admins')
                ->where('id','=',$id)
                ->update([
                    "name"         => $data['name'],
                    "phone"        => $data['phone'],
                    "sex"          => $data['sex'],
                    "age"          => $data['age'],
                    "password"     => md5($data['password']),
                    "number"       => $data['number'],
                    "jurisdiction"      => $data['jurisdiction'],
                ]);
            return \Response::json([
                'code' => 0,
                'msg'  => "修改成功"
            ], 200);
        } catch (\Exception $e) {
            return \Response::json([
                'code' => 0,
                'msg'  => "修改异常"
            ], 400);
        }
    }

    public function delete($id){
        $status = DB::table('admins')
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