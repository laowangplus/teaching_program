<?php


namespace App\Http\Service;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class Message{
    public $message_prefix = "message";

    public function __construct(){
        Session::put('message_count', $this->getCount(Session::get('id')));
    }

    //封装context结构
    //code=101 管理员发布新大纲
    //code=102 撰写人上传文档
    //code=103 审核人审核通过
    //code=104 审核人审核不通过
    //code=105 所有审核人审核通过
    //code=106 管理员正式发布大纲
    private function setContext($sender_id, $sender_name, $course_id, $course_name, $code){
        $arr = [
            'sender_id' => $sender_id,
            'sender_name' => $sender_name,
            'course_id' => $course_id,
            'course_name' => $course_name,
        ];
        switch ($code){
            case 101:
                $arr['msg'] = "{$sender_name}发布了《{$course_name}》大纲目录，并设置您为撰写人。";
                break;
            case 102:
                $arr['msg'] = "{$sender_name}上传了《{$course_name}》大纲文档，请尽快审核。";
                break;
            case 103:
                $arr['msg'] = "{$sender_name}已审核通过《{$course_name}》大纲文档。";
                break;
            case 104:
                $arr['msg'] = "{$sender_name}已拒绝通过《{$course_name}》大纲文档，请根据建议修改。";
                break;
            case 105:
                $arr['msg'] = "所有审核人已通过了《{$course_name}》大纲的审核，请尽快发布";
                break;
            case 106:
                $arr['msg'] = "{$sender_name}已发布了你撰写《{$course_name}》大纲";
                break;
        }

        return json_encode($arr);
    }

    public function sendMessage($user_id, $sender_id, $sender_name, $course_id, $course_name, $code){
        $context = $this->setContext($sender_id, $sender_name, $course_id, $course_name, $code);
        Redis::hset($this->message_prefix.':'.$user_id, time().rand(0, 99), $context);
    }

    public function getMessages($user_id){
        $data = Redis::hgetall($this->message_prefix.':'.$user_id);
        foreach ($data as &$value){
            $value = json_decode($value, true);
        }
        return $data;
    }

    public function delMessages($user_id){
        Redis::del($this->message_prefix.':'.$user_id);
    }

    public function delMessage($user_id, $key){
        Redis::hdel($this->message_prefix.':'.$user_id, $key);
    }

    public function getCount($user_id){
        return Redis::hlen($this->message_prefix.':'.$user_id);
    }
}