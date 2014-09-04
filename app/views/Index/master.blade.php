<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '首页')</title>

    <link href="/assets/css/index.css" rel="stylesheet">
    @yield('css')
  </head>
  <body role="document">
     

      @yield('content')

    
      <script type="text/javascript" src="/assets/jquery/jquery-1.11.1.min.js"></script>
      @yield('js')
  </body>
</html>