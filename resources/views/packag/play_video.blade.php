@extends('packag.layouts.template')

@section('stylesheet')
<link href="https://vjs.zencdn.net/7.5.5/video-js.css" rel="stylesheet">
@stop('stylesheet')
@section('content')

<style>
.video-slider-right-list {
    background: #fff none repeat scroll 0 0;
    border-radius: 2px;
    box-shadow: 0 0 11px #ececec;
    height: 395px;
    overflow: auto;
}
</style>

<div class="video-block-right-list section-padding">
   <div class="row mb-4">
   <div class="col-md-8">

     <video id='my-video' class='video-js' controls preload='auto' style="width:100%" height='auto'
  poster="{{url('web_stream/thumbnail_video/'.$get_video->thumbnail_img)}}" data-setup='{}'>
    <source src="{{url('web_stream/example_video/'.$get_video->course_video)}}" type='video/mp4'>
    <p class='vjs-no-js'>
      To view this video please enable JavaScript, and consider upgrading to a web browser that
      <a href='https://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a>
    </p>
  </video>


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



   </div>
   <div class="col-md-4">
         <div class="video-slider-right-list">

           @if(isset($all_video))
           @foreach($all_video as $u)
            <div class="video-card video-card-list">

                     <div class="video-card-image">
                        <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                        <a href="{{url('play_video/'.$u->id)}}"><img class="img-fluid" src="{{url('web_stream/thumbnail_video/'.$u->thumbnail_img)}}" alt=""></a>
                        <div class="time">{{$u->time_video}}</div>
                     </div>
                     <div class="video-card-body">

                        <div class="video-title">
                           <a href="{{url('play_video/'.$u->id)}}">{{$u->course_video_name}}</a>
                        </div>
                        <div class="video-page text-success">
                           {{$get_data->name_department}}  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                        </div>
                        <div class="video-view">
                           {{$u->view_video}} views &nbsp;<i class="fas fa-calendar-alt"></i> {{DateThai($u->created_at)}}
                        </div>
                     </div>
                  </div>
                  @endforeach
                  @endif




         </div>
   </div>
   </div>
</div>




<div class="video-block section-padding">
   <div class="row">
      <div class="col-md-8">
         <div class="single-video-left">
            <div class="single-video-title box mb-3">
               <h2><a href="#">{{$get_video->course_video_name}}</a></h2>
               <p class="mb-0"><i class="fas fa-eye"></i> {{$get_video->view_video}} views</p>
            </div>


            <div class="single-video-info-content box mb-3">

               <h6>อาจารย์ผู้สอน:</h6>
               <p>{{$get_data->te_study}}</p>
               <h6>Channels :</h6>
               <p> {{$get_data->name_department}}</p>
               <h6>รายละเอียด :</h6>
               <p>{{$get_data->detail_course}}</p>
               <h6>Tags :</h6>
               <p class="tags mb-0">
                 @if(isset($get_tags))
                   @foreach($get_tags as $u)
                   @if($u != null)
                  <span><a href="#">{{$u}}</a></span>
                  @endif
                   @endforeach
                  @endif


               </p>
            </div>








         </div>
      </div>
      <div class="col-md-4">
         <div class="single-video-right">
            <div class="row">
               <div class="col-md-12">
                  <div class="adblock">
                     <div class="img">
                        Google AdSense<br>
                        336 x 280
                     </div>
                  </div>

               </div>


            </div>
         </div>
      </div>
   </div>
</div>



@endsection

@section('scripts')
<!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
  <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
  <script src='https://vjs.zencdn.net/7.5.5/video.js'></script>
  <script>
  var player = videojs();
  player.nuevo({
  	logo: "{{url('web_stream/img/learnsbuy_icon.png')}}",
  	logourl: "{{url('/')}}",
  	logoposition: 'RT',
  });
  </script>

@stop('scripts')
