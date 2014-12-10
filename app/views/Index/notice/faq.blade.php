@extends('Index.master')
@section('title'){{$typeEnum[$query['type']]}} @stop
@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
    @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
        <span class="tab-bar"></span>
        <span class="tab-title">{{$typeEnum[$query['type']]}}</span>
        <!--
        <span class="tab-btn">
          <a href="/classm/add_class?column_id=" class="tabtool-btn">加入班级</a>
        </span>
        -->
      </div>
      <div class="clear"></div>

      <div class="notice-list">
          @if(!empty($list))
          @foreach($list as $v)
          <div class="notice-item">
            <div class="notice-lt"><a href="/notice/show?id={{$v->id}}@if(!empty($query['column_id']))&column_id={{$query['column_id']}}@endif" target="_blank">{{$v->title}}</a></div>
            <div class="notice-lc">{{str_limit(strip_tags($v->content), $limit = 100, $end = '...')}}</div>
            <ul class="notice-tools">
              <li class="notice-tools-t">{{$v->created_at}}</li>
            </ul>
          </div>
          <div class="notice-sp"></div>
          @endforeach

          <div style="text-align:right;">
            {{$list->appends($query)->links()}}
          </div>
          @endif
      </div>

  </div>
  <div class="clear"></div>
</div> <!-- /container -->
</div>
@stop



