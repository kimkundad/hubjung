@extends('packag.layouts.single-channel')

@section('stylesheet')

@stop('stylesheet')

@section('content')

<style>
.z-1 {
    font-size: 14px;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
.t-l{
  padding-left: 8px;
}
</style>

<?php
      function DateThai($strDate)
      {
      $strYear = date("Y",strtotime($strDate))+543;
      $strMonth= date("n",strtotime($strDate));
      $strDay= date("j",strtotime($strDate));
      $strHour= date("H",strtotime($strDate));
      $strMinute= date("i",strtotime($strDate));
      $strSeconds= date("s",strtotime($strDate));
      $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
      $strMonthThai=$strMonthCut[$strMonth];
      return "$strDay $strMonthThai $strYear";
      }
       ?>

<div class="single-channel-image">
               <img class="img-fluid" alt="" src="{{url('assets/images/channel-banner.png')}}">
               <div class="channel-profile">
                  <img class="channel-profile-img" alt="" src="{{url('assets/images/avatar/'.Auth::user()->avatar)}}">

               </div>
            </div>

<div class="single-channel-nav">
               <nav class="navbar navbar-expand-lg navbar-light">
                  <a class="channel-brand" href="#">{{Auth::user()->name}} <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                           <a class="nav-link" href="{{url('account')}}">My Package </a>
                        </li>
                        <li class="nav-item active">
                           <a class="nav-link" href="{{url('my_history')}}">ประวัติการเติม </a>
                        </li>

                        <li class="nav-item">
                           <a class="nav-link" href="{{url('profile_user_package')}}">ข้อมูลส่วนตัว </a>
                        </li>

                        <li class="nav-item ">
                           <a class="nav-link" href="{{url('my_example')}}">ผลข้อสอบ </a>
                        </li>





                     </ul>
                    <!-- <form class="form-inline my-2 my-lg-0">


                        <button class="btn btn-outline-danger btn-sm" type="button">Subscribe <strong>1.4M</strong></button>
                     </form> -->
                  </div>
               </nav>
            </div>

                  <div class="container-fluid">
                    <div class="row">












                  <div class="col-lg-10">

                    <div class="main-title">
                       <h6>ประวัติการเติม</h6>
                    </div>


                     <table class="table ">
                <tbody>
                  <tr>
                    <td><div class="osahan-title">วันที่</div></td>
                    <td><div class="osahan-title">Package</div></td>
                    <td><div class="osahan-title">ราคา</div></td>
                    <td><div class="osahan-title">เริ่มใช้</div></td>
                    <td><div class="osahan-title">สิ้นสุด</div></td>
                  </tr>

                  @if(isset($pack))
                    @foreach($pack as $u)
                  <tr>
                    <td>{{DateThai($u->Dcre)}}</td>
                    <td>{{$u->package_name}}</td>
                    <td>

                      @if($u->package_price < 10)
                      ทดลองใช้ฟรี {{$u->package_day}} วัน
                      @else
                      {{$u->package_price}}
                      @endif

                    </td>
                    <td>
                      @if($u->start != '0000-00-00')
                      {{DateThai($u->start)}}
                      @else
                      @endif
                    </td>
                    <td>
                      @if($u->end_date != '0000-00-00')
                      {{DateThai($u->end_date)}}
                      @else
                      @endif

                    </td>
                  </tr>
                    @endforeach
                  @endif


                </tbody>
              </table>


                  </div>










                    </div>
                              </div>

<footer class="sticky-footer ml-0">
               <div class="container">
                  <div class="row no-gutters">
                     <div class="col-lg-6 col-sm-6">
                        <p class="mt-1 mb-0">© Copyright 2018 <strong class="text-dark">Vidoe</strong>. All Rights Reserved<br>
                           <small class="mt-0 mb-0">Made with <i class="fas fa-heart text-danger"></i> by <a class="text-primary" target="_blank" href="https://askbootstrap.com/">Ask Bootstrap</a>
                           </small>
                        </p>
                     </div>
                     <div class="col-lg-6 col-sm-6 text-right">
                        <div class="app">
                          <a href="#"><img alt="" src="{{url('web_stream/img/google.png')}}"></a>
                          <a href="#"><img alt="" src="{{url('web_stream/img/apple.png')}}"></a>
                        </div>
                     </div>
                  </div>
               </div>
            </footer>


@endsection

@section('scripts')
@stop('scripts')
