<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GroupCalendar | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#00aba9">
    <meta name="theme-color" content="#ffffff">

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
  <script>
    window.GroupCalendar = window.GroupCalendar || {};
    @auth
    GroupCalendar.defaultMixin = {
      data: function(){
        return {
          currentUser: @json(Auth::user()->append('all_notifications')->toArray()),
          currentUnreadCount: @json(Auth::user()->all_unread_notifications->count()),
          navbarMenuActive: false
        };
      },
      methods: {
        onNavbarButtonToggle(isActive){
          this.navbarMenuActive = isActive;
        }
      }
    };
    @else
    GroupCalendar.defaultMixin = {};
    @endauth
  </script>
  @hasSection ('page_scripts')
    @yield('page_scripts')
  @else
    <script>
      GroupCalendar.app = new Vue({
        el: '#app',
        mixins: [GroupCalendar.defaultMixin],
        mounted: function(){
          console.log("default root app mounted");
        }
      });
    </script>
  @endif

  @stack('extra_scripts')

</body>
</html>