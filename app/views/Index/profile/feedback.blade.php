@extends('Index.master')
@section('title')我的收藏 @stop

@section('content')
<div class="container-column wrap">
  <div style="padding:10px;"></div>
  @include('Index.profile.nav')


  <div class="wrap-right">
      <form role="form" action="/feedback/dopost" method="post" enctype="multipart/form-data" >
      <table class="table-2" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th style="background-color:#f1f1f1;"><img src="/assets/img/wtfkt.png"></th>
        </tr>

        <tr>
            <td style="padding:10px 0;">
              <textarea name="content" rows="5" style="width:100%;" placeholder="您可以将你的问题与联系方式写在这里"></textarea>
            </td>            
        </tr>
        
        <tr>
            <td>
              <input type="submit" value="提交" style="padding:10px 20px;background-color:#00b1bb;border:none;color:#fff;" />
            </td>            
        </tr>

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


