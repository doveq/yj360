@extends('Index.master')
@section('title'){{$column->name}} @stop

@section('content')
<div class="container-column wrap">
  @include('Index.column.nav')
  <div class="wrap-right">
      <div class="tabtool" style="margin-left:-30px;margin-bottom:10px;background-color:#f1f1f1;height:27px;padding-left:30px;border-bottom:1px solid #e0e0e0">
{{$column->name}}
      </div>
      <div class="classes-list">
          @foreach ($questions as $list)
            <div style="background-color: #fff;
            float:left;
    border: 1px solid #ddd;
    border-radius: 4px;
    display: block;
    line-height: 1.42857;
    margin-bottom: 20px;
    width:25%;
    margin-left:10px;
    padding: 4px;">
              <a href="/topic?id={{$list->id}}" target="_blank"><img src="{{$list->img_url}}" width="100%" height="{{Config::get('app.thumbnail_height')}}" style="vertical-align:middle;"/></a>
              <div class='label' style="padding:9px;">
                <h4>{{$list->txt}}</h4>
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


