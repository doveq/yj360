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
                    <a href="/profile" id="site-ubg">{{Auth::user()->name}}</a>
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


      @yield('js')

      <div id="footer" class="wrap">
        <a class="footer-link" href="/about">关于我们</a>
        <span class="footer-sp">|</span>
        <a class="footer-link" href="/link">联系我们</a>
        <span class="footer-sp">|</span>
        <a class="footer-link" href="/feedback">意见反馈</a>
        <span class="footer-sp">|</span>
        <a class="footer-link" href="/follow">关注我们</a>
      </div>
  </body>
</html>