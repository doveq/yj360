@extends('Index.master')
@section('title')错题记录 @stop

@section('content')
<div class="container-column wrap">
  <div style="padding:10px;"></div>
  @include('Index.profile.nav')


  <div class="wrap-right">
      <form role="form" action="doProfile" method="post" enctype="multipart/form-data" >
      <table class="table-2" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th colspan="2">错题记录</th>
        </tr>

        @if(!empty($list))
          @foreach($list as $k => $v)
            <tr>
                <td class="tytd">
                  @if(empty($v->question))
                    该题已下架
                  @else
                    <a href="/topic?id={{$v->question->id}}" target="_blank">{{$v->question->txt}}</a>
                  @endif
                </td>
                
                <td class="tytd table-2-del"><a href="/result/del?id={{$v->id}}" class="tyadel">删除</a></td>
            </tr>
            <tr><td colspan="2">
                <div class="table-2-sp"></div>
            </td></tr>
          @endforeach
        @endif
        
      </table>
      </form>
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


