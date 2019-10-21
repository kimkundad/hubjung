<!DOCTYPE html>
<html lang="en">
   <head>
     <html lang="{{ app()->getLocale() }}">
     <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Askbootstrap">
      <meta name="author" content="Askbootstrap">
      <link rel="icon" type="image/png" href="{{url('assets/image/learnsbuy_icon16.png')}}" sizes="16x16">
      <link rel="icon" type="image/png" href="{{url('assets/image/learnsbuy_icon32.png')}}" sizes="32x32">
      <link rel="icon" type="image/png" href="{{url('assets/image/learnsbuy_icon96.png')}}" sizes="96x96">
      <link rel="shortcut icon" href="{{url('assets/image/favicon.ico')}}">

      <title>VIDOE1 - Video Streaming Website HTML Template</title>

    @include('packag.layouts.inc-style')
    @yield('stylesheet')

   </head>
   <body id="page-top">


     @include('packag.layouts.inc-header')


      <div id="wrapper">



        @include('packag.layouts.inc-sidebar')


         <div class="single-channel-page" id="content-wrapper">











               @yield('content')
















         </div>
         <!-- /.content-wrapper -->
      </div>
      <!-- /#wrapper -->
      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
      </a>
      <!-- Logout Modal-->
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">พร้อมที่จะออกจากระบบ ?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body">เลือก "ออกจากระบบ" ด้านล่างหากคุณพร้อมที่จะจบเซสชั่นปัจจุบันของคุณ</div>
               <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                  <a class="btn btn-primary" href="{{url('logout')}}">ออกจากระบบ</a>
               </div>
            </div>
         </div>
      </div>


      <!-- JavaScripts -->
      @include('packag.layouts.inc-script')
      @yield('scripts')



   </body>
</html>
