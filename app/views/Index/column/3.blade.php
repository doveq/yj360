@extends('Index.master')
@section('title'){{$column->name}} @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  @include('Index.column.nav')


  <div class="wrap-right">
      <div class="tabtool">
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
          @foreach ($content as $list)
          <div class="classse-box">
            <div>
              <img src="{{Config::get('app.thumbnail_url')}}/{{$list->thumbnail}}" width="{{Config::get('app.thumbnail_width')}}" height="{{Config::get('app.thumbnail_height')}}" class="thumbnail"/>
            </div>
            <div class="classes-txt">
              <a href="/topic?column={{$list->id}}" style="color:#fff;">
              <div><h2><b>{{$list->name}}</b></h2></div>
              </a>
            </div>
          </div>
          @endforeach
          <div class="clear"></div>
      </div>
  </div>
  <div class="clear"></div>
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function () {
});
</script>
@stop


