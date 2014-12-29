@extends('Index.master')
@section('title'){{$column->name}} @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
  @include('Index.column.nav')
  <div class="wrap-right">
      <div class="tabtool">
      <span class="tab-bar"></span>
      <span style="color:#499528;">{{$column->name}}</span>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
          @foreach ($content as $list)
          <div class="tmbox" style="background-color:{{$list->bgcolor}}">
            <div class="tmbox-txt" style="background-color:{{$list->bgcolor}};">
              <a href="/topic?column={{$list->id}}">
              {{$list->name}}
              </a>
            </div>
            <div class="clear"></div>
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


