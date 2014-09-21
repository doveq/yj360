<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '后台管理')</title>
    {{ HTML::style('/assets/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('/assets/css/font-awesome.min.css') }}
    {{ HTML::style('/assets/bootstrap/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::style('/assets/css/admin.css') }}
    @yield('css')

    {{ HTML::script('/assets/jquery/jquery-1.11.1.min.js') }}
    @yield('headjs')

  </head>
  <body role="document">
      @section('menu')
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
                  <li><a href="#">真题题库</a></li>
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

      <div class="container theme-showcase" role="main">
          <div class="row">
              <div class="col-md-2">
                  @yield('nav')
              </div>
              <div class="col-md-10">
                  @yield('content')
              </div>
          </div>
      </div>


      <!-- Include all compiled plugins (below), or include individual files as needed -->
      {{ HTML::script('/assets/bootstrap/js/bootstrap.min.js') }}
      <!-- datapicker plugin -->
      {{ HTML::script('/assets/bootstrap/js/bootstrap-datetimepicker.min.js') }}
      {{ HTML::script('/assets/bootstrap/js/bootstrap-datetimepicker.zh-CN.js') }}

      @yield('js')
  </body>
</html>