<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
    @extends('admin.public._meta')

    <title>新增文章 - 资讯管理 - H-ui.admin v3.1</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/admin/lib/webuploader/0.1.5/webuploader.css') }}">
    <script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.jq22.com/jquery/bootstrap-3.3.4.css">
    <link rel="stylesheet" type="text/css" href="http://www.jq22.com/jquery/font-awesome.4.6.0.css">
    <link href="{{ url('/admin/lib/yselect/css/ySelect.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-article-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>课程名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>课程编号：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="number" name="number">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>学分：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" class="input-text" value="" placeholder="" id="credit" name="credit">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>理论学时：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" class="input-text" value="" placeholder="" id="theory_hours" name="theory_hours">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>实验学时：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" class="input-text" value="" placeholder="" id="experiment_hours" name="experiment_hours">
            </div>
        </div>
{{--        <div class="row cl">--}}
{{--            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>实验学时：</label>--}}
{{--            <div class="formControls col-xs-8 col-sm-9">--}}
{{--                <input type="date" class="input-text" value="" placeholder="" id="experiment_hours" name="experiment_hours">--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>撰写人：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input list="source" id="write_user_no" name="write_user_no">
                <datalist id="source">
                    @foreach ($users as $user)
                        <option value="{{$user->tearcher_no}}"></option>
                    @endforeach
                </datalist>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>审核人：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select id='examinant' class="examinant" name="examinant" multiple="multiple" >
                    @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->tearcher_name}}--{{$user->tearcher_no}}</option>
                    @endforeach
                    <option value="4">嘉士伯啤酒</option>
                    <option value="5">成功图像类型</option>
                    <option value="6">门店类型</option>
                </select>
            </div>
        </div>
        <input type="hidden" class="examinants" value="" placeholder="" id="examinants" name="examinants">
        @csrf
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 提交</button>
                <button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</article>

<!--_footer 作为公共模版分离出去-->
@extends('admin.public._footer')
<!--/_footer /作为公共模版分离出去-->

@section('script')
    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript" src="{{ asset('/admin/lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/admin/lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
{{--    <script type="text/javascript" src="{{ asset('/admin/lib/bootstrap.min.js') }}"></script>--}}
    <script type="text/javascript" src="{{ asset('/admin/lib/yselect/js/ySelect.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            $('.examinant').ySelect(
                {
                    placeholder: '请先选择指定审核教师',
                    searchText: '搜索',
                    showSearch: true,
                    numDisplayed: 4,
                    overflowText: '已选中 {n}名',
                    isCheck:false
                }
            );


            //表单验证
            $("#form-article-add").validate({
                // rules:{
                // 	name:{
                // 		required:true,
                // 	},
                //     credit:{
                //         required:true,
                //     },
                // 	number:{
                // 		required:true,
                // 	},
                //     theory_hours:{
                // 		required:true,
                // 	},
                //     experiment_hours:{
                // 		required:true,
                // 	},
                //     examinant:{
                // 		required:true,
                // 	},
                // },
                onkeyup: false,
                focusCleanup: true,
                success: "valid",
                submitHandler: function (form) {
                    $value = $("#examinant").ySelectedValues(",")
                    $("#examinants").val($value)

                    layer.confirm('确认要添加吗？', function (index) {
                        $(form).ajaxSubmit({
                            type: 'post',
                            url: "{{ url('admin/outline_create') }}",
                            success: function(obj){
                                if (obj.code === 0){
                                    layer.msg('新增成功!',{icon:1,time:1000});
                                    setTimeout(function(){
                                        window.parent.location.reload(); //刷新父页面
                                        var index = parent.layer.getFrameIndex(window.name);
                                        parent.layer.close(index);
                                    },1000);
                                }else{
                                    layer.msg(obj.msg,{icon:0,time:1000});
                                }
                            },
                            error: function (XmlHttpRequest, textStatus, errorThrown) {
                                let response = JSON.parse(XmlHttpRequest.responseText);
                                layer.msg(response.msg, {icon: 0, time: 2000});
                            }
                        });
                    });
                }
            });


        });
    </script>
    <!--/请在上方写此页面业务相关的脚本-->
@endsection
</body>
</html>