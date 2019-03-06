<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Group Calendar | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />
    @stack('css')
</head>
<body>

  {{-- remove vue js #app and script --}}
  <div id="app">
    @include('layouts.header')
    <main id="app-body">
      @yield('content')
    </main>
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
  @hasSection ('page_scripts')
    @yield('page_scripts')
  @else
    <script>
      const GroupCalendar = {};
      GroupCalendar.app = new Vue({
        el: '#app',
        mounted: function(){
          console.log("default root app mounted");
        }
      });
    </script>
  @endif

  @stack('extra_scripts')

</body>
</html>