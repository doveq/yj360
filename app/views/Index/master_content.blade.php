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
  <body role="document">z
      <div id="site-head">
          <div class="">
              <a id="site-logo" href="/"><img src="/assets/img/logo.jpg" /></a>

              <ul id="site-nav">
                <li><a href="/">音基考级初级</a></li>
              </ul>
              <ul id="site-nav">
                @if(Auth::check())
                <li><a href="/profile">{{Auth::user()->name}}</a></li>
                <li><a href="/logout">退出</a></li>
                @else
                <li><a href="/login">登陆</a></li>
                @endif
            </ul>
          </div>
      </div>

      @yield('content')


      @yield('js')

      <div id="footer" class="wrap">
        关于我们
      </div>
  </body>
</html>