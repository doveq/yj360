@extends('Index.master')
@section('title'){{$column->name}} @stop

@if(!empty($columnHead))
@section('columnHead')<div id="column-head">| {{$columnHead['name']}}</div> @stop
@endif

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
          <div class="classse-box" style="height:120px;width:320px; border-top:0;background-color:{{$list->bgcolor}}">
            <div class="classes-txt" style="background-color:{{$list->bgcolor}};vertical-align:middle;">
              <a href="/topic?exam={{$list->id}}" style="color:#fff;">
              <div><h2><b>{{$list->title}}</b></h2></div>
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


