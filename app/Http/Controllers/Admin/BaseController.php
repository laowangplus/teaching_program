<?php
/**
 * Created by PhpStorm.
 * User: θηδΈη¨
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