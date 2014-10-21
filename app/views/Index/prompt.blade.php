@extends('Index.master')


@section('content')
    <div class="container wrap">
    	<div class="page-header">
			<h1>{{$title}}</h1>
		</div>
		<p style="padding:20px 0;font-size:16px;font-weight:bold;">
			{{$info}}
		</p>

		@if($url)
      	<p><a href="{{$url}}" >点击跳转返回</a></p>

      		@if($auto)
      		<script>
      			setInterval("window.location.href='{{$url}}';", 4000);
      		</script>
      		@endif

		@endif

    </div> <!-- /container -->
@stop