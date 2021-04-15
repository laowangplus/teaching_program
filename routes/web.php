<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'check.login'], function () {
    //首页
    Route::get('/admin/index', 'Admin\IndexController@index');
    Route::get('/admin/welcome', 'Admin\IndexController@welcome');
    Route::get('/', 'Admin\IndexController@index');

    Route::group(['middleware' => 'check.book'], function () {
        //用户管理
        Route::get('/admin/user', 'Admin\UserController@index');
        Route::get('/admin/user_add', 'Admin\UserController@add');
        Route::post('/admin/user_create', 'Admin\UserController@create');
        Route::get('/admin/user_edit/{id}', 'Admin\UserController@edit');
        Route::post('/admin/user_update/{id}', 'Admin\UserController@update');
        Route::get('/admin/user_show/{id}', 'Admin\UserController@show');

        //书籍管理
        Route::get('/admin/book_add', 'Admin\BookController@add');
        Route::post('/admin/book_create', 'Admin\BookController@create');
        Route::get('/admin/book_edit/{id}', 'Admin\BookController@edit');
        Route::post('/admin/book_update', 'Admin\BookController@update');
    });

//后台
//借阅
    Route::get('/admin/book', 'Admin\BookController@index');
    Route::get('/admin/book_borrow/{id}', 'Admin\BookController@borrow');
    Route::get('/admin/loan_out/{id}', 'Admin\BookController@loan_out');
    Route::get('/admin/book_borrow_check/{phone}', 'Admin\BookController@user_check');

//归还
    Route::get('/admin/borrow', 'Admin\BorrowController@index');
    Route::get('/admin/borrow_return/{id}/{book_id}', 'Admin\BorrowController@borrow_return');

//续借
    Route::get('/admin/renew_book/{id}', 'Admin\BorrowController@renew_book');

//丢失
    Route::get('/admin/lose_book/{id}', 'Admin\BorrowController@lose_book');

//归还记录
    Route::get('/admin/return', 'Admin\ReturnController@index');

    Route::group(['middleware' => 'check.super'], function () {

        //管理员
        Route::get('/admin/admin', 'Admin\AdminController@index');
        Route::get('/admin/admin_add', 'Admin\AdminController@add');
        Route::post('/admin/admin_create', 'Admin\AdminController@create');
        Route::get('/admin/admin_edit/{id}', 'Admin\AdminController@edit');
        Route::post('/admin/admin_update/{id}', 'Admin\AdminController@update');
    });

    //针对有权限的限制接口（删除操作）
    Route::group(['middleware' => 'check.api.super'], function () {

        //删除
        Route::get('/admin/admin_delete/{id}', 'Admin\AdminController@delete');
        Route::get('/admin/user_delete/{id}', 'Admin\UserController@delete');
        Route::get('/admin/return_delete/{id}', 'Admin\ReturnController@delete');
        Route::get('/admin/book_delete/{id}', 'Admin\BookController@delete');
    });

});

//教学大纲后台
//大纲管理
Route::group(['middleware' => 'check.login'], function () {
    Route::get('/admin/outline_personal', 'Admin\UserController@personal');
    Route::post('/admin/personal_update/{id}', 'Admin\UserController@personal_update');

    Route::get('/admin/outline_list', 'Admin\OutlineController@outline_list');

    Route::get('/admin/outline', 'Admin\OutlineController@index');
    Route::get('/admin/outline_add', 'Admin\OutlineController@add');
    Route::get('/admin/outline_show/{id}', 'Admin\OutlineController@show');
    Route::post('/admin/outline_create', 'Admin\OutlineController@create');

    Route::get('/admin/outline_write_index', 'Admin\OutlineController@write_index');
    Route::get('/admin/outline_write_upload/{id}', 'Admin\OutlineController@write_upload');
    Route::post('/admin/outline_update/{id}', 'Admin\OutlineController@upload');


    Route::get('/admin/outline_audit_index', 'Admin\OutlineController@audit_index');
    Route::get('/admin/outline_audit_check/{id}', 'Admin\OutlineController@audit_check');
    Route::post('/admin/outline_check/{id}', 'Admin\OutlineController@check');

    Route::get('/admin/outline_suggest_index/{id}', 'Admin\OutlineController@suggest_index');

    Route::get('/admin/outline_publish/{id}', 'Admin\OutlineController@publish');

    Route::get('/admin/outline_message_list', 'Admin\MessageController@message_list');
    Route::get('/admin/outline_delete_message/{key}', 'Admin\MessageController@delete_message');
});

//登录
Route::get('/login', 'Admin\LoginController@index');
Route::post('/login', 'Admin\LoginController@check');
Route::get('/logout', 'Admin\LoginController@logout');
Route::get('/admin/error', 'Admin\IndexController@error');
Route::get('/admin/api_error', 'Admin\IndexController@api_error');
