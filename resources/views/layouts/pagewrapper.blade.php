<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GroupCalendar | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/app.css')) }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#00aba9">
    <meta name="theme-color" content="#ffffff">

    @stack('css')
    <noscript>
      <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/noscript_styles.css')) }}" />
    </noscript>
</head>
<body>
  {{-- Skip to Main Content link for screenreaders --}}
  <a href="#maincontent" class="is-sr-only is-sr-only-focusable">Skip to main content</a>

  <noscript class="noscript">GroupCalendar works best with Javascript enabled.</noscript>

  <div id="app">
    @include('layouts.header')
    <main id="app-body">
      @yield('sidebars')
      @yield('content')
    </main>
  </div>

  <script src="{{ asset(mix('js/app.js')) }}"></script>
  <script>
    window.GroupCalendar = window.GroupCalendar || {};
    @auth
    GroupCalendar.defaultMixin = {
      data: function(){
        return {
          currentUser: @json(Auth::user()),
          notifications: @json(Auth::user()->all_unread_notifications),
          navbarMenuActive: false,
          asset_url: @json(env('APP_URL'))
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