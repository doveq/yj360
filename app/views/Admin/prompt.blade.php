@extends('Admin.master')


@section('content')
    <div class="container">
    	<div class="page-header">
			<h1>{{$title}}</h1>
		</div>
		<p class="lead">
			{{$info}}
		</p>

		@if($url)
      	<p><a href="{{$url}}">点击跳转返回</a></p>

      		@if($auto)
      		<script>
      			setInterval("window.location.href='{{$url}}';", 4000);
      		</script>
      		@endif

		@endif

    </div> <!-- /container -->
@stop