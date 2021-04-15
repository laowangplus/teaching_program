@extends('admin.public.index')

@section('css')
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://fonts.googleapis.com/css?family=Lexend+Deca&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('/admin/animation/css/mwgbqon.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('/admin/animation/css/splitting.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('/admin/animation/css/style.css')}}"/>
<title>登录--教学大纲管理系统</title>
@endsection


@section('content')
	<h3 data-splitting class="headline headline--ghost">教学大纲管理系统</h3>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('/admin/animation/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admin/animation/js/splitting.min.js') }}"></script>
@endsection