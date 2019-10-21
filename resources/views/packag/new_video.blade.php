@extends('packag.layouts.template')

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
            <h6>วิดีโอ อัพใหม่</h6>
         </div>
      </div>


      @if(isset($video))
      @foreach($video as $u)
      <div class="col-xl-3 col-sm-6 mb-3">
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
   @include('pagination.default', ['paginator' => $video])
   <br /><br /><br /><br />
</div>








@endsection

@section('scripts')
@stop('scripts')
