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
                        <li class="nav-item active">
                           <a class="nav-link" href="{{url('single_channel/'.$depart->id)}}">Course </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="{{url('playlist_channel/'.$depart->id)}}">Playlist </a>
                        </li>

                        <li class="nav-item">
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
                     <div class="col-md-12">
                        <div class="main-title">
                           <div class="btn-group float-right right-action">
                              <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                              </div>
                           </div>
                           <h6>Course</h6>
                        </div>
                     </div>

                     @if(isset($pack))
                      @foreach($pack as $u)
                     <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="video-card">
                           <div class="video-card-image">

                              <a href="{{url('course_detail/'.$u->id)}}"><img class="img-fluid" src="{{url('assets/uploads/'.$u->image_course)}}" alt="{{$u->title_course}}"></a>

                           </div>
                           <div class="video-card-body">
                              <div class="video-title">
                                 <a href="{{url('course_detail/'.$u->id)}}">{{$u->title_course}}</a>
                              </div>
                              <div class="video-page text-success">
                                 {{$depart->name_department}}  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                              </div>
                              <div class="video-view">
                                <i class="fas fa-fw fa-video"></i> {{$u->count_video}} video &nbsp;<i class="fas fa-calendar-alt"></i> {{DateThai($u->created_at)}}
                              </div>
                           </div>
                        </div>
                     </div>
                      @endforeach
                     @endif











                  </div>

                  @include('pagination.default', ['paginator' => $pack])
              <!--    <nav aria-label="Page navigation example">
                     <ul class="pagination justify-content-center pagination-sm mb-0">
                        <li class="page-item disabled">
                           <a tabindex="-1" href="#" class="page-link">Previous</a>
                        </li>
                        <li class="page-item active"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                        <li class="page-item">
                           <a href="#" class="page-link">Next</a>
                        </li>
                     </ul>
                  </nav>
                -->
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
