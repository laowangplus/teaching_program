@extends('admin.public.index')

	@section('content')
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 借阅管理 <span class="c-gray en">&gt;</span> 借阅列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
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
                        <th width="120">联系方式</th>
                        <th width="80">书籍编号</th>
                        <th width="80">书名</th>
                        <th width="120">借阅时间</th>
                        <th width="120">应归还日期</th>
                        <th width="120">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $borrows as $borrow)
                    <tr class="text-c">
                        <td>{{ $borrow->username }}</td>
                        <td>{{ $borrow->phone }}</td>
                        <td>{{ $borrow->number }}</td>
                        <td>{{ $borrow->name }}</td>
                        <td>{{ $borrow->borrow_date }}</td>
                        <td class="time_limit">{{ $borrow->time_limit }}</td>
                        <td class="f-14 td-manage">
                            <a style="text-decoration:none" onClick="return_book(this,{{ $borrow->borrow_id }}, {{ $borrow->book_id }})" href="javascript:;" title="归还"><i class="Hui-iconfont">&#xe645;</i></a>
                            <a style="text-decoration:none" onClick="renew_book(this,{{ $borrow->borrow_id }})" href="javascript:;" title="续借"><i class="Hui-iconfont">&#xe6de;</i></a>
                            <a style="text-decoration:none" onClick="lose_book(this,{{ $borrow->borrow_id }})" href="javascript:;" title="丢失"><i class="Hui-iconfont">&#xe6de;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="borrow_del(this,'{{ $borrow->borrow_id }}')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                        </td>
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
                "aaSorting": [[ 5, "desc" ]],//默认第几个排序
                "bStateSave": true,//状态保存
                "pading":false,
                "aoColumnDefs": [
                    //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                    {"orderable":false,"aTargets":[6]}// 不参与排序的列
                ]
            });

            /*还书*/
            function return_book(obj,id,book_id){
                layer.confirm('确认要归还吗？',function(index){
                    $.ajax({
                        type: 'GET',
                        url: '{{ url('admin/borrow_return') }}'+"/"+id+"/"+book_id,
                        dataType: 'json',
                        success: function(data){
                            if (data.code === 0){
                                $(obj).parents("tr").remove();
                                layer.msg('归还成功!',{icon:1,time:1000});
                            }else{
                                $(obj).parents("tr").remove();
                                layer.msg(data.msg ,{icon:1,time:1000});
                            }

                        },
                        error:function(data) {
                            console.log(data.msg);
                        },
                    });
                });
            }

            /*还书*/
            function renew_book(obj,id){
                layer.confirm('确认要续借吗？',function(index){
                    $.ajax({
                        type: 'GET',
                        url: '{{ url('admin/renew_book') }}'+"/"+id,
                        dataType: 'json',
                        success: function(data){
                            if (data.code === 0){
                                $(obj).parents("tr").find(".time_limit").html(data.time_limit);
                                layer.msg('续借成功!',{icon:1,time:1000});
                            }else{
                                layer.msg(data.msg ,{icon:2,time:1000});
                            }

                        },
                        error:function(data) {
                            console.log(data.msg);
                        },
                    });
                });
            }

            /*还书*/
            function lose_book(obj,id){
                layer.confirm('确认书籍已丢失吗？',function(index){
                    $.ajax({
                        type: 'GET',
                        url: '{{ url('admin/lose_book') }}'+"/"+id,
                        dataType: 'json',
                        success: function(data){
                            if (data.code === 0){
                                $(obj).parents("tr").remove();
                                layer.msg('进行丢失处理!',{icon:1,time:1000});
                            }else{
                                layer.msg(data.msg ,{icon:2,time:1000});
                            }

                        },
                        error:function(data) {
                            console.log(data.msg);
                        },
                    });
                });
            }

            /*资讯-删除*/
            function borrow_del(obj,id){
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