<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/10
 * Time: 19:21
 */

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class ReturnController extends Controller {
    public function index(){
        $data = DB::table('borrows')
            ->join('users', 'users.id', '=', 'borrows.user_id')
            ->join('books', 'books.id', '=', 'borrows.book_id')
            ->Where('borrows.return_date', '<=',date('Y-m-d'))
            ->orWhere('borrows.time_limit', '<',date('Y-m-d'))
            ->select('borrows.*', 'users.*', 'books.*', 'users.name as username', 'borrows.id as borrow_id')
            ->get();
        return view('admin.return.index', [
            'returns' => $data
        ]);
    }

    public function delete($id){
        $status = DB::table('borrows')
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