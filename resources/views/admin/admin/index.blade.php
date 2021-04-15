@extends('admin.public.index')

	@section('content')
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="page-container">
            {{--<div class="text-c">--}}
                {{--<input type="text" name="" id="" placeholder="书籍名称" style="width:250px" class="input-text">--}}
                {{--<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索 </button>--}}
            {{--</div>--}}
            <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="removeIframe()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 关闭选项卡</a> <a class="btn btn-primary radius" data-title="添加管理" onclick="admin_add('添加管理','{{ url('admin/admin_add') }}')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加管理</a></span> </div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                    <thead>
                    <tr class="text-c">
                        <th width="60">编号</th>
                        <th width="60">姓名</th>
                        <th width="80">联系方式</th>
                        <th width="80">性别</th>
                        <th width="40">年龄</th>
                        <th width="40">权限</th>
                        <th width="120">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $admin)
                    <tr class="text-c">
                        <td>{{ $admin->number }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->phone }}</td>
                        @if($admin->sex == 1)
                        <td>男</td>
                        @else
                        <td>女</td>
                        @endif
                        <td>{{ $admin->age }}</td>
                        @if($admin->jurisdiction == 0)
                            <td>超级管理员</td>
                        @elseif($admin->jurisdiction == 1)
                            <td>书籍用户管理</td>
                        @else
                            <td>普通管理员</td>
                        @endif
                        @csrf
                        <td class="f-14 td-manage"> <a style="text-decoration:none" class="ml-5" onClick="user_edit('用户修改','{{ url('admin/admin_edit/'.$admin->id) }}')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="admin_del(this,'{{$admin->id}}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
	@endsection

    @section('script')
        <script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script>
        <script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
        <script type="text/javascript">
            $('.table-sort').dataTable({
                "aaSorting": [[ 0, "desc" ]],//默认第几个排序
                "bStateSave": true,//状态保存
                "pading":false,
                "aoColumnDefs": [
                    //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                    {"orderable":false,"aTargets":[6]}// 不参与排序的列
                ]
            });

            /*产品-添加*/
            function admin_add(title,url){
                var index = layer.open({
                    type: 2,
                    title: title,
                    content: url
                });
                layer.full(index);
            }

            /*产品-修改*/
            function user_edit(title,url){
                var index = layer.open({
                    type: 2,
                    title: title,
                    content: url
                });
                layer.full(index);
            }

            function admin_del(obj,id){
                layer.confirm('确认要删除吗？',function(index){
                    $.ajax({
                        type: 'get',
                        url: '{{ url('admin/admin_delete') }}'+'/'+id,
                        dataType: 'json',
                        success: function(data){
                            $(obj).parents("tr").remove();
                            layer.msg('已删除!',{icon:1,time:1000});
                        },
                        error:function(data) {
                            layer.msg('权限不足!',{icon:1,time:1000});
                        },
                    });
                });
            }

        </script>
    @endsection