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
          <li class="uk-active uk-margin-right">
            <a class="uk-navbar-toggle sosd-color-white" uk-navbar-toggle-icon uk-toggle="target: #offcanvas-menu"></a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Off canvas -->

    <div id="offcanvas-menu" uk-offcanvas="overlay: true; flip: true">
      <div class="uk-offcanvas-bar sosd-background-white">

        <ul class="uk-nav uk-nav-default">
          <li class="uk-active"><a href="#">Active</a></li>
          <li class="uk-parent">
            <a href="#">Parent</a>
            <ul class="uk-nav-sub">
              <li><a href="#">Sub item</a></li>
              <li><a href="#">Sub item</a></li>
            </ul>
          </li>
          <li class="uk-nav-header">Header</li>
          <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: table"></span> Item</a></li>
          <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: thumbnails"></span> Item</a></li>
          <li class="uk-nav-divider"></li>
          <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: trash"></span> Item</a></li>
        </ul>

      </div>
    </div>

    <!-- Main -->

    <div class="uk-container">
      <div class="uk-margin-top">
        <router-view></router-view>
      </div>
    </div>
  </div>
@endsection
