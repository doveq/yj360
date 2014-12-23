@extends('Index.master')
@section('title')首页 @stop

@section('headjs')
<script src="/assets/layer/layer.min.js"></script>
@stop

<style>
  .gonggao{
    width:335px;
    height:220px;
    position:relative;
  }
  .gonclose {
    position:absolute ;
    top:10px;
    right:10px;
    width: 13px;
    height: 13px;
  }
  .gonbtn1{
    position:absolute;
    left:50px;
    bottom:30px;
    width: 110px;
    height: 30px;
  }
  .gonbtn2{
    position:absolute;
    left:180px;
    bottom:30px;
    width: 110px;
    height: 30px;
  }
</style>

@section('content')
    <div class="container wrap">
    	<a class="index-block" href="/"><img src="/assets/img/index-2-1.png" /></a>

        <!--
    	<a class="index-block" href="#"><img src="/assets/img/index-2.jpg" /></a>
    	<a class="index-block" href="#"><img src="/assets/img/index-3.jpg" /></a>
    	<a class="index-block" href="#"><img src="/assets/img/index-4.jpg" /></a>
    	<a class="index-block" href="#"><img src="/assets/img/index-5.jpg" /></a>
    	<div id="index-block-ksrk">

    	</div>
        -->

        <div class="index-block" id="index-login">
            <form role="form" id="dologin" action="doLogin" method="post">
            <!--
            <h1>音基360登录</h1>
            -->
            <div class="row" style="padding:0;"><img src="/assets/img/index-a4.png" /></div>
            <div class="row"><input id="login-input-name" type="text" class="text" name="name" value="" placeholder="手机号" ></div>
            <div class="row"><input id="login-input-passwd" type="password"  class="text" name="password" value="" class="form-control" placeholder="密码"> </div>
            <div class="row">
                <input type="checkbox" name="remember" id="checkbox-1" class="labelinput" /> <label for="checkbox-1">记住密码</label>
                <a href="/forgot" class="forget">忘记密码？</a>
                <div class="clear"></div>
            </div>
            <div class="row">
                <button type="submit" class="loginbntn">登 录</button>
            </div>

            <div class="row-sp"></div>

            <div class="row linetxt">
                还没有音基360账号？<a href="/register">马上注册</a>
            </div>

            </form>
        </div>

    	<div class="clear" style="height:25px;"></div>
        <a class="index-block" href="/column/static"><img src="/assets/img/index-a3.png" /></a>
        <a class="index-block" style="margin-left:25px;" style="" href="/column/static"><img src="/assets/img/index-a2.png" /></a>
        <a class="index-block" style="margin-left:25px;" href="/column/static"><img src="/assets/img/index-a1.png" /></a>

      
      	<div class="clear"></div>
    </div> <!-- /container -->


    <div id="vetting-mode" style="display:none;">
        <div class="gonggao">
            <div class="gonclose"><a href="javascript:bclose();"><img src="/assets/img/bupclose.png" /></a></div>
            <div>
                <img src="/assets/img/bupbg.png" />
            </div>
            <a class="gonbtn1" href="http://www.firefox.com.cn/" target="_blank" ><img src="/assets/img/bupbt1.png" /></a>
            <a class="gonbtn2" href="javascript:bclose();"><img src="/assets/img/bupbt2.png" /></a>
        </div>
    </div>

    <!--[if lt IE 9]>
    <script type="text/javascript">
      var ibox;
      function vetting()
      {
          ibox = $.layer({
              type : 1,
              title : false,
              shadeClose: true,
              offset:['100px' , ''],
              shade: [0],
              border: [0],
              closeBtn: [0, false],
              area : ['auto','auto'],
              page : {
                  html: $("#vetting-mode").html()
              }
          });
      }

      function bclose()
      {
         layer.close(ibox);
      }

      vetting();
    </script>
    <![endif]-->

@stop

@section('js')
<script>

$("#dologin").submit(function(){
    isok = 1;

    $(".reg-err").text("");

    mobile = $("#login-input-name").val();
    re = /^1\d{10}$/

    if( !re.test(mobile) )
    {
        $("#tel-err").text("");

        layer.tips('填写手机号登录', $('#login-input-name'), {
            time: 5,
            style: ['background-color:#F26C4F; color:#fff', '#F26C4F'],
            maxWidth:240
        });

        isok = 0;
    }

    if( $("#login-input-passwd").val() == '' )
    {
        layer.tips('必须填写密码', $('#login-input-passwd'), {
            time: 5,
            guide: 2,
            style: ['background-color:#F26C4F; color:#fff', '#F26C4F'],
            maxWidth:240
        });

        isok = 0;
    }


    if(isok == 1)
      return true;
    else
      return false;

});
</script>
@stop
