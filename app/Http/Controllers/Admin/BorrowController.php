<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/10
 * Time: 19:14
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller {
    public function index() {
        $data = DB::table('borrows')
            ->join('users', 'users.id', '=', 'borrows.user_id')
            ->join('books', 'books.id', '=', 'borrows.book_id')
            ->Where('borrows.return_date', '=', null)
            ->where('borrows.time_limit', '>', date('Y-m-d'))
            ->where('lose', '=', 0)
            ->select('borrows.*', 'users.*', 'books.*', 'users.name as username', 'borrows.id as borrow_id')
            ->get();
        return view('admin.borrow.index', [
            'borrows' => $data
        ]);
    }

    public function borrow_return($id, $book_id) {
        $status = DB::table('borrows')->where('id', '=', $id)
            ->first();
        if ($status->return_date != null){
            return \Response::json([
                'code' => 0,
                'msg'  => "已归还, 请勿重复操作"
            ], 200);
        }
        DB::transaction(function () use ($id, $book_id) {
            DB::table('borrows')
                ->where('id', '=', $id)
                ->update([
                    'return_date' => date('Y-m-d', $_SERVER['REQUEST_TIME'])
                ]);

            DB::table('books')
                ->where('id', '=', $book_id)
                ->increment('amount', 1);
        });
        return \Response::json([
            'code' => 0,
            'msg'  => "归还成功"
        ], 200);

    }

    public function renew_book($id){
        $status = DB::table('borrows')->where('id', '=', $id)
            ->first();
        if ($status->return_date != null || $status->renew == 1){
            return \Response::json([
                'code' => 1,
                'msg'  => "异常操作，请勿重复续借"
            ], 200);
        }
        //过期日期
        $time_limit = '';
        DB::transaction(function () use ($id, $status, &$time_limit) {
            $time_limit = date('Y-m-d', strtotime($status->time_limit) + 30 * 24 * 3600);
            DB::table('borrows')
                ->where('id', '=', $id)
                ->update([
                    'time_limit' => $time_limit,
                    'renew' => 1
                ]);

        });
        return \Response::json([
            'code' => 0,
            'time_limit' => $time_limit,
            'msg'  => "续借成功"
        ], 200);
    }

    public function lose_book($id){
        DB::table('borrows')->where('id', '=', $id)
            ->update([
                'lose' => 1,
                'return_date' => date('Y-m-d'),
                ]);
        return \Response::json([
            'code' => 0,
            'msg'  => "成功"
        ], 200);
    }
}