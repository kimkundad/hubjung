@extends('packag.layouts.template')

@section('stylesheet')
<link rel="stylesheet" href="{{url('web_stream/owlcarousel/assets/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{url('web_stream/owlcarousel/assets/owl.theme.default.min.css')}}">
@stop('stylesheet')
@section('content')


<style>
.owl-carousel .owl-item img {


}
.no-js .owl-carousel, .owl-carousel.owl-loaded {
    padding-left: 0px;
    margin-right: 0px;
    margin-left: 0px;
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



                <div class="video-block section-padding">

                  <div class="col-md-12">
                     <div class="main-title">

                        <h6>Package รายเดือน</h6>
                     </div>
                  </div>

                   <div class="row owl-carousel" >




                      @if(isset($pack))
                        @foreach($pack as $u)

                      <div class="" style="padding-left:8px; padding-right:8px;">
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
                   <br />
                </div>
                <hr class="mt-0">


                <div class="video-block section-padding">
                   <div class="row">
                      <div class="col-md-12">
                         <div class="main-title">

                            <h6>คอร์สเรียนภาษาญี่ปุ่น ออนไลน์</h6>
                         </div>
                      </div>

                      <div class=" owl-carousel" style="padding-left:8px; padding-right:8px;">
                      @if(isset($get_course))
                      @foreach($get_course as $u)
                      <div class="" style="padding-left:8px; padding-right:8px;">
                         <div class="video-card">
                            <div class="video-card-image">

                               <a href="{{url('course_detail/'.$u->id)}}"><img class="img-fluid" src="{{url('assets/uploads/'.$u->image_course)}}" alt="{{$u->title_course}}"></a>

                            </div>
                            <div class="video-card-body">
                               <div class="video-title">
                                  <a href="{{url('course_detail/'.$u->id)}}">{{$u->title_course}}</a>
                               </div>
                               <div class="video-page text-success">
                                  {{$u->name_department}}  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
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



                   </div>
                </div>
                <hr class="mt-0">


               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">

                           <h6>วิดีโอ อัพใหม่</h6>
                        </div>
                     </div>

                     <div class=" owl-carousel" style="padding-left:8px; padding-right:8px;">
                     @if(isset($video))
                     @foreach($video as $u)
                     <div class="" style="padding-left:8px; padding-right:8px;">
                        <div class="video-card">
                           <div class="video-card-image">
                              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                              <a href="{{url('play_video')}}"><img class="img-fluid" src="{{url('assets/uploads/'.$u->thumbnail_img)}}" alt="{{$u->course_video_name}}"></a>
                              <div class="time">{{$u->time_video}}</div>
                           </div>
                           <div class="video-card-body">
                              <div class="video-title">
                                 <a href="#">{{$u->course_video_name}} </a>
                              </div>
                              <div class="video-page text-success">
                                 {{$u->name_department}}  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                              </div>
                              <div class="video-view"> video_lists
                                 {{$u->view_video}} views &nbsp;<i class="fas fa-calendar-alt"></i> {{DateThai($u->created_ats)}}
                              </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                     @endif

                     </div>



                  </div>
               </div>
               <hr class="mt-0">


               <div class="video-block section-padding">

                 <div class="col-md-12">
                    <div class="main-title">

                       <h6>Channels </h6>
                    </div>
                 </div>
                  <div class="row owl-carousel">




                     @if(isset($depart))
                     @foreach($depart as $u)
                     <div class="" style="padding-left:8px; padding-right:8px;">
                        <div class="channels-card">
                           <div class="channels-card-image">
                              <a href="{{url('single_channel/'.$u->id)}}">
                                <img class="img-fluid" src="{{url('assets/image/department/'.$u->image)}}" alt="คอร์ส ภาษา{{$u->name_department}}" style="  display: inherit;background: #fff none repeat scroll 0 0;
                                border-radius: 50px;
                                box-shadow: 0 0 2px #ccc;
                                height: 80px;
                                margin: 1px 0 8px;
                                object-fit: scale-down;
                                transform: scale(1);
                                width: 80px;">
                              </a>
                              <div class="channels-card-image-btn"><button type="button" class="btn btn-outline-danger btn-sm">Subscribe </button></div>
                           </div>
                           <div class="channels-card-body">
                              <div class="channels-title">
                                 <a href="{{url('single_channel/'.$u->id)}}">คอร์ส ภาษา{{$u->name_department}}</a>
                              </div>
                              <div class="channels-view">
                                 @if($u->get_count_video != null)
                                 {{$u->get_count_video}} video
                                 @else
                                 &nbsp
                                 @endif

                              </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                     @endif


                  </div>
                  <br />
               </div>

@endsection

@section('scripts')


<script src="{{url('web_stream/owlcarousel/owl.carousel.min.js')}}"></script>
<script>
$(document).ready(function() {

      $(".owl-carousel, .owl-carousel1").owlCarousel({

          autoPlay: 50000, //Set AutoPlay to 3 seconds
          nav    : true,
          items : 4,
          navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
          itemsDesktop : [1199,3],
          itemsDesktopSmall : [979,3],
          responsive:{
              0:{
                  items:1,
                  nav:true
              },
              600:{
                  items:3,
                  nav:false
              },
              1000:{
                  items:4,
                  nav:true,
                  loop:false
              }
          }

      });



    });
</script>

@stop('scripts')
