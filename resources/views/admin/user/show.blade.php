@extends('admin.public.index')
@section('content')
    <article class="page-container">
        <div class="formControls col-xs-12 col-sm-12">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="100">编号</th>
                    <th width="120">书名</th>
                    <th width="120">借阅日期</th>
                    <th width="150">归还/丢失</th>
                </tr>
                </thead>
                <tbody>
                @foreach($borrows as $borrow)
                    <tr class="text-c">
                        <td>{{ $borrow->number }}</td>
                        <td>{{ $borrow->name }}</td>
                        <td>{{ $borrow->borrow_date }}</td>
                        @if($borrow->return_date == null)
                            <td class="td-status"><span class="label label-warning radius">未归还</span></td>
                        @elseif($borrow->lose == 1 && $borrow->return_date != null)
                            <td class="td-status"><span class="label label-error radius">丢失</span></td>
                        @else
                            <td>{{ $borrow->return_date }}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </article>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('/admin/lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/admin/lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });


        });

    </script>
@endsection