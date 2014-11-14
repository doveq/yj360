@extends('Index.master')
@section('title'){{$column->name}} @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
  @include('Index.column.nav')
  <div class="wrap-right">
      <div class="tabtool">
{{$column->name}}
      </div>
      <div class="clear"></div>

      <div class="classes-list">
          @foreach ($content as $list)
          <div class="classse-box" style="height:60px;width:150px; border-top:0;background-color:{{$list->bgcolor}}">
            <div class="classes-txt" style="background-color:{{$list->bgcolor}};vertical-align:middle;">
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
</div> <!-- /container -->
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function () {
});
</script>
@stop


