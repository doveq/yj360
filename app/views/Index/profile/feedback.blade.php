@extends('Index.master')
@section('title')我的收藏 @stop

@section('content')
<div class="container-column wrap">

  <div class="cl tabtool" style="background-color:#fff;margin-bottom:0;border:0;">
     <span class="vm faq-tabbar"></span>
     <span class="vm"><a style="color:#c9c9c9;" href="/">首页</a><span style="color:#c9c9c9;">&nbsp;&gt;&nbsp;</span></span>
     <span class="vm tab-title">
     	<a style="color:#499528;" href="/feedback">问题反馈</a>
     </span>
  </div>

  <div class="row">

  <?php 
  $query=array('type'=>4,'column_id'=>'');
  ?>
  @include('Index.notice.nav')
  

  <div class="wrap-right">
      <form role="form" action="/feedback/dopost" method="post" enctype="multipart/form-data" style="margin-top:-10px;">
      <table class="table-2" border="0" cellpadding="0" cellspacing="0">
    
        <tr>
            <td style="padding:10px 0 10px 10px;">
              <textarea name="content" rows="5" style="width:100%;" placeholder="您可以将你的问题与联系方式写在这里"></textarea>
            </td>
        </tr>

        <tr>
            <td style="padding:0 0 0 10px;">
              <input type="submit" value="提交" style="padding:5px 20px;background-color:#00b1bb;border:none;color:#fff;" />
            </td>
        </tr>

      </table>
      </form>
      <div class="clear"></div>
      <br>

      @if(!empty($list))
      @foreach($list as $v)
      <div class="fbitem">
        <div class="fbitit">
            <span>{{$v->created_at}} 我提出的问题</span>
            @if(!empty($v->reply))
            <span class="fbiok">已解决</span>
            @endif
        </div>
        <div class="fbisp-1"></div>
        <div class="fbicon">{{$v->content}}</div>

        @if(!empty($v->reply))
        <div class="fbisp-2"></div>
        <div class="fbireply">
          <table>
            <tr>
                <td style="width:100px;color:red;padding-right:15px;">客服雯雯回答：</td>
                <td>{{$v->reply}}</td>
            </tr>
          </table>
        </div>
        @endif
      </div>
      @endforeach

      <div style="text-align:right;">
        {{$list->links()}}
      </div>
      @endif
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


