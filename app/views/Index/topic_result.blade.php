@extends('Index.master')
@section('title')首页 @stop

@section('content')
    <div class="container wrap">
        <div id="topic-rt">
            答题完毕！目前总得分：{{$scores}} 分！
        </div>
        <div id="topic-rc">
            <p>您本次答题共答对{{$rightNum}}题，答错{{$errorNum}}题。@if($errorNum > 0) 分别是：@endif </p>

            @if($errorNum > 0)
            	<div style="padding:10px 0;">
            	@foreach($list as $k => $v)
            		@if($v['is_true'] != 1)
            		<a class="topic-rcit" href="/topic?id={{$v['qid']}}" target="_blank" >第{{$k+1}}题</a>
            		@endif
            	@endforeach
            	</div>
            @endif
        </div>
        <div class="clear"></div>
    </div> <!-- /container -->
@stop