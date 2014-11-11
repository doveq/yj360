@extends('Index.master')
@section('title')我的收藏 @stop

@extends('Index.column.columnHead')

@section('content')
<div class="container-column wrap">
  <div class="row">
  @include('Index.column.nav')

  <div class="wrap-right">
      <div class="tabtool" style="margin-left:-30px;margin-bottom:10px;background-color:#f1f1f1;height:27px;padding-left:30px;border-bottom:1px solid #e0e0e0">
        我的收藏
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
                        <a href="/topic?id={{$v->question->id}}&column_id={{$query['column_id']}}&from=favorite" target="_blank">{{$v->question->txt}}</a>
                      @endif
                    </td>

                    <td class="tytd table-2-del"><a href="/favorite/del?column_id={{$query['column_id']}}&qid={{$v->id}}" class="tyadel">删除</a></td>
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


