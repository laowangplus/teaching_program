<!DOCTYPE HTML>
<html>
<head>
    @extends('admin.public._meta')
    {{--<title>资讯列表</title>--}}
    @yield('css')

</head>
<body>
    @yield('content')
<!--_footer 作为公共模版分离出去-->
    @extends('admin.public._footer')

<!--请在下方写此页面业务相关的脚本-->
@yield('script')
</body>
</html>