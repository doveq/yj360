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
          <div class="classse-box">
            <div>
              <img src="{{Config::get('app.thumbnail_url')}}/{{$list->thumbnail}}" width="{{Config::get('app.thumbnail_width')}}" height="{{Config::get('app.thumbnail_height')}}" class="thumbnail"/>
            </div>
            <div class="classes-txt">
              <a href="/column?id={{$list->id}}&column_id={{$query['column_id']}}" style="color:#fff;">
              <div><h2><b>{{$list->name}}</b></h2></div>
              </a>
            </div>
          </div>
          @endforeach
          <div class="clear"></div>
          @if ($questions->count() > 0)
          <table class="table-2" border="0" cellpadding="0" cellspacing="0">
            @foreach($questions as $list)
              <tr>
                  <td class="tytd">
                    <a href="/topic?id={{$list->id}}" target="_blank">{{$list->txt}}</a>
                  </td>
              </tr>
              <tr><td colspan="2">
                  <div class="table-2-sp"></div>
              </td></tr>
            @endforeach
          </table>
          @endif

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


