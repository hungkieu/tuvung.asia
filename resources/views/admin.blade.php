@extends('layouts.app')
@section('title', 'Quan tri')
@section('css')
  <link href="{{ asset('css/uikit.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection
@section('content')
  <div id="admin">
    <nav class="uk-navbar-container sosd-background-primary" uk-navbar>
      <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li class="uk-margin-left">
              <router-link to="/admin">
                <h3 class="sosd-color-white">
                  Dashboard
                </h3>
              </router-link>
            </li>
        </ul>
      </div>
    </nav>

    <div uk-grid>
      <div class="uk-width-1-5 sosd-background-white" uk-height-viewport="expand: true">
        <ul class="uk-padding-small uk-nav-default uk-nav-parent-icon" uk-nav>
          <li>
            <router-link to="/admin/users">
              Quản lý người dùng
            </router-link>
          </li>
          <hr>
          <li>
            <router-link to="/admin/vocabularies">
              Quản lý từ vựng
            </router-link>
          </li>
          <hr>
          <li class="uk-parent">
            <a href="#">Quản lý cấu trúc câu</a>
            <ul class="uk-nav-sub">
              <li>
                <router-link :to="{ name: 'new_structure_sentences' }" >
                  Tạo mới
                </router-link>
              </li>
              <li><a href="#">Tạo nhóm cấu trúc</a></li>
            </ul>
          </li>
        </ul>
      </div>

      <div class="uk-width-4-5">
        <div class="uk-margin-top">
          <router-view :key="$route.path"></router-view>
        </div>
      </div>
    </div>

  </div>
@endsection

@section('js')
  <script src="{{ asset('js/admin.js') }}"></script>
  <script src="{{ asset('js/uikit.js') }}"></script>
  <script src="{{ asset('js/uikit-icon.js') }}"></script>
@endsection
