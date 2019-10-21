@extends('layouts.app')
@section('content')
<link href="{{url('assets/css/profile-style.css')}}" rel="stylesheet" type="text/css" />
<style>
body{
      background-color: #f5f5f5;
}
.ui.button {
  width: 100%;
  text-decoration: none;
    cursor: pointer;
    display: inline-block;
    min-height: 1em;
    outline: 0;
    border: none;
    background: #e0e1e2;
    color: #fff;
    margin: 0 .25em 0 0;
    padding: .78571429em 1.5em;
    text-shadow: none;
    font-weight: 700;
    line-height: 1em;
    font-style: normal;
    text-align: center;
    border-radius: .28571429rem;
    user-select: none;
    -webkit-transition: opacity .1s ease,background-color .1s ease,color .1s ease,box-shadow .1s ease,background .1s ease;
    transition: opacity .1s ease,background-color .1s ease,color .1s ease,box-shadow .1s ease,background .1s ease;
    will-change: '';
}
.ui.facebook.button {
    background-color: #3b5998;
    text-shadow: none;
}
.ui.facebook.button:hover {
    background-color: #334d84;
    text-shadow: none;
}
.ui.facebook.button, .ui.google.plus.button, .ui.instagram.button, .ui.pinterest.button, .ui.twitter.button, .ui.vk.button, .ui.youtube.button {
    background-image: none;
    box-shadow: 0 0 0 0 rgba(34,36,38,.15) inset;
    color: #fff;
}
.panel-default>.panel-heading {
    background-image: url({{url('assets/image/login_bg.png')}});

}
.panel-heading {
    padding: 5px 5px;
}
.login_box {

    margin: 56px auto;
    padding: 15px 15px 0;
}
.t_mid {
    text-align: center;
}
.g_right {
  margin-top: -5px;
    float: right;
}
.logo-login{
      margin: 0 auto 20px auto;
}
.t_gray {

    color: #9e9e9e;
}
.login_box .sign_up_btn, .login_box .login_btn {
    background-color: #fff;
    color: #424242;
    padding: 10px 25px;
}
.ap-questions-featured {
    margin-left: -10px;
    border: medium none;
    color: #ff951e;
    display: inline;
    font-size: 16px;
    height: auto;
    margin-right: 5px;
    padding: 0;
    position: static;
    vertical-align: baseline;
    width: auto;
}
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
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="panel panel-default login_box">

                <div class="panel-body">


                  <div id="kimkundad">




                    <div class="ap-user-info ">
                    <div class="ap-user-avatar">
              @if($objs->provider == 'email')


              @if($objs->avatar != NULL)
              <img data-view="user_avatar_690" alt="" src="{{url('assets/images/avatar/'.$objs->avatar)}}"
              class="avatar avatar-40 photo" width="40" height="40" data-pin-nopin="true">
              @else

              <img data-view="user_avatar_690" alt="" src="{{url('assets/images/avatar/blank_avatar_240x240.gif')}}"
              class="avatar avatar-40 photo" width="40" height="40" data-pin-nopin="true">
              @endif



              @else
              <img data-view="user_avatar_1980" alt="" src="//{{$objs->avatar}}"
              class="avatar avatar-40 photo" width="40" height="40" data-pin-nopin="true">
              @endif

                            </div>
                    <div class="ap-user-data">
              <a class="ap-user-name" href="#">{{$objs->name}}</a>
              <span class="ap-user-reputation"><i class="ap-questions-featured fa fa-trophy" style="margin-left:8px;"></i> Level. {{$objs->level_user}}</span>                </div>
                    <div class="ap-user-info-btns">
                              </div>
                </div>
                <hr>

                    <div class="ap-profile-box clearfix" style="margin-top: 1px;">

                      <h3 class="ap-user-page-title clearfix" style="font-size: 16px; color: #a94442; border:none;  margin-bottom: 5px;">สถิติการทำแบบฝึกหัด </h3>

                      <div class="table-responsive">

                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>คอร์สเรียน</th>
                              <th>หมวดหมู่</th>
                              <th>คะแนน</th>
                              <th>วันที่</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if($course_chart != NULL)
                            @foreach($course_chart as $uu)
                            <tr>

                              <th scope="row"><a href="{{url('courseinfo/'.$uu->course_id)}}">{{$uu->title_course}}</a></th>
                              <td>{{$uu->name_category}}</td>
                              <td><a class="ap-user-posts-vcount ap-tip" title="จำนวนข้อที่ทำได้" >
                              @if($uu->options >= ($uu->all_options/2) )
                              <i class="fa fa-thumbs-o-up "></i> 		{{$uu->options}}    </a>
                              @else
                              <i class="fa fa-thumbs-o-down " style="color: #a94442;"></i> 	{{$uu->options}}    </a>
                              @endif / <span class="point" style="padding: 3px; width: 48px;" title="แบบฝึกหัดทั้งหมด">{{$uu->all_options}} ข้อ</span>





                              </td>
                              <td> <?php echo DateThai($uu->date_ans); ?></td>

                            </tr>
                              @endforeach
                            @endif

                               </tbody>
                        </table>

                      </div>

                      <div class="text-center">
                       <div class="pagination"> {{ $course_chart->links() }} </div>
                      </div>

                    </div>













                  </div>






                </div>
            </div>
        </div>
    </div>
</div>
@endsection
