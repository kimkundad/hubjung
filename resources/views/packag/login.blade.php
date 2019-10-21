<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Askbootstrap">
      <meta name="author" content="Askbootstrap">
      <title>เข้าสู่ระบบ learnsbuy ระบบรายเดือน</title>
      <!-- Favicon Icon -->
      <link rel="icon" type="image/png" href="{{url('assets/image/learnsbuy_icon16.png')}}" sizes="16x16">
      <link rel="icon" type="image/png" href="{{url('assets/image/learnsbuy_icon32.png')}}" sizes="32x32">
      <link rel="icon" type="image/png" href="{{url('assets/image/learnsbuy_icon96.png')}}" sizes="96x96">
      <link rel="shortcut icon" href="{{url('assets/image/favicon.ico')}}">

            <!-- Bootstrap core CSS-->
            <link href="{{url('web_stream/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
            <!-- Custom fonts for this template-->
            <link href="{{url('web_stream/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
            <!-- Custom styles for this template-->
            <link href="{{url('web_stream/css/osahan.css?v1')}}" rel="stylesheet">
            <!-- Owl Carousel -->
            <link rel="stylesheet" href="{{url('web_stream/vendor/owl-carousel/owl.carousel.css')}}">
            <link rel="stylesheet" href="{{url('web_stream/vendor/owl-carousel/owl.theme.css')}}">
   </head>
   <body class="login-main-body">
      <section class="login-main-wrapper">
         <div class="container-fluid pl-0 pr-0">
            <div class="row no-gutters">
               <div class="col-md-5 p-5 bg-white full-height">
                  <div class="login-main-left">
                     <div class="text-center mb-5 login-main-left-header pt-4">
                       <a href="{{url('japanonline')}}">
                         <img src="{{url('web_stream/img/learnsbuy_icon.png')}}" class="img-fluid" alt="โลโก้เว็บไซต์ learnsbuy" style="height:60px;">
                       </a>
                        <h5 class="mt-3 mb-3">เข้าสู่ระบบ learnsbuy <!--{{Session::get('japanonline_redirect')}}--></h5>
                        <p><b>เรียนภาษาญี่ปุ่น ออนไลน์</b> ระบบรายเดือน<br> เรียนรู้ภาษากับครูพี่โฮมแบบไม่จำกัดได้แล้ววันนี้.</p>
                     </div>
                     <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                         {{ csrf_field() }}
                        <div class="form-group">
                           <label>Email</label>
                           <input type="email" class="form-control" name="email" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                           <label>Password</label>
                           <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="mt-4">
                           <div class="row">
                              <div class="col-12">
                                 <button type="submit" class="btn btn-outline-primary btn-block btn-lg">เข้าสู่ระบบ</button>
                              </div>
                           </div>
                        </div>
                     </form>
                     <div class="text-center mt-5">
                        <p class="light-gray">ยังไม่ได้สมัครสมาชิก? <a href="{{url('japanonline/register')}}">สมัครสมาชิก</a></p>
                     </div>
                  </div>
               </div>
               <div class="col-md-7">
                  <div class="login-main-right bg-white p-5 mt-5 mb-5">
                     <div class="owl-carousel owl-carousel-login">
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="{{url('web_stream/img/learnsbuy_image.png')}}" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">ดู Video ได้ไม่จำกัด</h5>
                              <p class="mb-4">สนุกเพลิดเพลินไปกับการเรียนรู้ภาษาญี่ปุ่น ออนไลน์<br> Video การสอนที่เน้นความเข้าใจ ที่ใครๆ ก็เรียนได้ <br>คุณภาพคมชัดระดับ HD</p>
                           </div>
                        </div>
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="{{url('web_stream/img/concept-learnsbuy.png')}}" style="max-height:264px;" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">คลังข้อสอบภาษาญี่ปุ่น</h5>
                              <p class="mb-4">ข้อสอบ PAT 7.3 ภาษาญี่ปุ่น <br>  และข้อสอบวัดระดับภาษาญี่ปุ่น ติว N1 N2 N3 N4 N5 ติวไวยากรณ์ <br>ศัพท์ คันจิ การอ่าน การฟัง </p>
                           </div>
                        </div>
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="{{url('web_stream/img/login.png')}}" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">แพลตฟอร์ม Mobile App</h5>
                              <p class="mb-4">ทั้ง App Store และ Play Store<br> เรียนรู้ไปสู่ความสำเร็จกับภาษาญี่ปุ่น <br>ตอบโจทย์นักเรียนที่ต้องการความสะดวกรวดเร็วมากขึ้น บน Mobile Application</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Bootstrap core JavaScript-->
            <script src="{{url('web_stream/vendor/jquery/jquery.min.js')}}"></script>
            <script src="{{url('web_stream/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
            <!-- Core plugin JavaScript-->
            <script src="{{url('web_stream/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
            <!-- Owl Carousel -->
            <script src="{{url('web_stream/vendor/owl-carousel/owl.carousel.js')}}"></script>
            <!-- Custom scripts for all pages-->
            <script src="{{url('web_stream/js/custom.js')}}"></script>
   </body>
</html>
