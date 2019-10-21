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
                        <li class="nav-item active">
                           <a class="nav-link" href="{{url('account')}}">My Package </a>
                        </li>
                        <li class="nav-item">
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
                       <div class="col-xl-3 col-sm-6 mb-3">
                          <div class="card text-white bg-primary o-hidden h-100 border-none">
                             <div class="card-body">
                                <div class="card-body-icon">
                                   <i class="fas fa-fw fa-users"></i>
                                </div>
                                <div class="mr-5"><b>{{$package_count}} Package</b> ปัจจุบัน</div>
                             </div>
                             <a class="card-footer text-white clearfix small z-1" >
                              <span class="float-left"></span>
                             <span class="float-right">

                             </span>
                             </a>
                          </div>
                       </div>
                       <div class="col-xl-3 col-sm-6 mb-3">
                          <div class="card text-white bg-warning o-hidden h-100 border-none">
                             <div class="card-body">
                                <div class="card-body-icon">
                                   <i class="fas fa-fw fa-video"></i>
                                </div>
                                <div class="mr-5"><b>{{$count_his}}</b> ประวัติการเติมเงิน</div>
                             </div>
                             <a class="card-footer text-white clearfix small z-1" href="{{url('my_history')}}">
                             <span class="float-left">View Details</span>
                             <span class="float-right">
                             <i class="fas fa-angle-right"></i>
                             </span>
                             </a>
                          </div>
                       </div>
                       <div class="col-xl-3 col-sm-6 mb-3">
                          <div class="card text-white bg-success o-hidden h-100 border-none">
                             <div class="card-body">
                                <div class="card-body-icon">
                                   <i class="fas fa-fw fa-list-alt"></i>
                                </div>
                                <div class="mr-5"><b>{{$ex_count}}</b> ใช้คลังข้อสอบ</div>
                             </div>
                             <a class="card-footer text-white clearfix small z-1" href="{{url('my_example')}}">
                             <span class="float-left">ดูเพิ่มเติม</span>
                             <span class="float-right">
                             <i class="fas fa-angle-right"></i>
                             </span>
                             </a>
                          </div>
                       </div>

                       <div class="col-xl-3 col-sm-6 mb-3">
                          <div class="card text-white bg-danger o-hidden h-100 border-none">
                             <div class="card-body">
                                <div class="card-body-icon">
                                   <i class="fas fa-fw fa-cloud-upload-alt"></i>
                                </div>
                                <div class="mr-5"><b>0</b> Channels</div>
                             </div>
                             <a class="card-footer text-white clearfix small z-1" href="#">
                             <span class="float-left">ดูเพิ่มเติม</span>
                             <span class="float-right">
                             <i class="fas fa-angle-right"></i>
                             </span>
                             </a>
                          </div>
                       </div>



                       <div class="col-lg-12">
                          <div class="main-title">
                             <h6>Package ปัจจุบัน</h6>
                          </div>
                          <hr>



                       </div>

                  @if(isset($package))
                    @foreach($package as $u)



                  <div class="col-lg-2">

                     <img class="img-fluid" src="{{url('web_stream/img/package/'.$u->package_image)}}" alt="{{$u->package_name}}">
                  </div>


                  <div class="col-lg-4">

                    <div class="video-card">




                     <table class="table ">
                <tbody>
                  <tr>
                    <td style="border-top: 1px solid #fff;"><div class="osahan-title">{{$u->package_name}}</div></td>
                  </tr>
                  <tr>
                    <td><span class="t-l">
                      ระยะเวลาที่เหลือ <a class="text-success"> {{$u->total_day}} วัน</a>
                    </span></td>
                  </tr>
                  <tr>
                    <td><span class="t-l">
                      เติมครั้งล่าสุด <a class="text-success"> {{DateThai($u->Dcre)}}</a>
                    </span></td>
                  </tr>

                  <tr>
                    <td><span class="t-l">
                      เริ่มใช้งาน <a class="text-success"> {{DateThai($u->start)}}</a>
                    </span></td>
                  </tr>

                  <tr>
                    <td><span class="t-l">
                      วันหมดอายุ <a class="text-success"> {{DateThai($u->end_date)}}</a>
                    </span></td>
                  </tr>

                <!--  <tr>
                    <td><span>
                      หมายเหตุ : นักเรียนสามารถซื้อ Package เพิ่มได้ทันที โดยอายุการใช้งานจะเพิ่มจากยอดคงเหลือล่าสุด หรือตามโบนัสของ Package นั้นๆที่นักเรียนได้ทำงานสั่งซื้อ
                    </span></td>
                  </tr> -->


                </tbody>
              </table>
              </div>

                  </div>

                  @endforeach
                  @endif





@if(isset($order))
                  <div class="col-lg-12">
                     <div class="main-title">
                        <h6>Package รอการอนุมัติ</h6>
                     </div>
                     <hr>



                  </div>


               @foreach($order as $u)



             <div class="col-lg-2">

                <img class="img-fluid" src="{{url('web_stream/img/package/'.$u->package_image)}}" alt="{{$u->package_name}}">
                <p>
                  {{$u->package_name}}
                </p>
             </div>


             <div class="col-lg-4">

               <div class="video-card">




                <table class="table ">
           <tbody>
             <tr>
               <td style="border-top: 1px solid #fff;"><div class="osahan-title">{{$u->package_name}}</div></td>
             </tr>
             <tr>
               <td><span class="t-l">
                 วันที่สั่งซื้อ <a class="text-success"> {{DateThai($u->Dcre)}} </a>
               </span></td>
               </tr>
               <tr>
               <td><span class="t-l">
                 ราคา <a class="text-success"> {{($u->package_price)}} บาท</a>
               </span></td>
               </tr>
               <tr>
               <td><span class="t-l">
                 จำนวนวัน <a class="text-success"> {{($u->package_day)}} วัน</a>
               </span></td>
             </tr>



           </tbody>
         </table>
         </div>

             </div>

             @endforeach
             @endif








                  <div class="col-lg-12">
                    <br />
                     <div class="main-title">
                        <h6>Package ที่น่าสนใจ</h6>
                     </div>
                     <hr>
                  </div>


                  @if(isset($pack))
                    @foreach($pack as $u)

                  <div class="col-xl-3 col-sm-6 mb-3">
                     <div class="video-card">
                        <div class="video-card-image">

                           <a href="{{url('info_package/'.$u->id)}}"><img class="img-fluid" src="{{url('web_stream/img/package/'.$u->package_image)}}" alt="{{$u->package_name}}"></a>

                        </div>
                        <div class="video-card-body">
                           <div class="video-title">
                              <a href="#">{{$u->package_name}}</a>
                           </div>
                           <div class="channels-card-image-btn">
                             <a href="{{url('info_package/'.$u->id)}}" class="btn btn-success btn-sm border-none">สมัครเรียน</a>
                           </div>

                        </div>
                     </div>
                  </div>
                    @endforeach
                  @endif








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
