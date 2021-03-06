@extends('Index.master')
@section('title')我的收藏 @stop

@section('content')
<div class="container-column wrap">
  @include('Index.profile.nav')


  <div class="wrap-right">
      <table class="table-2" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th colspan="2">我的收藏</th>
        </tr>

        @if(!empty($list))
          @foreach($list as $k => $v)
            <tr>
                <td class="tytd">
                  @if(empty($v->question->txt))
                    该题已下架
                  @else
                  <a href="/topic?id={{$v->question->id}}" target="_blank">{{$v->question->txt}}</a>
                  @endif
                </td>
                <td class="tytd table-2-del"><a href="/favorite/del?qid={{$v->question_id}}" class="tyadel">删除</a></td>
            </tr>
            <tr><td colspan="2">
                <div class="table-2-sp"></div>
            </td></tr>
          @endforeach
        @endif
        
      </table>
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


