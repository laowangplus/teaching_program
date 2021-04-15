<aside class="Hui-aside">
	<div class="menu_dropdown bk_2">
{{--		<dl id="menu-article">--}}
{{--			<dt><i class="Hui-iconfont">&#xe616;</i> 书籍管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>--}}
{{--			<dd>--}}
{{--				<ul>--}}
{{--					<li><a data-href="{{ url('admin/book') }}" data-title="课程管理" href="javascript:void(0)">书籍管理</a></li>--}}
{{--				</ul>--}}
{{--			</dd>--}}
{{--		</dl>--}}

		<dl id="menu-outline">
			<dt><i class="Hui-iconfont">&#xe616;</i> 教学大纲管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="{{ url('admin/outline_list') }}" data-title="大纲列表" href="javascript:void(0)">大纲列表</a></li>
				</ul>
				@if(\Illuminate\Support\Facades\Session::get('jurisdiction') == 1)
					<ul>
						<li><a data-href="{{ url('admin/outline') }}" data-title="课程管理" href="javascript:void(0)">课程管理</a></li>
					</ul>
				@endif
			</dd>
		</dl>

		<dl id="menu-outline">
			<dt><i class="Hui-iconfont">&#xe616;</i> 审核编辑管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="{{ url('admin/outline_write_index') }}" data-title="编写管理" href="javascript:void(0)">编写管理</a></li>
				</ul>
				<ul>
					<li><a data-href="{{ url('admin/outline_audit_index') }}" data-title="审核管理" href="javascript:void(0)">审核管理</a></li>
				</ul>
			</dd>
		</dl>

		<dl id="menu-outline">
			<dt><i class="Hui-iconfont">&#xe616;</i> 消息通知<span class="badge badge-warning radius">{{\Illuminate\Support\Facades\Session::get('message_count')}}</span><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="{{ url('admin/outline_message_list') }}" data-title="消息列表" href="javascript:void(0)">消息列表</a></li>
				</ul>
			</dd>
		</dl>

{{--		<dl id="menu-product">--}}
{{--			<dt><i class="Hui-iconfont">&#xe620;</i> 借阅归还管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>--}}
{{--			<dd>--}}
{{--				<ul>--}}
{{--					<li><a data-href="{{ url('admin/borrow') }}" data-title="借阅归还记录" href="javascript:void(0)">借阅归还记录</a></li>--}}
{{--				</ul>--}}
{{--			</dd>--}}
{{--		</dl>--}}
{{--		<dl id="menu-comments">--}}
{{--			<dt><i class="Hui-iconfont">&#xe622;</i> 归还与丢失管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>--}}
{{--			<dd>--}}
{{--				<ul>--}}
{{--					<li><a data-href="/admin/return" data-title="归还与丢失记录" href="javascript:void(0)">归还与丢失记录</a></li>--}}
{{--				</ul>--}}
{{--			</dd>--}}
{{--		</dl>--}}
		@if(\Illuminate\Support\Facades\Session::get('jurisdiction') == 1)
		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 教师管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="{{url('admin/user')}}" data-title="用户管理" href="javascript:void(0)">用户管理</a></li>
				</ul>
			</dd>
		</dl>
		@endif

		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> <a data-href="{{url('/admin/outline_personal')}}" data-title="个人中心" href="javascript:void(0)">个人中心</a></dt>
		</dl>
{{--		<dl id="menu-member">--}}
{{--			<dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>--}}
{{--			<dd>--}}
{{--				<ul>--}}
{{--					<li><a data-href="{{url('admin/admin')}}" data-title="管理员管理" href="javascript:void(0)">用户管理</a></li>--}}
{{--				</ul>--}}
{{--			</dd>--}}
{{--		</dl>--}}
	</div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>