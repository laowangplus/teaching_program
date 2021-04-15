<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"><a class="logo navbar-logo f-l mr-10 hidden-xs" href="/aboutHui.shtml">教学大纲管理系统</a>
            <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/aboutHui.shtml">H-ui</a>
            <span class="logo navbar-slogan f-l mr-10 hidden-xs">v1.0</span>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">

                    @if(\Illuminate\Support\Facades\Session::get('jurisdiction') == 0)
                        <li data-toggle="tooltip" data-placement="bottom" title="拥有审核与编写指定大纲的权限">教师</li>
                    @elseif(\Illuminate\Support\Facades\Session::get('jurisdiction') == 1)
                        <li data-toggle="tooltip" data-placement="bottom" title="拥有发布大纲目录以及选择审核人员的权限">管理员</li>
                    @endif

                        <li class="dropDown dropDown_hover">
                            <a href="#" class="dropDown_A">{{ \Illuminate\Support\Facades\Session::get('name') }} <i
                                        class="Hui-iconfont">&#xe6d5;</i></a>
                            <ul class="dropDown-menu menu radius box-shadow">
                                <li><a href="{{ url('logout') }}">退出</a></li>
                            </ul>
                        </li>

                </ul>
            </nav>
        </div>
    </div>
</header>