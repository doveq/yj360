@extends('Index.master')
@section('title'){{$column->name}} @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
          <div class="clear"></div>
      </div>
      <div class="clear"></div>

      <div class="classes-list">
          <table class="table-2" border="0" cellpadding="0" cellspacing="0">
         
            @if(!empty($content))
              @foreach($content as $list)
                <tr>
                    <td class="tytd">
                        <a href="/topic?exam={{$list->id}}" target="_blank">{{$list->title}}</a>
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
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function () {
});
</script>
@stop


