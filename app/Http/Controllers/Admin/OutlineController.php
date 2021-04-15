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
use App\Http\Service\curl\RequestService;
use App\Http\Service\Message;
use function Composer\Autoload\includeFile;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Json;
use Cache;
use Request;

class OutlineController extends Controller {
    //课程管理首页
    public function outline_list() {
        $courses = DB::table('courses')
            ->leftJoin('users as create_users', 'create_users.tearcher_no', '=', 'courses.created_user_no')
            ->leftJoin('users as write_users', 'write_users.tearcher_no', '=', 'courses.write_user_no')
            ->where('type', '=', 1)
            ->select( 'course_no', 'write_users.tearcher_name as write_user_name', 'create_users.tearcher_name as create_user_name', 'course_name', 'type', 'courses.created_at', 'courses.id')
            ->get();

        return view('admin.outline.list', [
            'courses' => $courses,
        ]);
    }

    //课程管理首页
    public function index() {
        $courses = DB::table('courses')
            ->leftJoin('users as create_users', 'create_users.tearcher_no', '=', 'courses.created_user_no')
            ->leftJoin('users as write_users', 'write_users.tearcher_no', '=', 'courses.write_user_no')
            ->where('created_user_no', '=', Session::get('tearcher_no'))
            ->where("type", '=', 0)
            ->select( 'course_no', 'write_users.tearcher_name as write_user_name', 'create_users.tearcher_name as create_user_name', 'course_name', 'type', 'courses.created_at', 'courses.id')
            ->get();

        return view('admin.outline.index', [
            'courses' => $courses,
        ]);
    }

    public function add() {
        $users = DB::table('users')
            ->select('tearcher_no', 'tearcher_name', 'academy', 'jurisdiction', 'id')
            ->get();
        return view('admin.outline.add', [
            'users' => $users,
        ]);
    }

    public function create() {
        $post = Request::post();
        try{
            $course_id = 0;
            DB::transaction(function () use ($post, &$course_id) {
                $course_id = DB::table('courses')->insertGetId([
                    "course_name"             => $post['name'],
                    "course_no"           => $post['number'],
                    "created_user_no"           => Session::get("tearcher_no"),
                    "write_user_no"           => $post['write_user_no'],
                    "credit"           => $post['credit'],
                    "theory_hours"            => $post['theory_hours'],
                    "experiment_hours" => $post['experiment_hours'],
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                ]);

                //封装批量插入审核数据
                $users = explode(",", $post['examinants']);
                $arr = [];
                foreach ($users as $user_id){
                    $arr[] = [
                        "user_id"             => $user_id,
                        "course_id"           => $course_id,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                }
                DB::table('examines')->insert($arr);
            });

            //发生消息
            $user = DB::table('users')
                ->where('tearcher_no', '=', $post['write_user_no'])
                ->select('tearcher_no', 'tearcher_name', 'academy', 'jurisdiction', 'id')
                ->first();
            (new Message())->sendMessage($user->id, Session::get('id'), Session::get('tearcher_name'), $course_id, $post['name'], 101);

            return \Response::json([
                'code' => 0,
                'msg'  => "新增成功"
            ], 200);
        }catch (\Exception $e){
            return \Response::json([
                'code' => 1,
                'msg'  => $e->getMessage()
            ], 400);
        }
    }

    public function show($id) {
        $course = DB::table('courses')->leftJoin('users', 'users.tearcher_no', '=', 'courses.created_user_no')
            ->where('courses.id', '=', $id)
            ->select('course_no', 'tearcher_name', 'course_name', 'credit', 'theory_hours', 'experiment_hours', 'examinant_time', 'type', 'courses.created_at', 'courses.id')
            ->first();

        $users = DB::table('examines')->leftJoin('users', 'users.id', '=', 'examines.user_id')
            ->where('examines.course_id', '=', $id)
            ->select( 'tearcher_name', 'tearcher_no')
            ->get();

        if (!empty($course)){
            $record = DB::table('records')
                ->where('records.course_id', '=', $course->id)
                ->select( 'record_file_url')
                ->first();
        }

        return view('admin.outline.show', [
            'course' => $course,
            'users' => $users,
            'record' => $record,
            'id'      => $id
        ]);
    }

    //编写列表首页
    public function write_index() {
        $courses = DB::table('courses')->leftJoin('users', 'users.tearcher_no', '=', 'courses.created_user_no')
            ->where("write_user_no", '=', Session::get("tearcher_no"))
            ->where("type", '=', 0)
            ->select('course_no', 'tearcher_name', 'course_name', 'type', 'courses.created_at', 'courses.id')
            ->get();

        return view('admin.outline.write', [
            'courses' => $courses,
        ]);
    }

    //上传大纲页面
    public function write_upload($id) {
        $data = [];
        if (!empty($id)){
            $data = DB::table('records')
                ->where('course_id', '=', $id)
                ->select('record_file_url')
                ->first();
        }
        return view('admin.outline.upload', [
            'record' => $data,
            'id' => $id,
        ]);
    }

    //上传大纲
    public function upload($id) {
        $file = request()->file("file");
        $true_name = $file->getFilename();
        $size = $file->getSize();
        $ext = $file->getClientOriginalExtension();//文件拓展名
        $path = $file->getRealPath();//绝对路径

        $filenames = time().uniqid().".".$ext;//设置文件存储名称

        $res = Storage::disk('public')->put($filenames,file_get_contents($path));

        if (!$res){
            return \Response::json([
                'code' => 1,
                'msg'  => "文件存储失败"
            ], 400);
        }

        $file_path = Request::server('HTTP_HOST').'/storage/'.$filenames;

        //生产模式下开启
//        $res_json_body = RequestService::DcsApi($file_path);
//        $data = json_decode($res_json_body, true);
//
//        if ($data['errorcode'] != 0){
//            return \Response::json([
//                'code' => 1,
//                'msg'  => "预览转换异常：".$data["message"]
//            ], 400);
//        }
//        $record_file_url = $data['data']['data'];
        $record_file_url = 'http://dcsapi.com/?k=58695454209710489704371&url=http://47.102.205.111:8000/images/20210409220649.docx';

        $record = DB::table('records')
            ->where('course_id', '=', $id)
            ->select('record_file_url')
            ->first();

        if (empty($record)) {
            DB::table('records')->insert([
                "course_id"             => $id,
                "teacher_id"            => Session::get('id'),
                "record_name"           => $true_name,
                "record_type"           => $ext,
                "record_size"            => $size,
                "record_file_url" => $record_file_url,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ]);
        }else{
            DB::table('records')
                ->where('course_id', '=', $id)
                ->update([
                    "record_name"           => $true_name,
                    "record_type"           => $ext,
                    "record_size"            => $size,
                    "record_file_url" => $record_file_url,
                    "updated_at" => date("Y-m-d H:i:s"),
                ]);
        }

        //发生消息
        $users = DB::table('examines')
            ->leftJoin('users', 'users.id', '=', 'examines.user_id')
            ->leftJoin('courses', 'courses.id', '=', 'examines.course_id')
            ->where("course_id", '=', $id)
            ->select( 'course_no','course_name', 'examines.user_id as user_id', 'tearcher_name')
            ->get();
        foreach($users as $user){
            (new Message())->sendMessage(Session::get("id"), $user->user_id, $user->tearcher_name, $id, $user->course_name, 102);
        }

        return \Response::json([
            'code' => 0,
            'msg'  => "上传成功"
        ], 200);

    }

    //审核首页
    public function audit_index() {
        $courses = DB::table('examines')
            ->leftJoin('courses', 'courses.id', '=', 'examines.course_id')
            ->where("courses.type", '=', 0)
            ->where("user_id", '=', Session::get("id"))
            ->select( 'course_no','course_name', 'examine_type', 'type', 'courses.created_at as created_at', 'courses.id as id')
            ->get();

        return view('admin.outline.audit', [
            'courses' => $courses,
        ]);
    }

    //审核首页
    public function audit_check($id) {
        $data = [];
        if (!empty($id)){
            $data = DB::table('records')
                ->where('course_id', '=', $id)
                ->select('record_file_url')
                ->first();
        }
        return view('admin.outline.check', [
            'record' => $data,
            'id' => $id,
        ]);
    }

    //审核处理
    public function check($id) {
        $post = Request::post();

        //发生消息
        $course = DB::table('courses')->leftJoin('users', 'users.tearcher_no', '=', 'courses.write_user_no')
            ->where("courses.id", '=', $id)
            ->where("type", '=', 0)
            ->select('created_user_no', 'users.id as user_id', 'course_no', 'tearcher_name', 'course_name', 'type', 'courses.created_at', 'courses.id')
            ->first();
        if($post['pass'] == 1){
            $flag = true;
            $examines = DB::table('examines')
                ->where('examines.course_id', '=', $id)
                ->select( 'examine_type')
                ->get();
            foreach($examines as $examine){
                if($examine->examine_type == 0 ){
                    $flag = false;
                }
            }
            if($flag){
                $user = DB::table('users')
                    ->where("tearcher_no", '=', $course->created_user_no)
                    ->select('tearcher_name', 'id')
                    ->first();
                (new Message())->sendMessage(Session::get("id"), $user->id, $user->tearcher_name, $id, $course->course_name, 105);
            }

            (new Message())->sendMessage(Session::get("id"), $course->user_id, $course->tearcher_name, $id, $course->course_name, 103);
        }else{
            (new Message())->sendMessage(Session::get("id"), $course->user_id, $course->tearcher_name, $id, $course->course_name, 104);
        }

        DB::transaction(function () use ($id, $post) {
            DB::table('comments')->insert([
                'user_id'     => Session::get('id'),
                'course_id'     => $id,
                'context'     => $post['context'],
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ]);

            if ($post['pass'] == 1){
                DB::table('examines')
                    ->where("course_id", '=', $id)
                    ->update([
                        'examine_type'     => 1,
                    ]);
            }

        });

        return \Response::json([
            'code' => 0,
            'msg'  => "提交成功"
        ], 200);
    }

    //课程管理首页
    public function suggest_index($id) {
        $comments = DB::table('comments')
            ->leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->where('comments.course_id', '=', $id)
            ->select( 'context', 'tearcher_name', 'tearcher_no', 'comments.created_at as created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.outline.suggest', [
            'comments' => $comments,
        ]);
    }

    //发布大纲
    public function publish($id){

        //发生消息
        $course = DB::table('courses')->leftJoin('users', 'users.tearcher_no', '=', 'courses.write_user_no')
            ->where("courses.id", '=', $id)
            ->where("type", '=', 0)
            ->select('write_user_no', 'users.id as user_id', 'course_no', 'tearcher_name', 'course_name', 'type', 'courses.created_at', 'courses.id')
            ->first();
        (new Message())->sendMessage(Session::get("id"), $course->user_id, $course->tearcher_name, $id, $course->course_name, 103);

        DB::table('courses')
            ->where("id", '=', $id)
            ->update([
                'type'     => 1,
                'examinant_time'     => date("Y-m-d H:i:s"),
            ]);

        return \Response::json([
            'code' => 0,
            'msg'  => "发布成功"
        ], 200);
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