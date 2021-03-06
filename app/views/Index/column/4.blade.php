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
      <div class="classes-list">
        @if (!empty($questions))
          @foreach ($questions as $list)
            <div style="background-color: #fff;
            overflow: hidden;
            width:136px;
            height:184px;
            float:left;
    border: 1px solid #ddd;
    border-radius: 4px;
    display: block;
    line-height: 1.42857;
    margin-bottom: 20px;
    margin-left:10px;
    padding: 4px;">
              <a href="/topic?id={{$list['id']}}&fromColumn={{$column->id}}" target="_blank">
                <img src="{{$list['img_url']}}" width="136" height="136" style="vertical-align:middle;"/>
              </a>
              <div class='label' style="padding:9px;text-align:center;">
                <h4>{{$list['txt']}}</h4>
              </div>
            </div>
          @endforeach
        @endif
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


