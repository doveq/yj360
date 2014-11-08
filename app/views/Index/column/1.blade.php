@extends('Index.master')
@section('title'){{$column->name}} @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  @include('Index.column.nav')
  <div class="wrap-right">
      <div class="tabtool" style="margin-left:-30px;margin-bottom:10px;background-color:#f1f1f1;height:27px;padding-left:30px;border-bottom:1px solid #e0e0e0">
{{$column->name}}
      </div>
      <div class="clear"></div>

      <div class="classes-list">
          @foreach ($content as $list)
          <div class="classse-box" style="height:100px;width:150px; border-top:0;background-color:{{$list->bgcolor}}">
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
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function () {
});
</script>
@stop


