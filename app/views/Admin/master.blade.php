<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '后台管理')</title>

    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/css/admin.css" rel="stylesheet">
    @yield('css')

    <script src="/assets/jquery/jquery-1.11.1.min.js"></script>
    @yield('headjs')
  </head>
  <body role="document">
      @section('nav')
      <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin">音基360 管理系统</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <!-- <li class="active"><a href="#">Home</a></li> -->
              <li><a href="/admin/user">用户管理</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">科目管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/subject">浏览科目</a></li>
                  <li><a href="/admin/subject/create">添加科目</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">题库管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">基础测试题库</a></li>
                  <li><a href="#">基础教材强化库</a></li>
                  <li><a href="#">基础难点解答</a></li>
                  <li><a href="/admin/topic/list">真题题库</a></li>
                  <li><a href="/admin/topic/add">添加题目</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">教材管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">浏览教材</a></li>
                  <li><a href="#">添加教材</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">产品管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">浏览产品</a></li>
                  <li><a href="#">添加产品</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">其他 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/subject_item">科目功能项</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#{{Session::get('uid')}}">欢迎您,{{Session::get('uname')}}</a></li>
                <li><a href="/logout">退出</a></li>
            </ul>

          </div><!--/.nav-collapse -->
        </div>
      </div>
      @show

      @yield('content')

      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
      @yield('js')
  </body>
</html>