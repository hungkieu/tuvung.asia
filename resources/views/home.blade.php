@extends('layouts.app')
@section('title', 'tuvung.asia')
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
          @if($user->role == 'guest')
            <li class="uk-active uk-margin-right">
                <router-link to="/login">
                  <span class="sosd-color-white">Đăng nhập</span>
                 </router-link>
            </li>
            <li class="uk-active uk-margin-right">
                <router-link to="/register">
                  <span class="sosd-color-white">Đăng ký</span>
                 </router-link>
              </li>
          @endif
          @if($user->role !== 'guest')
            <li class="uk-active uk-margin-right">
              <a class="uk-navbar-toggle sosd-color-white" uk-navbar-toggle-icon uk-toggle="target: #offcanvas-menu"></a>
            </li>
          @endif
        </ul>
      </div>
    </nav>

    <!-- Off canvas -->
    @if($user->role !== 'guest')    
      <div id="offcanvas-menu" uk-offcanvas="overlay: true; flip: true">
        <div class="uk-offcanvas-bar sosd-background-white">

          <ul class="uk-nav uk-nav-default">

            <li class="uk-nav-header text-center">

              <img src= "{{ Auth::user()->avatar }}" class="rounded-circle w-25"  />
              <b class="color-primary d-block my-3">{{ Auth::user()->name }}</b>
              
            </li>
            <li>
              <router-link to="/user-profile/{{ Auth::user()->id }}">
                <span class="uk-margin-small-right" uk-icon="icon: user"></span> Hồ sơ cá nhân
              </router-link>
            </li>
            <li class="uk-nav-divider"></li>
            <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: cog"></span> Cài đặt </a></li>
          </ul>

        </div>
      </div>
    @endif

    <!-- Main -->

    <div class="uk-container">
      <div class="uk-margin-top">
        <router-view :key="$route.path"></router-view>
      </div>
    </div>
  </div>
@endsection
