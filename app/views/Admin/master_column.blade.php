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
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">用户管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/user">用户管理</a></li>
                  <li><a href="/admin/classes">班级管理</a></li>
                  <li class="divider"></li>
                  <li><a href="/admin/message">我的消息</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">科目管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/column">浏览科目</a></li>
                  <li><a href="/admin/column/create">添加科目</a></li>
                  <li class="divider"></li>
                  <li><a href="/admin/zhuanti">专题管理</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">题库管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/topic">真题题库</a></li>
                  <li><a href="/admin/topic/add">添加题目</a></li>
                  <li class="divider"></li>
                  <li><a href="/admin/uploadbank">上传题库</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">产品管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/product">浏览产品</a></li>
                  <li><a href="/admin/product/create">添加产品</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">其他 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/subject_item">科目功能项</a></li>
                  <li><a href="/admin/textbook_item">教材题库</a></li>
                  <li class="divider"></li>
                  <li><a href="/admin/feedback">反馈信息</a></li>
                  <li><a href="/admin/log">访问日志</a></li>
                </ul>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#{{Session::get('uid')}}">欢迎您,{{Session::get('uname')}}</a></li>
                <li><a href="/admin/message?status=0"><span class="icon-envelope"> </span>@if (Session::get('newmassage_count') > 0)<span class="badge">{{Session::get('newmassage_count')}}</span>@endif</a></li>
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