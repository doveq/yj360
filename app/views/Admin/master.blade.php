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
              

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">题库管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/topic">原始题库</a></li>
                  <li><a href="/admin/sort">题库分类</a></li>
                  <li class="divider"></li>
                  <li><a href="/admin/topic/add?type=1">添加题目</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">试卷管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/examSort">试卷分类管理</a></li>
                  <li class="divider"></li>
                  <li><a href="/admin/examPaper">试卷列表</a></li>
                  <li><a href="/admin/examPaper/add">添加试卷</a></li>
                </ul>
              </li>
              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">科目管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/column">浏览科目</a></li>
                  <li><a href="/admin/column/create">添加科目</a></li>
                  <li class="divider"></li>
                </ul>
              </li>

              

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">产品管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/product">浏览产品</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">用户管理 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/user">用户管理</a></li>
                  <li><a href="/admin/classes">班级管理</a></li>
                  <li class="divider"></li>
                  <li><a href="/admin/message">我的消息</a></li>
                  <li><a href="/admin/favorite">我的收藏</a></li>
                  <li class="divider"></li>
                  <li><a href="/admin/uploadbank">上传题库</a></li>
                  <li><a href="/admin/training">教师训练集</a></li>
                  <li class="divider"></li>
                  <li><a href="/admin/teacher">教师信息管理</a></li>
                  <li><a href="/admin/student">学生信息管理</a></li>
                </ul>
              </li>
              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">其他 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/admin/feedback">反馈信息</a></li>
                  <li><a href="/admin/log">访问日志</a></li>
                  <li><a href="/admin/notice">帮助公告</a></li>
                  <li><a href="/admin/notice/allcomment">查看所有评论</a></li>
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

      @yield('content')

      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
      @yield('js')
  </body>
</html>