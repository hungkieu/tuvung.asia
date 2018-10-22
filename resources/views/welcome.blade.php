<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Laravel</title>
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
                    <h5 class="header-title">Mèo Ú</h5>
                </div>
                <div class=" col-3 float-right">
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
            <div class="home_background" style="background-image: url('{{asset('images/banner.jpg')}}')"></div>
          <div class="home_content">
            <div class="container">
              <div class="row">
                <div class="col text-center">
                  <h1 class="home_title">Học tiếng anh thật dễ dàng với Meò Ú</h1>
                  <div class="home_button">
                      <form class="uk-margin" method="POST" action="{{ route('register') }}">
                          {{ csrf_field() }}
                          <input id="name" type="hidden" name="name" value="guest-{{ $guest = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10) }}">
                          <input id="email" type="hidden" name="email" value="{{ $guest.'@g.com' }}">
                          <input id="password" value="123123" type="hidden" name="password">
                          <input id="password-confirm" value="123123" type="hidden" name="password_confirmation">
                          <button type="submit">
                            Bắt đầu ngay nào !!!
                          </button>
                        </form>
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
        <!-- intro -->
    
        <div class="intro" style="background-image: url('{{asset('images/bg6.jpg')}}')">
          <div class="container">
            <div class="row">
              <div class="col" style="color: #fff">
                <h2 class="section_title text-center pb-2">Danh mục</h2>
                 <p class="text-center  pb-3">Đến với chúng tôi sẽ được học các nội dung hấp dẫn .</p>
              </div>
              
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card">
                      <div class="card-top">
                          <img class="card-img-top" src="{{asset('images/way.jpg')}}" alt="Card image cap"/>
                          <h4 class="card-title">Từ vựng </h4>
                      </div>
                        
                        <div class="card-block">
                          <p class="card-text">Thay vì phương pháp học cổ điển học thuộc từng từ ép bộ não của chúng ta tiếp nhận , 
                            ta sẽ biến những từ ngữ quen thuộc mà nhìn là bạn có thể biết ngay tiếng anh là gì. Bạn sẽ không quên khi nó luôn thường trực hằng ngày xung quanh bạn .  </p>
                        </div>
                      </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card">
                        <div class="card-top">
                            <img class="card-img-top" src="{{asset('images/english2.jpg')}}" alt="Card image cap"/>
                            <h4 class="card-title">Ngữ pháp  </h4>
                        </div>
                        <div class="card-block">
                          <p class="card-text">
                              Ngữ pháp giống như khung xương của một cơ thể sống, giúp cho chúng ta nằm trong một khuôn khổ chính xác nhất định.
                            Bạn thấy ngữ pháp quá nhiều và không biết dùng như thế nào? <br/>
                            Mèo Ú sẽ cùng học với bạn và giúp bạn biết trong hoàn cảnh nào thì dùng từ nào phù hợp. </p>
                        </div>
                      </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 ">
                    <div class="card">
                        <div class="card-top">
                            <img class="card-img-top" src="{{asset('images/english3.jpg')}}" alt="Card image cap"/>
                            <h4 class="card-title">Topic  </h4>
                        </div>
                        <div class="card-block">
                          <p class="card-text">
                              Với đa dạng topic bạn có thể tha hồ lựa chọn chủ đề để học tập. Hoặc tự viết cho và share cho mọi người </p>
                        </div>
                      </div>
                </div>
            </div>
          </div>
        </div>
        <div class="container">
            <hr style=""/>
        </div>
        <div class="intro">
          <div class="container">
            <div class="row">
              <div class="col-lg-7 col-md-8 col-12">
                <h2 class="pb-3 text-center">Tu luyện</h2>
                <p class="">Chắc chắn rằng bạn không thể học được ngay chỉ sau vài ngày chính vì thế Mèo Ú sẽ nhắc nhở các bạn học hằng ngày. <br/><br/>
                Bạn có thể tùy chọn thời gian và ngày trong tuần để học tập. Như vậy bạn sẽ có thói quan học tiếng anh hằng ngày.</p>
              </div>
              <div class="col-lg-5 col-md-4 d-md-block d-none">
                  <img class="w-100" src="{{asset('images/panda1.jpg')}}" alt="Card image cap"/>
              </div>
            </div>

          </div>
        </div>
        <div class="container">
            <hr style="padding-bottom: 50px" />
        </div>
          <div class="contact"  style="background-image: url('{{asset('images/bg2.jpg')}}')">
    
          <div class="container">
            <div class="row justify-content-center">
    
            <div class="col-lg-6">
              <div class="contact_form_container">
                <div class="form_title">Phản hồi</div>
                <form action="" id="contact_form" class="contact_form">
                  <div class="row contact_row">
                    <div class="col-lg-6 contact_col">
                      <input type="text" class="form_input" placeholder="Name" required="required">
                    </div>
                    <div class="col-lg-6 contact_col">
                      <input type="email" class="form_input" placeholder="Email" required="required">
                    </div>
                    <div class="col-lg-12">
                      <textarea class="form_input form_text" placeholder="Message" required="required"></textarea>
                    </div>
                    <div class="col">
                      <button type="submit" class="form_button trans_200">send message</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer >
        <div class="container">
          <div class="fooer-title">
              <h5 class="pb-3 text-center">Còn chần chừ gì nữa mà không đến với chúng tôi ^^  </h5>
          </div>
            <div class="home_button">
                <form class="uk-margin" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <input id="name" type="hidden" name="name" value="guest-{{ $guest = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10) }}">
                    <input id="email" type="hidden" name="email" value="{{ $guest.'@g.com' }}">
                    <input id="password" value="123123" type="hidden" name="password">
                    <input id="password-confirm" value="123123" type="hidden" name="password_confirmation">
                    <button type="submit">
                      Bắt đầu ngay nào !!!
                    </button>
                  </form>
            </div>
        </div>
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
