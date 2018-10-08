<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link href="{{ asset('css/uikit.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script type="text/javascript">
    window.Laravel = {
      csrf_token: "{{ csrf_token() }}",
      user: {
        id: "{{ Auth::user()->id }}",
        name: "{{ Auth::user()->name }}",
        avatar: "{{ Auth::user()->avatar }}",
      }
    }
  </script>
</head>
<body>
  @yield('content')
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/uikit.js') }}"></script>
  <script src="{{ asset('js/uikit-icon.js') }}"></script>
</body>
</html>
