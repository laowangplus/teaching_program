<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>LaoWang`PLUS</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
  </head>
  <style>
    body {
        padding-top: 70px;
        background-color: #F6F7F9;
    }
    nav .navbar-header a{
        font-size: 20px;
    }
    nav p{
        font-size: 13px;
    }
    nav .navbar-collapse ul li a{
        padding: 5px 10px 5px 10px;
        margin: 10px 5px 10px 5px;
        background-color: #ffffff;
    }
    nav .navbar-collapse ul li a:hover{
        background-color: #000000;
    }
    #top {
        background-color: #ffffff;
        margin-bottom: 20px;
    }
    #top h4{
        color: gray;
    }
    #top .list-group a p{
        float: right;
        margin: 0 0 0 0;
    }
    #new {
        background-color: #ffffff;
        margin-bottom: 20px;
        padding-bottom: 20px;
    }
    #new h4{
        color: gray;
    }
    .content {
        padding: 0;
        width: 100%;
        padding-bottom: 40px;
        border-bottom: 1px dashed gray;
    }
    #tag {
        background-color: #ffffff;
        margin-bottom: 20px;
    }
  </style>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top navbar-collapse">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div>
                    <a class="navbar-brand" href="#">LaoWang`PLUS <small>coding</small></a>
                </div>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- <form class="navbar-form navbar-left">
                    <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form> -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">笔记</a></li>
                    <li><a href="#">笔记</a></li>
                    <li><a href="#">笔记</a></li>
                    <li><a href="#">笔记</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container" id="top">
        <h4>置顶</h4>
        <div class="list-group">
            <a href="#" class="list-group-item active">
                Cras justo odio
                <p>2019-11-11</p>
            </a>
            <a href="#" class="list-group-item">Dapibus ac facilisis in <p>2019-11-11</p></a>
            <a href="#" class="list-group-item">Morbi leo risus <p>2019-11-11</p></a>
            <a href="#" class="list-group-item">Porta ac consectetur ac <p>2019-11-11</p></a>
            <a href="#" class="list-group-item">Vestibulum at eros <p>2019-11-11</p></a>
        </div>
    </div>

    <div class="container" id="new">
        <h4>最新</h4>
        @foreach($articles as $article)
        <div class="container content" id="content1">
            <h2><a href="">深入理解 FastCGI 协议以及在 PHP 中的实现</a></h2>
            <p class="text-muted">周梦康 发表于 2019-11-26 | 分类于 | 378 次浏览</p>

            <div>
                {!! $article->content !!}
            </div>


            <button type="button" class="btn btn-default">继续阅读<span class="glyphicon glyphicon-arrow-right"></span></button>

        </div>
        @endforeach

        <div class="container content" id="content2">
            <h2><a href="">深入理解 FastCGI 协议以及在 PHP 中的实现</a></h2>
            <p class="text-muted">周梦康 发表于 2019-11-26 | 分类于 | 378 次浏览</p>

            <div>
                lolo
            </div>


            <button type="button" class="btn btn-default">继续阅读<span class="glyphicon glyphicon-arrow-right"></span></button>

        </div>
    </div>

    <div class="container" id="tag">
        <h4>标签集<small><span class="glyphicon glyphicon-arrow-right"></span></small></h4>
        <div class="container">
                <div class="clearfix visible-xs"></div>
            <div class="row">
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
                <span class="label label-default">php</span>
            </div>

        </div>
    </div>

    <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
  </body>
</html>