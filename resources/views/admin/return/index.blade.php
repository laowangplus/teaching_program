@extends('admin.public.index')

	@section('content')
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 归还管理 <span class="c-gray en">&gt;</span> 归还记录列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="page-container">
            {{--<div class="text-c">--}}
                {{--<input type="text" name="" id="" placeholder="书籍名称" style="width:250px" class="input-text">--}}
                {{--<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索 </button>--}}
            {{--</div>--}}
            <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="removeIframe()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 关闭选项卡</a></span>  </div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                    <thead>
                    <tr class="text-c">
                        <th width="80">借阅人</th>
                        <th width="120">手机号</th>
                        <th width="80">书籍编号</th>
                        <th width="120">书名</th>
                        <th width="120">借阅时间</th>
                        <th width="120">归还日期</th>
                        <th width="80">状态</th>
                        <th width="120">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $returns as $return)
                    <tr class="text-c">
                        <td>{{ $return->username }}</td>
                        <td>{{ $return->phone }}</td>
                        <td>{{ $return->number }}</td>
                        <td>{{ $return->name }}</td>
                        <td>{{ $return->borrow_date }}</td>
                        <td>{{ $return->return_date }}</td>
                        @if( $return->lose == 1)
                            <td class="td-status"><span class="label label-error radius">丢失</span></td>
                        @elseif( $return->return_date > $return->time_limit && $return->lose == 0 )
                            <td class="td-status"><span class="label label-warning radius">过期归还</span></td>
                        @else
                            <td class="td-status"><span class="label label-success radius">正常归还</span></td>
                        @endif
                        <td class="f-14 td-manage">
                            <a style="text-decoration:none" class="ml-5" onClick="return_del(this,'{{ $return->borrow_id }}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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
                    {"orderable":false,"aTargets":[7]}// 不参与排序的列
                ]
            });

            /*资讯-删除*/
            function return_del(obj,id){
                layer.confirm('确认要删除吗？',function(index){
                    $.ajax({
                        type: 'get',
                        url: '{{ url('admin/return_delete') }}'+'/'+id,
                        dataType: 'json',
                        success: function(data){
                            $(obj).parents("tr").remove();
                            layer.msg('已删除!',{icon:1,time:1000});
                        },
                        error:function(data) {
                            layer.msg('权限不足!',{icon:0,time:1000});
                        },
                    });
                });
            }


        </script>
    @endsection