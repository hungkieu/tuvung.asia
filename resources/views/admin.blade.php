@extends('layouts.app')
@section('title', 'Quản trị')
@section('css')
  <link href="{{ asset('css/uikit.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection
@section('content')
  <div id="admin">
    <nav class="uk-navbar-container sosd-background-primary" uk-navbar style="height: 50px">
      <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li class="uk-margin-left">
              <router-link to="/admin">
                <h4 class="sosd-color-white">
                  Dashboard
                </h4>
              </router-link>
            </li>
        </ul>
      </div>
      <div class="uk-navbar-right uk-margin-right ">
          <router-link to="/">
            <h4 class="sosd-color-white">
             Trang chủ
            </h4>
          </router-link>
        
      </div>
    </nav>

    <div uk-grid>
      <div class="uk-width-1-5 sosd-background-white" uk-height-viewport="expand: true">
        <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
          <li>
              <router-link to="/admin/dashboard">
              Dashboard
            </router-link>
          </li>
          <hr class="m-0" />
          <li>
            <router-link to="/admin/users">
              Quản lý người dùng
            </router-link>
          </li>
          <hr class="m-0" />
          <li>
            <router-link to="/admin/vocabularies">
              Quản lý từ vựng
            </router-link>
          </li>
          <hr class="m-0" />
          {{-- <li class="uk-parent">
            <a href="#">Quản lý cấu trúc câu</a>
            <ul class="uk-nav-sub">
              <li>
                <router-link :to="{ name: 'new_structure_sentences' }" >
                  Tạo mới
                </router-link>
              </li>
              <li><a href="#">Tạo nhóm cấu trúc</a></li>
            </ul>
          </li> --}}
          <li class="uk-parent">
            <a href="#">Quản lý ngữ pháp</a>
            <ul class="uk-nav-sub">
              <li>
                <router-link :to="{ name: 'indexStructure' }" >
                  Cấu trúc câu
                </router-link>
              </li>
              <li>
                <router-link :to="{ name: 'indexCategoryStructure' }" >
                  Danh mục
                </router-link>
              </li>
            </ul>
          </li>
          <hr class="m-0" />
        </ul>
      </div>

      <div class="uk-width-4-5 pl-3">
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
