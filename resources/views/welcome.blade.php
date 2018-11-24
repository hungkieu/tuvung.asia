<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title> Học tiếng anh dễ dàng </title>
  <link rel="shortcut icon" type="image/png" href="/images/fav.png"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/welcome.css') }}">
</head>
<body>
  <div id="app">
    <div>
      <header class="header">
        <div class="container">
          <div class="row justify-content-between">
            <div class=" col-3 float-left">
              <a href="/">
                <img src="{{ asset('images/logo.png') }}" width="256px" alt="">
              </a>
            </div>
            <div class="col-3 float-right d-flex align-items-center">
              @guest
              <a href="/login">
               <button class="btn-login mr-2">Đăng nhập</button>
             </a>

             <a href="/register">
              <button class="btn-login">Đăng ký</button>
            </a>
            @else
            <button onclick="document.getElementById('logout').submit()" class="btn-login">Đăng xuất</button>
            <form id="logout" action="{{ route('logout') }}" method="post">
              {{ csrf_field()}}
            </form>
            @endguest
          </div>
        </div>
      </div>
    </header>
    <div class="banner">
      <div class="home_background"></div>
      <div class="home_content">
        <div class="container">
          <div class="row">
            <div class="col text-center">
              <h1 class="home_title">Học tiếng anh thật dễ dàng với Meohamhoc.com</h1>
              <div class="home_button">
                <div class="w-100 text-center f-g">
                  <p> Đăng nhập với </p>
                  <a href="/redirect/facebook" class="sosd-a btn-fb">
                    <i class="fa fa-facebook fa-lg " ></i>
                    <span>Facebook</span>
                  </a>
                  hoặc
                  <a href="/redirect/google" class="sosd-a btn-gg" >
                    <i class="fa fa-google fa-lg" ></i>
                    <span>Google</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="intro">
      <div class="container">
        <div class="row">
          <div class="col-5 m-auto text-center">
            <img class="w-75" src="{{asset('images/logo.jpg')}}" alt="Card image cap"/>
          </div>
          <div class="col-7">
            <div class="intro_content">
              <div class="intro_title">Làm thế nào học ngoại ngữ dễ dàng ?</div>
              <div class="intro_text">
                <p>Học mọi lúc mọi nơi .<br/>
                 Phương pháp học hiệu quả học <b> tự nhiên </b>  .<br/>
                 Học cùng Mèo Ú, bạn sẽ thấy rất vui và cuốn hút.
                 Với phương pháp tự học <b> không cần nỗ lực</b>.</p>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
    <footer>
      Liên hệ Facebook:  <a href="https://www.facebook.com/tathimyhanh03">Tạ Hạnh</a><a href="https://www.facebook.com/hungkieu.h12">Kiều Hùng</a><a href="https://www.facebook.com/thaothu.04">Thảo Thu</a>
    </footer>
  </div>

</div>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var header = $('.header');
    $(window).scroll(function() {
      if($(window).scrollTop() > 300){
        header.addClass('header-add');
      } else {
        header.removeClass('header-add');
      }
    })
  })
</script>
</body>
</html>
