
@extends('layouts.app')
@section('stylesheet')
<link href="{{url('assets/css/select-project.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/css/confirm.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.row {
    margin-left: initial;
    margin-right: initial;
}
.btn-fb {
    border: 1px solid #3b5998;
    color: white;
    background-color: #5A73AA;
    border-radius: 2px;
    float: left;
}
.btn-mini.border-btn {
    padding: 2px 12px;
    font-size: 13px;
}
.btn-wishlist {
    padding: 2px 7px !important;
    font-size: 14px;
    padding: 5px;
    -moz-transition: 0.8s;
    -webkit-transition: 0.8s;
    -o-transition: 0.8s;
    transition: 0.8s;
    opacity: 0.85;
    margin-top: 15px;
    margin-left: 4px;
    font-size: 12px

}
.head-lines {
    position: absolute;
    /* bottom: 0; */
    /* left: 0; */
    display: block;
    width: 50px;
    height: 3px;
    background-color: #00c402;
    margin: 0;
}
hr {
    margin-top: 10px;
    margin-bottom: 10px;
    }

    @media screen and (max-width: 500px) /* Mobile */ {
  .extra-paddingright {
    padding-right: 0px;
    padding-left: 0px;
}
.course-overall {
    border: none;
}
.wigt-content{
  margin-top: 20px;
  padding-right: 0px;
    padding-left: 0px;
}

}


</style>

@stop('stylesheet')
@section('content')

<?php
function DateThaif($strDate)
{
$strYear = date("Y",strtotime($strDate))+543;
$strMonth= date("n",strtotime($strDate));
$strDay= date("j",strtotime($strDate));
$strHour= date("H",strtotime($strDate));
$strMinute= date("i",strtotime($strDate));
$strSeconds= date("s",strtotime($strDate));
$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$strMonthThai=$strMonthCut[$strMonth];
return "$strDay $strMonthThai";
}
 ?>
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

<div class="content-section-a">
<div class="container" >


    <div class="row">
        <div class="col-md-12 " >

          <div class="col-xs-12  col-md-4 extra-paddingright">
            <img src="{{url('assets/uploads/'.$objs->image_course)}}" class="img-responsive">

            <div class="course-teacher">
              <strong>รายละเอียดคอร์ส</strong>
              <br>
              <table class="table table-striped table-responsive">
                <tr>
                  <td>ช่วงเวลาที่เรียน</td>
                  <td class="text-right">{{$objs->time_course_text}}</td>
                </tr>
                <tr>
                  <td>วันที่เรียน</td>
                  <td class="text-right">{{$objs->day_course}}</td>
                </tr>
                <tr>
                  <td>เวลาที่เรียน</td>
                  <td class="text-right">{{$objs->time_course}}</td>
                </tr>
                <tr>
                  <td><i class="fa fa-cloud-download"></i> เอกสารการเรียน</td>
                  <td class="text-right">{{$objs->file_study}} </td>
                </tr>
                <tr>
                  <td><i class="fa fa-video-camera"></i> วีดีโอย้อนหลัง</td>
                  <td class="text-right">
                    @if($objs->video_back == 0)
                    ไม่มีให้
                    @else
                    มีให้
                    @endif
                    </td>
                </tr>
              </table>

            </div>

            <div class="course-teacher">
              <strong>เกี่ยวกับผู้สอน</strong>
              <br>
              <div class="teachet-info">
                <img src="{{url('assets/image/15965494_10206213152167039_5353071833653529827_n.jpg')}}" class="img-circle">
                  <div class="teacher-name">
                    ครูพี่โฮม ภาษาญี่ปุ่น<br>
                    <span>ติว PAT ญี่ปุ่น อันดับ 1 ของไทย</span>
                  </div>
              </div>
            </div>

          </div>

          <div class="col-xs-12  col-md-8 wigt-content">
            <div class="row course-overall-wrapper">
              <div class="col-md-12">

              <div class="col-md-8 course-overall">
                  <h4><b>{{$objs->title_course}}<span class="head-lines"></span></b></h4>
                  <p>{{$objs->detail_course}}</p>
              </div>

              <div class="col-md-4 course-exit">
                @if (Auth::guest())
                <a type="button" href="{{url('confirm_course/'.$objs->id)}}" class="btn btn-success1 btn-lg btn-block"
                style="padding: 6px 18px;">จองคอร์สเรียน</a>
                @else
                <div class="hidden">{{$i = 1}}</div>
                <a type="button" href="{{url('confirm_course/'.$objs->id)}}" class="btn btn-success1 btn-lg btn-block"
                style="padding: 6px 18px;">จองคอร์สเรียน</a>

                @endif

                <button class="btn-mini border-btn btn-fb" style="display:inline-block; text-transform:none; margin-top: 15px;">
                    <i class="fa fa-facebook"></i> แบ่งปันคอร์สนี้                </button>

                <a class="btn btn-wishlist btn-notwished btn-info btn-mini url-redirection" style="display:inline-block;  text-transform:none; " >
                  <i class="fa fa-star-o"></i> เก็บไว้นะ
                </a>
                <hr>
                <span class="readingPrice">
                                ฿ @if($objs->price_course == 0)
                                    Free course
                                                            @else
                                                      {{$objs->price_course}}  บาท (ลดราคา {{$objs->discount}})
                                                            @endif


                                  </span>
                @if($objs->show_students == 1)
                                  <hr>
                <strong>จำนวนผู้จองคอร์สเรียน</strong>
                <h4 style="color:red"><i class="fa fa-user"></i> {{$count_course}}</h4>
                @endif


              </div>



                </div>



            </div>



            <div class="row course-overall-wrapper" style="margin-top:20px;">
            <div class="col-md-12">
              <br>
                  <h5 style="font-size: 17px;"><b>  เอกสารให้ Download <span class="head-lines"></span></b></h5>
                  <p style="color:#666">
                    การ Download เอกสาร นักเรียนต้อง Log in และมีคอร์สที่ลงทะเบียนไว้แล้วเท่านั้น
                  </p>
                  <br>

                  <div class="table-scrollable table-scrollable-borderless">
                                         <table class="table table-hover table-light">
                                          <thead class="uppercase">
                                              <tr>
                                                  <th>ชื่อเอกสาร</th>
                                                  <th></th>
                                              </tr>
                                          </thead>

                                          <tbody>

                                            @if(isset($file))
                                                       @foreach($file as $u)
                                            <tr>
                                              <td><i class="fa fa-video-camera "></i> {{$u->file_of_name}}</td>
                                              <td class="text-right">


                                                @if (Auth::guest())

                                                @else

                                                @if($check_course > 0)
                                                <a style="color:#4eda92" href="{{url('download_file_course/'.$u->id)}}" >
                                                <i class="fa fa-cloud-download" style="font-size:18px;"></i>
                                                Download</a>
                                                @else

                                                @endif




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



              <div class="row course-overall-wrapper" style="margin-top:20px;">
              <div class="col-md-12">
                <br>
                    <h5 style="font-size: 17px;"><b>  Video คอร์ส <span class="head-lines"></span></b></h5>
                    <br>

                    <div class="table-scrollable table-scrollable-borderless">
                                           <table class="table table-hover table-light">
                                            <thead class="uppercase">
                                                <tr>
                                                    <th>รายชื่อของ Video</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                              @if($video_list)
                                             						 @foreach($video_list as $video_lists)
                                              <tr>
                                                <td><i class="fa fa-video-camera "></i> {{$video_lists->course_video_name}}</td>
                                                <td><i class="fa fa-play-circle-o" style="font-size:18px; color:red"></i></td>
                                              </tr>
                                              @endforeach
                              										 @endif
                                            </tbody>
                                            </table>
                                          </div>

              </div>
                </div>




              <div id="kimkundad" >
              <div id="ap-comment-area">

                            <div class="ap-comments comment-container have-comments" style="margin-left:0px; margin-right:0px;">
                              <ul class="ap-commentlist clearfix">




                                @foreach($comment_course as $comment)
                                <li id="comment-id-{{$comment->c_id}}" class="kimkundad byuser comment-author-tarrence even thread-even depth-1 clearfix">
                                                  <div class="clearfix">
                                                    <div class="ap-avatar ap-pull-left">
                                                      <a href="#" title="">

                                                        @if($comment->provider == 'email')
                                                        <img style="max-height:50px;" class="img-responsive avatar avatar-30 photo ap-dynamic-avatar"
                                                         src="{{url('assets/images/avatar/'.$comment->avatar)}}"></a>
                                                        @else
                                                        <img style="max-height:50px;" class="img-responsive avatar avatar-30 photo ap-dynamic-avatar"
                                                         src="//{{$comment->avatar}}"></
                                                         a>
                                                        @endif
                                                    </div>
                                                    <div class="ap-comment-content no-overflow">
                                                      <div class="ap-comment-header">
                                                        <a  class="ap-comment-author"> {{$comment->name}}</a>
                                                         - <a  class="ap-comment-time"><time><?php echo DateThai($comment->created_att); ?></time></a>

                                                         @if (Auth::guest())

                                                         @else

                                                         @if ($comment->u_id != Auth::user()->id)

                                                         @else
                                                         <div class="pull-right">
                                                           <a href="#" class="dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                           <i class="fa fa-cog"></i>
                                                         </a>
                                                         <ul class="dropdown-menu" style="top: inherit !important; min-width: 100px;" role="menu" aria-labelledby="dLabel">
                                                          <li><a href="#" data-toggle="modal" data-target="#editer-{{$comment->c_id}}"><i class="fa fa-wrench"></i>  แก้ไข</a></li>
                                                          <li><a href="#" data-toggle="modal" data-target="#myModal-{{$comment->c_id}}"><i class="fa fa-trash-o"></i> ลบทิ้ง</a></li>
                                                         </ul>
                                                         </div>





                                                         <div class="modal fade" id="editer-{{$comment->c_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button> <h4 class="modal-title" id="myModalLabel">ทำการแก้ไข ?</h4>
      </div>

      <div class="panel-body">
                        <div id="showalert2"></div>
                        <div class="modal-wrapper">

                      <form method="post" action="{{url('comment/'.$comment->c_id)}}" enctype="multipart/form-data">
                          <div class="modal-text">
                            <input type="hidden" name="_method" value="put">
                            <input type="hidden" name="course_id" class="form-control" value="{{$objs->id}}">
                            {{ csrf_field() }}
                            <div class="form-group">

                              <textarea class="form-control" name="comment" rows="3">{{$comment->comment}}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>

                      <footer class="panel-footer" style="margin-top: 10px;">
                        <div class="row">
                          <div class="col-md-12 text-right">


                            <button type="submit" class="btn btn-primary ">แก้ไข</button>
                            <button class="btn btn-default modal-dismiss" data-dismiss="modal" aria-label="Close">ยกเลิก</button>

                          </form>
                          </div>

                        </div>
                      </footer>


    </div>
  </div>
</div>





                                                         <div class="modal fade bs-example-modal-sm" id="myModal-{{$comment->c_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                           <div class="modal-dialog modal-sm" role="document">
                                                             <div class="modal-content">

                                                               <div class="modal-header">
                                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                   <span aria-hidden="true">×</span>
                                                                 </button> <h4 class="modal-title" id="myModalLabel">ต้องการลบ ?</h4>
                                                               </div>

                                                               <div class="panel-body">
                                                                                 <div id="showalert2"></div>
                                                                                 <div class="modal-wrapper">

                                                                                   <div class="modal-text">
                                                                                     <h4>ต้องการลบความคิดเห็นนี้ ใช่ไหม ?</h4>
                                                                                   </div>
                                                                                 </div>
                                                                               </div>

                                                                               <footer class="panel-footer" style="margin-top: 10px;">
                                                                                 <div class="row">
                                                                                   <div class="col-md-12 text-right">
                                                                                     <form method="post" action="{{url('comment/'.$comment->c_id)}}" enctype="multipart/form-data">

                                                                                      <input type="hidden" name="_method" value="DELETE">
                                                                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                                                     <button type="submit" class="btn btn-primary ">ลบ</button>
                                                                                     <button class="btn btn-default modal-dismiss" data-dismiss="modal" aria-label="Close">ยกเลิก</button>

                                                                                   </form>
                                                                                   </div>
                                                                                 </div>
                                                                               </footer>


                                                             </div>
                                                           </div>
                                                         </div>






                                                         @endif
                                                         @endif

                                                       </div>
                                                      <div class="ap-comment-texts">
                                                        <p>{{$comment->comment}}</p>
                                                      </div></div>
                                                  </div>
                                                </li>
                                @endforeach

























                              </ul>
                            </div>
                            @if (Auth::guest())

                            <div style="margin-top:40px;background: #fff none repeat scroll 0 0; border: 1px solid #eee; padding: 15px;">
                              <p><i class="fa fa-lock"></i> โปรดทำการ <a href="{{url('login')}}">เข้าสู่ระบบ</a> หรือ <a href="{{url('register')}}">สมัครสมาชิก</a> เพื่อแสดงความคิดเห็น</p>
                            </div>

                            @else

                            <div style="margin-top:40px;background: #fff none repeat scroll 0 0; border: 1px solid #eee; padding: 15px;">
                              <div class="clearfix">
                                <div class="ap-avatar ap-pull-left">
                                  <a href="user_profile-2.html" title="">
                                  <!-- TODO: OPTION - Avatar size -->
                                  @if(Auth::user()->provider == "email")
                                  <img style="max-height:50px;" class="img-responsive avatar avatar-30 photo ap-dynamic-avatar"
                                   src="{{url('assets/images/avatar/'.Auth::user()->avatar)}}"></a>
                                  @else
                                  <img style="max-height:50px;" class="img-responsive avatar avatar-30 photo ap-dynamic-avatar"
                                   src="//{{Auth::user()->avatar}}"></a>
                                  @endif


                                </div><!-- close .ap-avatar -->
                                <form method="post" action="{{url('comment')}}" enctype="multipart/form-data">
                                  <input type="hidden" name="_method" value="post">
                                  <input type="hidden" name="course_id" class="form-control" value="{{$objs->id}}">
                                  {{ csrf_field() }}
                                <div class="ap-comment-content no-overflow">
                                  <div class="ap-comment-header">
                                    <a class="ap-comment-author"> {{ Auth::user()->name }} </a>

                                   </div><!-- close .ap-comment-header -->
                                  <div class="ap-comment-texts">
                                    <textarea class="form-control" name="comment" rows="3" style="width: 90%; margin-top:5px;"></textarea>
                                  </div>
                                  <div class="col-sm-12" style="margin-top:10px;"> <button type="submit" class="btn btn-primary pull-right">แสดงความคิดเห็น</button> </div>
                                            </div><!-- close .ap-comment-content -->
                                            </form>
                              </div><!-- close #comment-* -->
                            </div>


                            @endif

                          </div>
                          </div>




          </div>





        </div>
    </div>



</div>
</div>
@endsection


@section('scripts')
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" type="text/javascript"></script>



@stop('scripts')
