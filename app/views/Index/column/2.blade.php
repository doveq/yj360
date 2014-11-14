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
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
          <table class="table-2" border="0" cellpadding="0" cellspacing="0">

            @if(!empty($content))
              @foreach($content as $list)
                <tr>
                    <td class="tytd">
                        <a href="/topic?exam={{$list->exam_id}}&column={{$column->id}}" target="_blank">{{$list->exam->title}}</a>
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


