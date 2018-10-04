<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Laravel</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
  <div id="app">
    <form class="uk-margin" method="POST" action="{{ route('register') }}">
      {{ csrf_field() }}
      <input id="name" type="hidden" name="name" value="guest-{{ $guest = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10) }}">
      <input id="email" type="hidden" name="email" value="{{ $guest.'@g.com' }}">
      <input id="password" value="123123" type="hidden" name="password">
      <input id="password-confirm" value="123123" type="hidden" name="password_confirmation">
      <button type="submit">
        Dùng thử ngay!!
      </button>
    </form>
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
