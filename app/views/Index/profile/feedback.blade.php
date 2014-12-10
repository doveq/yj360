@extends('Index.master')
@section('title')我的收藏 @stop

@section('content')
<div class="container-column wrap">
  <div class="row">

  @include('Index.profile.nav')

  

  <div class="wrap-right">
      <div class="tabtool">
        <span class="tab-bar"></span>
        <span class="tab-title">问题反馈</span>
      </div>
      <div class="clear"></div>

      <form role="form" action="/feedback/dopost" method="post" enctype="multipart/form-data" >
      <table class="table-2" border="0" cellpadding="0" cellspacing="0">
    
        <tr>
            <td style="padding:10px 10px;">
              <textarea name="content" rows="5" style="width:100%;" placeholder="您可以将你的问题与联系方式写在这里"></textarea>
            </td>
        </tr>

        <tr>
            <td style="padding:10px 10px;">
              <input type="submit" value="提交" style="padding:10px 20px;background-color:#00b1bb;border:none;color:#fff;" />
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
            <span>{{$v->created_at}} 提出问题</span>
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
                <td style="width:60px;color:red;padding-right:15px;">系统回复</td>
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


