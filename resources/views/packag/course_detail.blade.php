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
      <div class="col-md-8">
         <div class="single-video-left">
            <div class="single-video-title box mb-3">
               <h2><a href="#">{{$pack->title_course}}</a></h2>
               <p class="mb-0"><i class="fas fa-eye"></i> {{$pack->view_course}} views</p>
            </div>


            <div class="single-video-info-content box mb-3">

               <h6>อาจารย์ผู้สอน:</h6>
               <p>{{$pack->te_study}}</p>
               <h6>Channels :</h6>
               <p> {{$depart->name_department}}</p>
               <h6>รายละเอียด :</h6>
               <p>{{$pack->detail_course}}</p>
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


            <div class="table-scrollable table-scrollable-borderless">
                                         <table class="table table-hover table-light">
                                          <thead class="uppercase">
                                              <tr>
                                                  <th>เอกสารให้ Download </th>
                                                  <th></th>
                                              </tr>
                                          </thead>

                                          <tbody>
                                            @if(isset($file))
                                              @foreach($file as $u)
                                            <tr>

                                              <td><i class="fa fa-video-camera "></i> {{$u->file_of_name}}</td>

                                              <td class="text-right"> <a href="{{url('download_file_course/'.$u->id)}}" ><i class="fas fa-fw fa-cloud-download-alt" style="font-size:18px; color:#4eda92"></i> Download</a> </td>
                                            </tr>
                                              @endforeach
                                            @endif

                                            </tbody>

                                          </table>
                                        </div>


              <div class="table-scrollable table-scrollable-borderless">
                                           <table class="table table-hover table-light">
                                            <thead class="uppercase">
                                                <tr>
                                                    <th>รายชื่อของ Video</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                              @if(isset($count_video))
                                                @foreach($count_video as $u)
                                              <tr>
                                                <td><img class="img-fluid" src="{{url('assets/uploads/'.$u->thumbnail_img)}}" alt="{{$u->course_video_name}}" style="height:45px;"></td>
                                                <td><i class="fa fa-video-camera "></i> {{$u->course_video_name}}</td>
                                                <td>
                                                  @if($u->time_video != null)
                                                  {{$u->time_video}} / นาที
                                                  @endif
                                                </td>
                                                <td> <i class="fa fa-play-circle" style="font-size:18px; color:red"></i></td>
                                              </tr>
                                                @endforeach
                                              @endif

                                              </tbody>

                                            </table>
                                          </div>











         </div>
      </div>
      <div class="col-md-4">
         <div class="single-video-right">
            <div class="row">
               <div class="col-md-12">
                  <img class="img-fluid" src="{{url('assets/uploads/'.$pack->image_course)}}" alt="{{$pack->title_course}}">
                  <br /><br />
                  <div class="main-title">

                     <h6>ตัวอย่างวิดีโอ</h6>
                  </div>
               </div>
               <div class="col-md-12">

                 @if(isset($ex_video))
                  @foreach($ex_video as $u)
                  <div class="video-card video-card-list">
                     <div class="video-card-image">
                        <a class="play-icon" href="{{url('play_video/'.$u->id)}}"><i class="fas fa-play-circle"></i></a>
                        <a href="{{url('play_video/'.$u->id)}}"><img class="img-fluid" src="{{url('web_stream/thumbnail_video/'.$u->thumbnail_img)}}" alt=""></a>
                        <div class="time">{{$u->time_video}}</div>
                     </div>
                     <div class="video-card-body">

                        <div class="video-title">
                           <a href="{{url('play_video/'.$u->id)}}">{{$u->course_video_name}}</a>
                        </div>
                        <div class="video-page text-success">
                           {{$depart->name_department}}  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
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


         <div class="card sidebar-card mb-4">
            <div class="card-body">
               <h5 class="card-title mb-3">Tags</h5>
               <div class="tagcloud">
                 @if(isset($get_tags))
                   @foreach($get_tags as $u)
                   @if($u != null)
                  <a class="tag-cloud-link" href="#">{{$u}}</a>
                  @endif
                   @endforeach
                  @endif
               </div>
            </div>
         </div>


      </div>
   </div>
</div>



@endsection

@section('scripts')



@stop('scripts')
