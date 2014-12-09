@extends('Index.master')
@section('title'){{$typeEnum[$info->type]}} @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
        <span class="tab-bar"></span>
        <span class="tab-title">{{$typeEnum[$info->type]}}</span>
        <span style="float:right;"><a style="color:#499528;" href="/notice/list?column_id={{$query['column_id']}}&type={{$info->type}}">返回 >></a> </span>
      </div>
      <div class="clear"></div>

      <div class="notice-tit">{{$info->title}}</div>
      <div class="notice-info">{{$info->created_at}}</div>
      <div class="notice-sp"></div>
      <div class="notice-con">{{$info->content}}</div>

  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
@stop



