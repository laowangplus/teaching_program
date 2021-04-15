<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/10
 * Time: 22:30
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class BaseController extends Controller {
    public function __construct(){
        $this->middleware('auth');
    }

}