<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Group Calendar | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" media="screen" href="./css/app.css" />
    @stack('css')
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    @stack('scripts')
    <script src="./js/app.js"></script>
</body>
</html>