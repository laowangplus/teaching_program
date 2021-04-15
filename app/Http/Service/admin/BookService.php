<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/11
 * Time: 17:28
 */

namespace App\Http\Service\admin;


use Illuminate\Support\Facades\DB;

class BookService {
    public static function check_inventory($id){
        $data = DB::table('books')
            ->where('id', '=', $id)
            ->first();
        if ($data->amount > 0){
            return true;
        }else{
            return false;
        }
    }
}