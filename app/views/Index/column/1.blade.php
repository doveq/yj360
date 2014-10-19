@extends('Index.master')
@section('title'){{$column->name}} @stop

@section('content')
<div class="container-column wrap">
  @include('index.column.nav')
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
              <div><b>{{$list->name}}</b></div>
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


