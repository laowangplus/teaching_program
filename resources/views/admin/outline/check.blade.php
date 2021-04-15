@extends('admin.public.index')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-article-add">

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>大纲预览：</label>
			<div class="formControls col-xs-8 col-sm-9">
				@if(!empty($record))
					<iframe src="{{$record->record_file_url}}" width="500" height="1000"></iframe>
				@else
					<p>未提交大纲</p>
				@endif
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>审核：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<span class="btn-upload form-group">
				  <div class="radio-box">
					<input type="radio" id="radio-1" name="pass" value="1">
					<label for="radio-1">审核通过</label>
				  </div>
				  <div class="radio-box">
					<input type="radio" id="radio-2" name="pass" value="0" checked>
					<label for="radio-2">审核不通过</label>
				  </div>
				</span>
				@csrf
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">审核建议：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<textarea name="context" cols="" rows="" class="textarea radius" placeholder="建议内容..."></textarea>
			</div>
		</div>

		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 提交</button>
			</div>
		</div>
	</form>
</article>

@endsection

@section('script')
<script type="text/javascript" src="{{ asset('/admin/lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admin/lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admin/lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admin/lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});

	//表单验证
	$("#form-article-add").validate({
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			layer.confirm('是否确认提交？',function(index){
				$(form).ajaxSubmit({
					type: 'post',
					url: "/admin/outline_check/{{$id}}" ,
					success: function(obj){
						if (obj.code === 0){
							layer.msg('提交成功!',{icon:1,time:1000});
							setTimeout(function(){
								window.parent.location.reload(); //刷新父页面
								var index = parent.layer.getFrameIndex(window.name);
								parent.layer.close(index);
							},1000);
						}else{
							layer.msg(obj.msg,{icon:0,time:1000});
						}

					},
					error: function(XmlHttpRequest, textStatus, errorThrown){
						let response = JSON.parse(XmlHttpRequest.responseText);
						layer.msg(response.msg,{icon:0,time:2000});
					}
				});
			});
		}
	});

});

function check(obj){
	phone = document.getElementById("phone").value;
		$.ajax({
			type: 'get',
			url: '{{ url("admin/book_borrow_check") }}'+'/'+phone,
			dataType: 'json',
			success: function(data){
				if (data.code == 0){
					layer.msg(data.msg ,{icon:2,time:1000});
				}else{
					$(document).find("#name").attr('value', data.name);
					$(document).find("#age").attr('value', data.age);
					$(document).find("#sex").attr('value', data.sex);
					$(document).find("#identity_number").attr('value', data.identity_number);
					layer.msg(data.msg ,{icon:1,time:1000});
				}
			},
		});
}
</script>
@endsection