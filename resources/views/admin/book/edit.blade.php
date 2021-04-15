@extends('admin.public.index')
@section('content')
<article class="page-container">
	<form class="form form-horizontal" id="form-article-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>增减数量：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="number" class="input-text phone" value="" placeholder="" id="number" name="number">
				<input type="hidden" class="input-text phone" value="{{ $id }}" placeholder="" id="id" name="id">
				@csrf
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">借阅次数：</label>
			<div class="formControls col-xs-8 col-sm-2">
				<input disabled="disabled" type="text" class="input-text" value="{{ count($borrows) }}" placeholder="" id="name" name="name">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">借阅记录：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
					<thead>
					<tr class="text-c">
						<th width="100">编号</th>
						<th width="120">书名</th>
						<th width="120">借阅者</th>
						<th width="120">借阅日期</th>
						<th width="120">归还日期</th>
					</tr>
					</thead>
					<tbody>
						@foreach($borrows as $borrow)
						<tr class="text-c">
							<td>{{ $borrow->number }}</td>
							<td>{{ $borrow->name }}</td>
							<td>{{ $borrow->username }}</td>
							<td>{{ $borrow->borrow_date }}</td>
							@if($borrow->return_date == null)
								<td class="td-status"><span class="label label-warning radius">未归还</span></td>
							@else
								<td>{{ $borrow->return_date }}</td>
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
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
			layer.confirm('是否确认修改？',function(index){
				$(form).ajaxSubmit({
					type: 'post',
					url: "/admin/book_update" ,
					success: function(obj){
						if (obj.code === 0){
							layer.msg('修改成功!',{icon:1,time:1000});
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