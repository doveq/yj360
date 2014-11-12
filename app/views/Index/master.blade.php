<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '首页')</title>

    <link href="/assets/css/index.css" rel="stylesheet">
    @yield('css')

    <script type="text/javascript" src="/assets/jquery/jquery-1.11.1.min.js"></script>
    @yield('headjs')
  </head>
  <body role="document">
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
                    <a href="/feedback" id="site-fk">问题反馈</a>
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

      <div id="footer">
        <div  class="wrap">
          <ul class="footer-links">
            <li><a href="/about">关于我们</a></li>
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
          </ul>
          <div class="clear"></div>
        </div>
      </div>
  </body>
</html>