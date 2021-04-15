<?php


namespace App\Http\Controllers\Admin;


use App\Http\Service\Message;
use Illuminate\Support\Facades\Session;

class MessageController{
    public function message_list(){
        $data = (new Message())->getMessages(Session::get('id'));
        return view('admin.outline.message', [
            'messages' => $data,
        ]);
    }

    public function delete_message($key){
        (new Message())->delMessage(Session::get('id'), $key);
        return \Response::json([
            'code' => 0,
            'msg'  => 'ok'
        ], 200);
    }
}