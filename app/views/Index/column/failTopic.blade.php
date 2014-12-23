@extends('Index.master')
@section('title')错题记录 @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
<div class="row">
  @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool">
        错题记录
      </div>
      <div class="clear"></div>

      <div class="classes-list">
          <table class="table-2" border="0" cellpadding="0" cellspacing="0">

            @if(!empty($list))
              @foreach($list as $k => $v)
                <tr>
                    <td class="tytd">
                      @if(empty($v->question->txt))
                        该题已下架
                      @else
                        <a href="/topic?id={{$v->question->id}}&column_id={{$query['column_id']}}&from=fail" target="_blank">{{$v->question->txt}}</a>
                      @endif
                    </td>

                    <td width="80">
                      @if(!empty($v->question->type))
                      {{$typeEnum[$v->question->type]}}
                      @endif
                    </td>

                    <td class="tytd table-2-del"><a href="/failTopic/del?column_id={{$query['column_id']}}&id={{$v->id}}" class="tyadel">删除</a></td>
                </tr>
                <tr><td colspan="3">
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


