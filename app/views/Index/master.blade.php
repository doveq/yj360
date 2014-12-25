<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>音基360_音基考级_音基考试_小学音乐测评_中学音乐测评_免费题库</title>
    <meta name="Keywords" content="全国音乐等级考试,音基题库,音基360,音基考级,音基考试免费题库,小学音乐测评,中学音乐测评,音乐题库,音基考试,音乐测评题库,趣味游戏" />
    <meta name="Description" content="音基360（www.yinji360.com）免费提供音基考试题库,小学音乐测评,中学音乐测评,趣味游戏等。从音基教材基础知识学习、知识点测评到模拟真实考场，完善了学习中的每一个环节，通过学、练、测三个环节完美实现网络教学目标。" />
    <link href="/assets/css/index.css" rel="stylesheet">
    @yield('css')

    <script type="text/javascript" src="/assets/jquery/jquery-1.11.1.min.js"></script>
    @yield('headjs')
  </head>
  <body role="document" @if($_SERVER["REQUEST_URI"] != '/') oncontextmenu="return false" @endif >

  <div class="wrapper">
      <div id="site-head">
          <div class="wrap">
              <a id="site-logo" href="/"><img src="/assets/img/logo.png" /></a>
              @yield('columnHead')

              <ul id="site-nav">
                <!--
                <li {{ends_with(Request::url(),'.com')?"class='stite-nav-select'":''}}><a href="/">首页</a></li>
                <li {{ends_with(Request::url(),'indexColumn')?"class='stite-nav-select'":''}}><a href="/indexColumn">音基考级</a></li>
                <li {{ends_with(Request::url(),'indexSchool')?"class='stite-nav-select'":''}}><a href="/indexSchool">中小学音基</a></li>
                <li {{ends_with(Request::url(),'interestTest')?"class='stite-nav-select'":''}}><a href="/interestTest">趣味测评</a></li>
                <li {{ends_with(Request::url(),'app')?"class='stite-nav-select'":''}}><a href="/app">APP下载</a></li>
                <li {{ends_with(Request::url(),'product')?"class='stite-nav-select'":''}}><a href="/product">产品商店</a></li>
                -->
              </ul>

              <div id="site-right">
                <div id="site-right-info">
                  @if(Auth::check())
                    @if(Session::get('utype') == 0)
                    <a href="/profile/up" style="color:#e6d65c;">升级教师</a>
                    <span class="sp" style="color:#e6d65c;">|</span>
                    @endif
                    <a href="/notice/list?type=1" style="color:#e6d65c;">帮助手册</a>
                    <span class="sp" style="color:#e6d65c;">|</span>
                    <?php
                    $unreadreplycount = FeedbackUser::unreadreplycount(Session::get('uid'));
                    ?>
                    <a href="/feedback" id="site-fk">问题反馈 @if($unreadreplycount>0)({{$unreadreplycount}})@endif</a>
                    <span class="sp" style="color:#e6d65c;">|</span>
                    <a href="/profile" id="site-ubg">{{Session::get('uname')}} (@if(Session::get('utype') == -1)管理员@elseif(Session::get('utype') == 1)老师@else学生@endif)</a>
                    <span class="sp">|</span>
                    <a href="/logout">退出</a>
                  @else
                    <a href="/register">注册</a>
                    <span class="sp">|</span>
                    <a href="/login">登录</a>
                  @endif
                </div>
                <!--
                <div id="bzfk">
                    <a href="/help"><img src="/assets/img/bzfk.jpg" /></a>
                </div>
                -->
              </div>
          </div>
      </div>

      @yield('content')

      <div class="clear"></div>
      <div class="footer-push"></div>
      
    </div><!-- wrapper -->

    <div id="footer">
      <div  class="wrap">
        <ul class="footer-links">
          <li>
            <div>小学教师群:249878625</div>
            <div>中学教师群:249878648</div>
          </li>
          <li>
            <div>音基教师群:347576642</div>
            <div>家长群:283516538</div>
          </li>
          <li>商务合作QQ:37716890</li>
          <li><a href="tencent://message/?uin=1302473868">在线客服</a><img width="18" src="/assets/img/qq.png" style="float:right;padding-right:5px;" /></li>
          <!--
          <li><span class="footer-sp">|</span></li>
          <li><a href="/link">联系我们</a></li>
          <li><span class="footer-sp">|</span></li>
          <li><a href="/feedback">意见反馈</a></li>
          <li><span class="footer-sp">|</span></li>
          <li>
            <div class="footer-follow">关注我们</div> 
            <a class="footer-follow" href=""><img src="/assets/img/sina.png"></a> 
            <a class="footer-follow" href=""><img src="/assets/img/renren.png"></a>
          </li>
          -->
        </ul>
        <ul class="footer-links" style="float:right;">
            <li>京ICP备14036259号-1</li>
        </ul>
        <div class="clear"></div>
      </div>
    </div>

    <script type="text/javascript">
      $("#column-head").hover(
        function () {
          $("#column-head-list").show();
        },
        function () {
          $("#column-head-list").hide();
        }
      );
    </script>

    @yield('js')
    

    <noscript><iframe src="*.html"></iframe></noscript>

    <script type="text/javascript">
    var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F33052c1a3ea5668c69b1ccee9c3f6e7c' type='text/javascript'%3E%3C/script%3E"));
    </script>

  </body>
</html>