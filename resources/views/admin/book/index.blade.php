@extends('admin.public.index')

	@section('content')
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 教学大纲管理 <span class="c-gray en">&gt;</span> 课程管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="page-container">
            {{--<div class="text-c">--}}
                {{--<input type="text" name="" id="" placeholder="书籍名称" style="width:250px" class="input-text">--}}
                {{--<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索 </button>--}}
            {{--</div>--}}
            <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="removeIframe()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 关闭选项卡</a> <a class="btn btn-primary radius" onclick="book_add('添加课程大纲','{{ url('admin/book_add') }}')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加课程大纲</a></span> </div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                    <thead>
                    <tr class="text-c">
                        <th width="80">课程编号</th>
                        <th width="80">课程名</th>
                        <th width="80">审核人	</th>
                        <th width="120">审核次数</th>
                        <th width="75">创建时间</th>
                        <th width="60">审核状态</th>
                        <th width="120">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($books as $book)
                    <tr class="text-c">
                        <td>{{ $book->number }}</td>
                        <td>{{ $book->name }}</td>
                        <td>{{ $book->press }}</td>
                        <td>{{ $book->save_time }}</td>
                        <td>{{ $book->value }}</td>
                        <td class="amount">{{ $book->amount }}</td>
                        <td class="f-14 td-manage">
                            <a style="text-decoration:none" onClick="borrow('借阅','{{ url('/admin/book_borrow/'.$book->id) }}','4','','510')" href="javascript:;" title="借阅"><i class="Hui-iconfont">&#xe6de;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="borrow('增减','{{ url('/admin/book_edit/'.$book->id) }}','4','','510')" href="javascript:;" title="增减"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a style="text-decoration:none" class="ml-5" onClick="book_del(this,'{{ $book->id }}')" href="javascript:;" title="清空"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
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

            //借阅
            function borrow(title,url,id,w,h){
                layer_show(title,url,w,h);
            }

            /*产品-添加*/
            function book_add(title,url){
                var index = layer.open({
                    type: 2,
                    title: title,
                    content: url
                });
                layer.full(index);
            }

            /*资讯-删除*/
            function book_del(obj,id){
                layer.confirm('确认要清空该书籍吗？',function(index){
                    $.ajax({
                        type: 'get',
                        url: '{{ url('admin/book_delete') }}'+'/'+id,
                        dataType: 'json',
                        success: function(data){
                            $(obj).parents("tr").find(".amount").html("0");
                            layer.msg('已清空!',{icon:1,time:1000});
                        },
                        error:function(data) {
                            layer.msg('权限不足!',{icon:0,time:1000});
                        },
                    });
                });
            }

            /*资讯-审核*/
            function article_shenhe(obj,id){
                layer.confirm('审核文章？', {
                        btn: ['通过','不通过','取消'],
                        shade: false,
                        closeBtn: 0
                    },
                    function(){
                        $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="article_start(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
                        $(obj).remove();
                        layer.msg('已发布', {icon:6,time:1000});
                    },
                    function(){
                        $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="article_shenqing(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-danger radius">未通过</span>');
                        $(obj).remove();
                        layer.msg('未通过', {icon:5,time:1000});
                    });
            }
            /*资讯-下架*/
            function article_stop(obj,id){
                layer.confirm('确认要下架吗？',function(index){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="article_start(this,id)" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
                    $(obj).remove();
                    layer.msg('已下架!',{icon: 5,time:1000});
                });
            }

            /*资讯-发布*/
            function article_start(obj,id){
                layer.confirm('确认要发布吗？',function(index){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="article_stop(this,id)" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
                    $(obj).remove();
                    layer.msg('已发布!',{icon: 6,time:1000});
                });
            }
            /*资讯-申请上线*/
            function article_shenqing(obj,id){
                $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">待审核</span>');
                $(obj).parents("tr").find(".td-manage").html("");
                layer.msg('已提交申请，耐心等待审核!', {icon: 1,time:2000});
            }

        </script>
    @endsection