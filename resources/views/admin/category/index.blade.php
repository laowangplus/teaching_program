@extends('admin.public.index')

@section('css')
	<link rel="stylesheet" href="{{asset('/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css') }}" type="text/css">
@endsection

@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 产品分类 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<table class="table">
	<tr>
		<td width="200" class="va-t"><ul id="treeDemo" class="ztree"></ul></td>
		<td class="va-t"><iframe ID="testIframe" Name="testIframe" FRAMEBORDER=0 SCROLLING=AUTO width=100%  height=390px SRC="product-category-add.html"></iframe></td>
	</tr>
</table>
@endsection

@section('script')
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/zTree/v3/js/jquery.ztree.all-3.5.min.js"></script> 
<script type="text/javascript">
var setting = {
	view: {
		dblClickExpand: false,
		showLine: false,
		selectedMulti: false
	},
	data: {
		simpleData: {
			enable:true,
			idKey: "id",
			pIdKey: "pId",
			rootPId: ""
		}
	},
	callback: {
		beforeClick: function(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("tree");
			if (treeNode.isParent) {
				zTree.expandNode(treeNode);
				return false;
			} else {
				demoIframe.attr("src",treeNode.file + ".html");
				return true;
			}
		}
	}
};

var zNodes =[
	// { id:1, pId:0, name:"一级分类", open:true},
	// { id:11, pId:1, name:"二级分类"},
	// { id:111, pId:11, name:"三级分类"},
	// { id:112, pId:11, name:"三级分类"},
	// { id:113, pId:11, name:"三级分类"},
	// { id:114, pId:11, name:"三级分类"},
	// { id:115, pId:11, name:"三级分类"},
	// { id:12, pId:1, name:"二级分类 1-2"},
	// { id:121, pId:12, name:"三级分类 1-2-1"},
	// { id:122, pId:12, name:"三级分类 1-2-2"},
	// { id:1221, pId:122, name:"三级分类 1-2-2-1"},
	// { id:12221, pId:1221, name:"三级分类 1-2-2-2-1"},
	@foreach($categorys as $category)
	{ id:{{ $category->id }}, pId:{{ $category->pid }}, name:"{{ $category->classname }}", open:true},
	@endforeach
];
		
var code;
		
function showCode(str) {
	if (!code) code = $("#code");
	code.empty();
	code.append("<li>"+str+"</li>");
}
		
$(document).ready(function(){
	var t = $("#treeDemo");
	t = $.fn.zTree.init(t, setting, zNodes);
	demoIframe = $("#testIframe");
	//demoIframe.on("load", loadReady);
	var zTree = $.fn.zTree.getZTreeObj("tree");
	//zTree.selectNode(zTree.getNodeByParam("id",'11'));
});
</script>
@endsection