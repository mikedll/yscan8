<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>YScan8</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css"/>
    <script src="/js/app.js"></script>

    @yield('head')
    
  </head>
  <body>

    <div class="container root-container">

      <div id="main-container">
      </div>

      <div class="row" >
        <div class="col footer" >
          Copyright (c) 2019 <a href="http://mikedll.netlify.com/" target="_blank">Michael Rivera</a>
          |
          <a href="https://github.com/mikedll/yscan8" target="_blank"><i class="fab fa-github" ></i> Source Code</a>
          
        </div>
      </div>

    </div>

  </body>
</html>
