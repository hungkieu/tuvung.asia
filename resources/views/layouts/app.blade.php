<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" type="image/png" href="/images/fav.png"/>
  <title>@yield('title')</title>
  @yield('css')
  <script type="text/javascript">
    window.Laravel = {
      csrf_token: "{{ csrf_token() }}",
      @if(Auth::user())
        user: {
          id: "{{ Auth::user()->id }}",
          name: "{{ Auth::user()->name }}",
          avatar: "{{ Auth::user()->avatar }}",
          target_score: "{{ Auth::user()->target_score }}"
        }
      @endif
    }
  </script>
</head>
<body>
  @yield('content')
  @yield('js')
</body>
</html>
