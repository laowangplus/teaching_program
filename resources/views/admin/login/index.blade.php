@extends('admin.public.index')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/static/h-ui.admin/css/H-ui.login.css')}}"/>
    <title>登录--教学大纲管理系统</title>
@endsection


@section('content')
    <input type="hidden" id="TenantId" name="TenantId" value=""/>
    <div class="loginWraper">
        <div id="loginform" class="loginBox">
            <form class="form form-horizontal" id="form-horizontal">
                <div class="row cl">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                    <div class="formControls col-xs-8">
                        <input id="username" name="username" type="text" placeholder="账户" class="input-text size-L">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                    <div class="formControls col-xs-8">
                        <input id="password" name="password" type="password" placeholder="密码" class="input-text size-L">
                    </div>
                </div>
                <div class="row cl">
                    <div class="formControls col-xs-8 col-xs-offset-3">
                        <input class="input-text size-L" name="captcha" type="text" placeholder="验证码"
                               onblur="if(this.value==''){this.value='验证码:'}"
                               onclick="if(this.value=='验证码:'){this.value='';}" value="" style="width:150px;">
                        <img src="{{captcha_src()}}" onclick="this.src='{{captcha_src()}}'+Math.random()"></div>
                </div>
                <div class="row cl">
                    <div class="formControls col-xs-8 col-xs-offset-3">
                        <label for="online">
                            <input type="checkbox" name="online" id="online" value="">
                            使我保持登录状态</label>
                        @csrf
                    </div>
                </div>
                <div class="row cl">
                    <div class="formControls col-xs-8 col-xs-offset-3">
                        <input name="" type="submit" class="btn btn-success radius size-L"
                               value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
                        <input name="" type="reset" class="btn btn-default radius size-L"
                               value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="footer">教学大纲管理系统-后台登录</div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('/admin/lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/admin/lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
    <script>
        $(function () {
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            //表单验证
            $("#form-horizontal").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    author: {
                        required: true,
                    },
                    number: {
                        required: true,
                    },
                    press: {
                        required: true,
                    },
                    publication_time: {
                        required: true,
                    },
                    value: {
                        required: true,
                    },
                    amount: {
                        required: true,
                    },
                },
                onkeyup: false,
                focusCleanup: true,
                success: "valid",
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        type: 'POST',
                        url: "{{ url('login') }}",
                        success: function (obj) {
                            if (obj.code === 0) {
                                layer.msg('登陆成功!', {icon: 1, time: 1000});
                                setTimeout(function () {
                                    window.parent.location.href = '{{ url('admin/index') }}';
                                }, 1000);
                            } else {
                                layer.msg(obj.msg, {icon: 0, time: 1000});
                            }
                        },
                        error: function (XmlHttpRequest, textStatus, errorThrown) {
                            let response = JSON.parse(XmlHttpRequest.responseText);
                            console.log(response.errors.captcha);
                            layer.msg(response.errors.captcha[0], {icon: 0, time: 2000});
                        }
                    });
                }
            });
        });
    </script>
@endsection