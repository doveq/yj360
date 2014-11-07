@extends('Index.master')
@section('title')首页 @stop

@section('content')
<div class="container wrap">
  @include('Index.index.nav')
  <div class="wrap-right">
    <div class="tabtool">
      意见反馈
    </div>
    <div class="clear"></div>
    <div class="classes-list">
      意见反馈...
    </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop