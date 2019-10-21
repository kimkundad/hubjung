@extends('packag.layouts.single-channel')

@section('stylesheet')

@stop('stylesheet')

@section('content')

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
               <img class="img-fluid" alt="" src="https://learnsbuy.com/assets/image/slide/1559530953.png">
               <div class="channel-profile">
                  <img class="channel-profile-img" alt="" src="https://learnsbuy.com/assets/image/timeline_25610920_165705.jpg">
                  <div class="social hidden-xs">
                     Social &nbsp;
                     <a class="fb" href="#">Facebook</a>
                     <a class="tw" href="#">Twitter</a>
                     <a class="gp" href="#">Google</a>
                  </div>
               </div>
            </div>

            <div class="single-channel-nav">
                           <nav class="navbar navbar-expand-lg navbar-light">
                              <a class="channel-brand" href="#">{{$depart->name_department}} <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span></a>
                              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                              <span class="navbar-toggler-icon"></span>
                              </button>
                              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                 <ul class="navbar-nav mr-auto">
                                    <li class="nav-item ">
                                       <a class="nav-link" href="{{url('single_channel/'.$depart->id)}}">Course </a>
                                    </li>
                                    <li class="nav-item ">
                                       <a class="nav-link" href="{{url('playlist_channel/'.$depart->id)}}">Playlist </a>
                                    </li>

                                    <li class="nav-item active">
                                       <a class="nav-link" href="{{url('e_testing/'.$depart->id)}}">แบบทดสอบ </a>
                                    </li>





                                 </ul>
                                 <form class="form-inline my-2 my-lg-0">
                                    <input class="form-control form-control-sm mr-sm-1" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-success btn-sm my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button> &nbsp;&nbsp;&nbsp;

                                 </form>
                              </div>
                           </nav>
                        </div>

<div class="container-fluid">
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-11">

                       <h6>แบบฝึกหัด</h6>
                       <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">ข้อสอบ</th>
                              <th scope="col">หมวดหมู่</th>
                              <th scope="col">คอร์ส</th>
                              <th scope="col">จำนวนข้อ</th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @if(isset($objs))
                             @foreach($objs as $u)
                             <tr>
                               <th scope="row">{{$u->examples_name}}</th>
                               <td>{{$u->name_category}}</td>
                               <td>{{$u->title_course}}</td>
                               <td>{{$u->options}}</td>
                               <td class="text-right"><a class="btn btn-outline-success btn-sm" href="{{url('start_test/'.$u->e_id)}}">เริ่มทำข้อสอบ</a></td>
                             </tr>
                               @endforeach
                             @endif

                           </tbody>
                        </table>
                       </div>

                     </div>







                  </div>




                  <!-- -->


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
