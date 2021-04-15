<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/5
 * Time: 13:35
 */

namespace App\Http\Controllers\Admin;


use App\Exceptions\ArticleException;
use App\Http\Controllers\Controller;
use App\Http\Service\admin\BookService;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;
use Cache;
use Request;

class BookController extends Controller {
    public function index() {
        $data = DB::table('books')
            ->where('amount','>=', '0')
            ->select('number', 'name', 'press', 'save_time', 'value', 'amount', 'id')
            ->get();
        return view('admin.book.index', [
            'books' => $data,
        ]);
    }

    public function add() {
        return view('admin.book.add');
    }

    public function create() {
        $post = Request::post();
        try{
            DB::transaction(function () use ($post) {
                DB::table('books')->insert([
                    "name"             => $post['name'],
                    "number"           => $post['number'],
                    "author"           => $post['author'],
                    "press"            => $post['press'],
                    "publication_time" => $post['publication_time'],
                    "value"            => $post['value'],
                    "amount"           => $post['amount'],
                    "save_time" => date("Y-m-d H:i:s")
                ]);
            });
            return \Response::json([
                'code' => 0,
                'msg'  => "新增成功"
            ], 200);
        }catch (\Exception $e){
            return \Response::json([
                'code' => 1,
                'msg'  => "新增异常"
            ], 400);
        }
    }

    public function edit($id) {
        $data = DB::table('borrows')
            ->join('users', 'users.id', '=', 'borrows.user_id')
            ->join('books', 'books.id', '=', 'borrows.book_id')
            ->select('borrows.*', 'users.*', 'books.*', 'users.name as username')
            ->get();
        return view('admin.book.edit', [
            'borrows' => $data,
            'id'      => $id
        ]);
    }

    public function update() {
        $number = Request::post('number');
        $id     = Request::post('id');
        try {
            DB::transaction(function () use ($id, $number) {
                if ($number > 0) {
                    DB::table('books')
                        ->where('id', '=', $id)
                        ->increment('amount', abs($number));
                } else {
                    DB::table('books')
                        ->where('id', '=', $id)
                        ->decrement('amount', abs($number));
                }
            });
            return \Response::json([
                'code' => 0,
                'msg'  => "更新成功"
            ], 200);
        } catch (\Exception $e) {
            return \Response::json([
                'code' => 1,
                'msg'  => "更新失败"
            ], 400);
        }


    }

    public function borrow($id) {
        $date = DB::table('books')
            ->where('id', '=', $id)
            ->first();
        return view('admin.book.borrow', [
            'book' => $date
        ]);
    }

    public function loan_out(Request $request, $id) {
        if (!BookService::check_inventory($id)) {
            return \Response::json([
                'code' => 1,
                'msg'  => "库存量不足"
            ], 200);
        } else {
            $phone   = Request::get('phone');
            $user_id = cache($phone);
            if (!$user_id) {
                return \Response::json([
                    'code' => 1,
                    'msg'  => "操作异常"
                ], 400);
            }
            DB::transaction(function () use ($id, $user_id) {
                DB::table('borrows')->insert([
                    'user_id'     => $user_id,
                    'book_id'     => $id,
                    'borrow_date' => date('Y-m-d'),
                    'time_limit'  => date('Y-m-d', $_SERVER['REQUEST_TIME'] + 30 * 24 * 3600),
                ]);

                DB::table('books')
                    ->where('id', '=', $id)
                    ->decrement('amount', 1);
            });
            return \Response::json([
                'code' => 0,
                'msg'  => "借阅成功"
            ], 200);
        }

    }

    public function user_check($phone) {
        $return = DB::table('users')
            ->where('users.phone', '=', $phone)
            ->first();
        if ($return->sex == 0){
            $return->sex = '女';
        }else{
            $return->sex = '男';
        }
        if (empty($return)) {
            return \Response::json([
                'code' => 0,
                'msg'  => "用户不存在"
            ], 200);
        }
        $data = DB::table('users')
            ->join('borrows', 'borrows.user_id', '=', 'users.id')
            ->where('phone', '=', $phone)
            ->where('borrows.return_date', '=', null)
            ->select()
            ->count();
        if ($data <= 0) {
            cache([$phone => $return->id], 180);
            $return->code = 1;
            $return->msg  = '用户认证无误';
            return \Response::json($return, 200);
        } else {
            return \Response::json([
                'code' => 0,
                'msg'  => "用户有逾期未还书籍：{$data}本"
            ], 200);
        }
    }

    public function delete($id){
        $status = DB::table('books')
            ->where('id', '=', $id)
            ->update([
                'amount' => 0
            ]);
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