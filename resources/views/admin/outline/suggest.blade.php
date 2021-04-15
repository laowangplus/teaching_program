@extends('admin.public.index')

	@section('content')
        <div class="page-container">
            {{--<div class="text-c">--}}
                {{--<input type="text" name="" id="" placeholder="书籍名称" style="width:250px" class="input-text">--}}
                {{--<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索 </button>--}}
            {{--</div>--}}
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                    <thead>
                    <tr class="text-c">
                        <th width="80">审核员编号</th>
                        <th width="40">审核员</th>
                        <th width="400">建议内容</th>
                        <th width="75">发布时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($comments as $comment)
                    <tr class="text-c">
                        <td>{{ $comment->tearcher_no }}</td>
                        <td>{{ $comment->tearcher_name }}</td>
                        <td>{{ $comment->context }}</td>
                        <td class="amount">{{ $comment->created_at }}</td>
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
                    {"orderable":false,"aTargets":[5]}// 不参与排序的列
                ]
            });

        </script>
    @endsection