@extends('layouts.app')
@section('title', 'tuvung.asia')
@section('css')
<link href="{{ asset('css/uikit.css') }}" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection
@section('content')
<div id="app" style="overflow: hidden;">

  <!-- Navbar -->

  <div class="sosd-background-primary">
    <div class="row p-3">
      <div class="col-6 d-flex align-items-center">
        <router-link to="/"class="sosd-a">
          <b class="sosd-color-white" style="font-size: 16px;">
            TuVung.Asia
          </b>
        </router-link>
      </div>


      <div class="col-6 justify-content-end d-flex align-items-center">
        <a class="sosd-color-white" uk-toggle="target: #offcanvas-menu">
          <span uk-icon="icon: menu; ratio: 1.2"></span>
        </a>
      </div>
    </div>
  </div>


  <!-- Off canvas -->
  <div id="offcanvas-menu" uk-offcanvas="overlay: true; flip: true">
    <div class="uk-offcanvas-bar sosd-background-white">
        <div class="pb-3">
            <img src= "{{ Auth::user()->avatar }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover"  />
            <b class="color-primary m-3">{{ Auth::user()->name }}</b>
          </div>
      <ul class="uk-nav uk-nav-default">
        <li uk-toggle="target: #offcanvas-menu">
          <router-link to="/user-profile/{{ Auth::user()->id }}" class="sosd-hover-primary">
            <span class="uk-margin-small-right" uk-icon="icon: user"></span> Hồ sơ cá nhân
          </router-link>
        </li>
        <li uk-toggle="target: #offcanvas-menu">
          <router-link to="/setting/account" class="sosd-hover-primary">
            <span class="uk-margin-small-right" uk-icon="icon: cog"></span> Cài đặt
          </router-link>
        </li>
        <li class="uk-nav-divider"></li>
        <li uk-toggle="target: #offcanvas-menu">
          <form action="/logout" method="post">
            {{ csrf_field() }}
            <label for="logout" class="sosd-hover-primary">
            <span class="uk-margin-small-right" uk-icon="icon: sign-out"></span> Đăng xuất
            </label>
            <input type="submit" class="sosd-none" name="logot" id="logout">
          </form></li>
      </ul>
    </div>
  </div>

  <!-- Main -->

  <div class="pb-5">
    <router-view :key="$route.path"></router-view>
  </div>

  <footer>
    footer
  </footer>
</div>
@endsection

@section('js')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/uikit.js') }}"></script>
<script src="{{ asset('js/uikit-icon.js') }}"></script>
@endsection
