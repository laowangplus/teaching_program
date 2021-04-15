<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
    @extends('admin.public._meta')

    <title>新增文章 - 资讯管理 - H-ui.admin v3.1</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/admin/lib/webuploader/0.1.5/webuploader.css') }}">
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-article-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>教师姓名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$user->tearcher_name}}" placeholder="" id="name" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>教师编号：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$user->tearcher_no}}" placeholder="" id="number" name="number">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>权限：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="radio" id="radio-1" value="0" name="jurisdiction" @if($user->jurisdiction == 0) checked @endif>
                <label for="radio-1">教师</label>
                <input type="radio" id="radio-2" value="1" name="jurisdiction" @if($user->jurisdiction == 1) checked @endif>
                <label for="radio-2">管理员</label>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>所属院系：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$user->academy}}" placeholder="" id="academy" name="academy">
            </div>
        </div>
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
    <script type="text/javascript" src="{{ asset('/admin/lib/webuploader/0.1.5/webuploader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/lib/ueditor/1.4.3/ueditor.config.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/lib/ueditor/1.4.3/ueditor.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            //表单验证
            $("#form-article-add").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    sex: {
                        required: true,
                    },
                    age: {
                        required: true,
                        range: [18, 90],
                        digits: true,
                    },
                    identity_number: {
                        required: true,
                        minlength: 18,
                        maxlength: 18,
                    },
                    address: {
                        required: true,
                    },
                    work_address: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        isMobile: true
                    },
                },
                onkeyup: false,
                focusCleanup: true,
                success: "valid",
                submitHandler: function (form) {
                    layer.confirm('确认要修改吗？', function (index) {
                        $(form).ajaxSubmit({
                            type: 'post',
                            url: "{{ url('admin/user_update/'.$user->id) }}",
                            success: function (obj) {
                                if (obj.code === 0) {
                                    layer.msg('修改成功!', {icon: 1, time: 1000});
                                    setTimeout(function () {
                                        window.parent.location.reload(); //刷新父页面
                                        var index = parent.layer.getFrameIndex(window.name);
                                        parent.layer.close(index);
                                    }, 1000);
                                } else {
                                    layer.msg(obj.msg, {icon: 0, time: 1000});
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