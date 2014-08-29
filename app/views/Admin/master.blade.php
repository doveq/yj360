<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '后台管理')</title>

    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/admin.css" rel="stylesheet">
    @yield('css')
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
            <a class="navbar-brand" href="/admin">音基360</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="/admin/userList">用户管理</a></li>
              <li><a href="#contact">Contact</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#{{Session::get('uid')}}">{{Session::get('uname')}}</a></li>
                <li><a href="/logout">退出</a></li>
            </ul>

          </div><!--/.nav-collapse -->
        </div>
      </div>
      @show

      @yield('content')

    
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="/assets/jquery/jquery-1.11.1.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
      @yield('js')
  </body>
</html>