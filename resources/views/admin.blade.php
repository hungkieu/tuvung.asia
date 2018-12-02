@extends('layouts.app')
@section('title', 'Quản trị')
@section('css')
  <link href="{{ asset('css/uikit.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection
@section('content')
  <div id="admin">
    <nav class="uk-navbar-container sosd-box-shadow" uk-navbar style="height: 50px; background: #fff; color: black">
    <Flash></Flash>
      <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li class="uk-margin-left">
              <router-link to="/admin/dashboard">
                <img src="{{ asset('images/fav.png') }}" width="40" alt="">
                <h4 class="uk-text-emphasis mb-0 ml-3">
                  Dashboard
                </h4>
              </router-link>
            </li>
        </ul>
      </div>
      <div class="uk-navbar-right uk-margin-right ">
        <a href="/">
          <span style="color: black">
           Trang chủ
         </span>
       </a>
       <hr style="width: 1px; height: 15px; background: #292b2c; margin: 0 10px " />
       <form action="/logout" method="post">
        {{ csrf_field() }}
        <label for="logout" class="uk-text-emphasis mb-0" style="cursor: pointer">
          {{-- <span class="uk-margin-small-right" uk-icon="icon: sign-out"></span>  --}}
          Đăng xuất
        </label>
        <input type="submit" class="sosd-none" name="logot" id="logout">
      </form>
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
