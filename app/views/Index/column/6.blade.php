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
          <table class="table-2" border="0" cellpadding="0" cellspacing="0">

            @if(!empty($content))
              @foreach($content as $list)
                <tr>
                    <td class="cl tytd" style="min-width:400px;display:inline-block;">
                        <!--
                        <a href="/topic?exam={{$list->exam_id}}&column={{$column->id}}" target="_blank">{{$list->exam->title}}</a>
                        -->
                        <span style="float:left;">
                            <li style="color:#00B1BC;"><span style="color:#000;">{{$list->exam->title}}</span></li>
                        </span>
                        
                        <span style="float:right;">
                        &nbsp;&nbsp;
                        <a href="/topic?exam={{$list->exam_id}}&column={{$column->id}}" target="_blank" style="color:#00B1BC;">练习模式</a>
                        &nbsp;&nbsp;
                        <a href="/topic?exam={{$list->exam_id}}&column={{$column->id}}&real=1" target="_blank" style="color:#00B1BC;">考试模式</a>
                        </span>
                    </td>
                </tr>
                <tr><td colspan="2">
                    <div class="table-2-sp"></div>
                </td></tr>
              @endforeach
            @endif
          </table>

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


