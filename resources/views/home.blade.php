@extends('layouts.app')
@section('title', 'tuvung.asia')
@section('css')
  <link href="{{ asset('css/uikit.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection
@section('content')
  <div id="app">

    <!-- Navbar -->

    <nav class="uk-navbar-container sosd-background-primary" uk-navbar>
      <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li class="uk-margin-left">
              <router-link to="/">
                <span class="uk-text-lead sosd-color-white">
                  TuVung.Asia
                </span>
              </router-link>
            </li>
        </ul>
      </div>
      <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
            <li class="uk-active uk-margin-right">
              <a class="uk-navbar-toggle sosd-color-white" uk-navbar-toggle-icon uk-toggle="target: #offcanvas-menu"></a>
            </li>
        </ul>
      </div>
    </nav>

    <!-- Off canvas -->

      <div id="offcanvas-menu" uk-offcanvas="overlay: true; flip: true">
        <div class="uk-offcanvas-bar sosd-background-white">
          <div class="pb-3">
            <img src= "{{ Auth::user()->avatar }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover"  />
            <b class="color-primary m-3">{{ Auth::user()->name }}</b>
          </div>
          <ul class="uk-nav">
            <li uk-toggle="target: #offcanvas-menu">
              <router-link to="/user-profile/{{ Auth::user()->id }}">
                <span class="uk-margin-small-right" uk-icon="icon: user"></span> Hồ sơ cá nhân
              </router-link>
            </li>
            <li uk-toggle="target: #offcanvas-menu"><router-link to="/setting/account"><span class="uk-margin-small-right" uk-icon="icon: cog"></span> Cài đặt </router-link></li>
            <li class="uk-nav-default"><span class="uk-nav-divider d-block"></span></li>
            <li uk-toggle="target: #offcanvas-menu"><router-link to="/login"><span class="uk-margin-small-right" uk-icon="icon: sign-out"></span> Đăng xuất </router-link></li>
          </ul>

        </div>
      </div>

    <!-- Main -->

    <div class="uk-container">
      <div class="uk-margin-top">
        <router-view :key="$route.path"></router-view>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/uikit.js') }}"></script>
  <script src="{{ asset('js/uikit-icon.js') }}"></script>
@endsection
