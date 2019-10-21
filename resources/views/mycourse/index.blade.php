@extends('layouts.app')
@section('stylesheet')
<link href="{{url('assets/css/sticky-footer-navbar.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/css/profile-style.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{url('assets/date/css/bootstrap-datepicker.standalone.css')}}">
<link rel="stylesheet" href="{{url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css')}}">
<link rel="stylesheet" href="{{asset('./assets/vendor/pnotify/pnotify.custom.css')}}">
@stop('stylesheet')
@section('content')

<style type="text/css">
#kimkundad .ap-user-head {
    border-bottom: 1px solid #efefef;
    margin-bottom: 35px;
    text-align: center;
}
#kimkundad .ap-user-dscription {
    margin-bottom: 20px;
}
#kimkundad .ap-user-description-in {
    font-family: georgia,arial,helvetica,sans-serif;
    font-size: 15px;
    height: 42px;
    overflow: hidden;
}
#kimkundad .ap-user-mini-status {
    margin-bottom: 20px;
}
#kimkundad .ap-user-mini-status span {
    border-left: 1px solid #ddd;
    color: #666;
    font-size: 15px;
    margin-right: 5px;
    padding-left: 10px;
}
#kimkundad .ap-user-mini-status span:first-child {
    margin-right: 0;
    border-left: 0;
    padding-left: 0;
}
#kimkundad .ap-user-head {
    border-bottom: 1px solid #efefef;
    margin-bottom: 35px;
    text-align: center;
}
#kimkundad .ap-user-head .ap-user-avatar {
    display: table;
    margin: -95px auto 0;
}
#kimkundad .ap-user-avatar {
    margin-right: 10px;
    position: relative;
}
#kimkundad .ap-user-head .ap-user-avatar img {
    border-radius: 50%;
}
#kimkundad .ap-user-avatar>span, #kimkundad .ap-user-avatar img {
    display: block;
    box-shadow: none;
}
#kimkundad .ap-user-head .ap-user-name {
    font-size: 30px;
}
#anspress .ap-user-name {
    color: #333;
    display: block;
    font-size: 16px;
    font-weight: 600;
    white-space: nowrap;
}
#kimkundad .ap-user-cover {

    border-radius: 3px;
    height: 250px;
    margin-bottom: 20px;
    position: relative;
}
#kimkundad .ap-user-cover .ap-user-cover-img {
    background-repeat: no-repeat;
    background-size: cover;
    display: block;
    height: 100%;
}

#kimkundad .ap-about-rep-label {
    color: #aaa;
    display: block;
    font-size: 13px;
}
#kimkundad .ap-about-rep-count {
    font-size: 25px;
    margin-right: 20px;
}
#kimkundad .ap-about-rep-chart {
    width: 100%;
    height: 53px;
    border-bottom: 1px dashed #8fc77e;
}
#kimkundad .ap-reputation-item {
    border-top: 1px solid #f4f4f4;
    padding: 15px 0;
}
#kimkundad .ap-reputation-item.positive .point {
    background: #D8F9DB;
}
#kimkundad .ap-reputation-item .ap-reputation-event {
    display: block;
    float: left;
    margin-right: 10px;
    width: 100%;
}
#kimkundad .ap-reputation-item .point {
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 3px;
    float: left;
    font-size: 13px;
    font-weight: 600;
    margin-right: 15px;
    padding: 0;
    text-align: center;
    width: 35px;
}
#kimkundad #ap-user-menu>li {
    border-bottom: 1px solid #eee;
    margin: 0;
    padding: 0;
}
#kimkundad #ap-user-menu>li.active>a {
    background: none repeat scroll 0 0 #f5f5f5;
}
.bg-danger {
    padding: 15px;
}
.ui-pnotify .ui-pnotify-title {
    font-size: 14px;
    letter-spacing: 0;
}
.ui-pnotify-title {
    display: block;
    margin-bottom: .4em;
    margin-top: 0;
    height: 18px;
}
.alert-danger{
    background: #e41f1c;
    color: rgba(255, 255, 255, 0.7);
}
.alert-success{
  background: #47a447;
  color: rgba(255, 255, 255, 0.7);
}
</style>
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
<div class="container" style="padding: 45px 15px 200px 15px; margin-bottom:30px;">
    <div class="row">

          <div class="col-md-9">
            <div id="kimkundad">


              <div class="ap-user" id="ap-user">







                <div class="ap-user-info ">
                <div class="ap-user-avatar">
          @if($objs->provider == 'email')
          <img data-view="user_avatar_1980" alt="" src="assets/images/avatar/{{$objs->avatar}}"
          class="avatar avatar-40 photo" width="40" height="40" data-pin-nopin="true">
          @else
          <img data-view="user_avatar_1980" alt="" src="//{{$objs->avatar}}"
          class="avatar avatar-40 photo" width="40" height="40" data-pin-nopin="true">
          @endif

                        </div>
                <div class="ap-user-data">
          <a class="ap-user-name" href="#">{{Auth::user()->name}}</a>
          <span class="ap-user-reputation"><i class="ap-questions-featured fa fa-trophy" style="margin-left:8px;"></i> Level. {{$objs->level_user}}</span>                </div>
                <div class="ap-user-info-btns">
                          </div>
            </div>







            <div class="ap-user-navigation clearfix">
      <ul id="ap-user-menu" class="ap-user-menu ap_collapse_menu clearfix">
        <li><a href="{{url('profile')}}" class="ap-user-menu-orders apicon-shopping-cart"><i class="fa fa-street-view"></i> ส่วนตัวของฉัน</a></li>




        <li><a href="{{url('user_course')}}" class="ap-user-menu-orders apicon-shopping-cart"><i class="ap-questions-featured fa fa-graduation-cap"></i> คอร์สเรียน</a></li>
        <li><a href="{{url('my_state')}}" class="ap-user-menu-orders apicon-shopping-cart"><i class=" fa fa-bar-chart"></i> สถิติแบบฝึกหัด</a></li>
        <li><a href="{{url('user_ans')}}" class="ap-user-menu-orders apicon-shopping-cart"><i class="fa fa-commenting-o"></i> คำถามของฉัน</a></li>
        <li><a href="{{url('store_transactions')}}" class="ap-user-menu-orders apicon-shopping-cart"><i class="fa fa-shopping-cart"></i> ดูประวัติการสั่งซื้อ</a></li>
        <li><a href="{{url('user_rep')}}" class="ap-user-menu-orders apicon-shopping-cart"><i class="fa fa-trophy"></i> อันดับนักเรียนยอดเยี่ยม</a></li>

        <li><a href="{{url('logout')}}" class="ap-user-menu-activity-feed apicon-rss"><i class="fa fa-sign-out"></i> ออกจากระบบ</a></li>
      </ul></div>






      <div class="ap-user-lr row">

        <div class="col-md-12">

          <div class="ap-profile-box clearfix" >

            <h3 class="ap-user-page-title clearfix">คอร์สเรียนของฉัน  </h3>

            <div>

              @if($courseinfosfin != NULL)
              @foreach($courseinfosfin as $coursesfin)
          <div style="margin-bottom:20px; padding-bottom:5px; border-bottom: 1px solid #eee;">
          <a href="{{url('user_course_detail/'.$coursesfin->Cid)}}"><img src="{{url('assets/uploads/'.$coursesfin->image_course)}}" class="img-responsive" style="height:100px; float:left; margin-right:8px;"></a>
          <a href="{{url('user_course_detail/'.$coursesfin->Cid)}}">{{$coursesfin->title_course}}</a><br>

          <td class="text-right">วันที่เรียน : {{$coursesfin->day_course}}</td><br>
          <td class="text-right">เวลาที่เรียน : {{$coursesfin->time_course}}</td><br>
          <b class="text-danger">
            @if($coursesfin->type_course == 3)
              คอร์สเรียนฟรี
            @else
              ราคา : {{$coursesfin->price_course}} THB
            @endif


          </b>
          </div>
              @endforeach

              @else
              <p><b>ยังไม่มีคอร์สเรียน ปรึกษาเราได้ <a href="{{url('user_ans')}}">(มาที่เมนูคำถามของฉัน)</a></b></p>
              @endif

            </div>



            <br>





            <h3 class="ap-user-page-title clearfix">คอร์สเรียนฟรี  </h3>

            <div>

              @if($course_free != NULL)
              @foreach($course_free as $coursesfinn)
          <div style="margin-bottom:20px; padding-bottom:5px; border-bottom: 1px solid #eee;">
          <a href="{{url('user_course_detail/'.$coursesfinn->Cid)}}"><img src="{{url('assets/uploads/'.$coursesfinn->image_course)}}" class="img-responsive" style="height:100px; float:left; margin-right:8px;"></a>
          <a href="{{url('user_course_detail/'.$coursesfinn->Cid)}}">{{$coursesfinn->title_course}}</a><br>

          <td class="text-right">วันที่เรียน : {{$coursesfinn->day_course}}</td><br>
          <td class="text-right">เวลาที่เรียน : {{$coursesfinn->time_course}}</td><br>
          <b class="text-danger">
            @if($coursesfinn->type_course == 3)
              คอร์สเรียนฟรี
            @else
              ราคา : {{$coursesfinn->price_course}} THB
            @endif


          </b>
          </div>
              @endforeach

              @else
              <p><b>ยังไม่มีคอร์สเรียน ปรึกษาเราได้ <a href="{{url('user_ans')}}">(มาที่เมนูคำถามของฉัน)</a></b></p>
              @endif

            </div>

            <br>
            <h3 class="ap-user-page-title clearfix">คอร์สที่ฉันจองไว้  </h3>

            <div>
              @if($courseinfos != NULL)
              @foreach($courseinfos as $courses)
              <div style="margin-bottom:20px; padding-bottom:5px; border-bottom: 1px solid #eee;">
    <a href=""><img src="{{url('assets/uploads/'.$courses->image_course)}}" class="img-responsive" style="height:100px; float:left; margin-right:8px;"></a>
    <a href="{{url('')}}">{{$courses->title_course}}</a><br>

    <td class="text-right">วันที่เรียน : {{$courses->day_course}}</td><br>
    <td class="text-right">เวลาที่เรียน : {{$courses->time_course}}</td><br>
    <b class="text-danger">ราคา : {{$courses->price_course}} THB</b>
    <a type="button" style="color:#fff" class="btn btn-danger btn-xs">กำลังดำเนินการ</a>
    </div>
              @endforeach


              @else
              <p><b>ยังไม่มีคอร์สเรียน ปรึกษาเราได้ <a href="{{url('user_ans')}}">(มาที่เมนูคำถามของฉัน)</a></b></p>
              @endif

            </div>

          </div>

        </div>

      </div>





<br><br>















              </div>



            </div>

          </div>






          <div class="col-md-3">
              <div id="sidebar" class="affix">
  <div>
    <img class="img-responsive" src="{{url('assets/image/truepanya_by_learnsbuy.jpg')}}">
  </div>
  <a class="themes-widget" href="#/">
    <i class="fa fa-heart-o "></i>
    <div class="no-overflow">
      <strong>{{Auth::user()->user_coin}} Coin</strong>
      <p>จำนวน coin ในการดู video.</p>
    </div>
  </a>
  <a class="themes-widget" href="{{url('wallet')}}">
    <i class="fa fa-credit-card "></i>
    <div class="no-overflow">
      <strong>เติมเงิน Wallet</strong>
      <p>เพิ่ม Coin สำหรับการดู video.</p>
    </div>
  </a>
</div>          </div>



    </div>

 </div>


@endsection


@section('scripts')
<script src="{{url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>
<script src="{{url('assets/date/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('/assets/vendor/pnotify/pnotify.custom.js')}}"></script>
<script>
$.fn.datepicker.defaults.format = "dd/mm/yyyy";
$('.datepicker').datepicker({
});
</script>

@if ($message = Session::get('success'))
<script type="text/javascript">
PNotify.prototype.options.styling = "fontawesome";
new PNotify({
      title: 'ยินดีด้วยค่ะ',
      text: '{{$message}}',
      type: 'success'
    });
</script>
@endif



@if ($errors->has())
<script type="text/javascript">
PNotify.prototype.options.styling = "fontawesome";
new PNotify({
      title: 'เสียใจด้วยนะ',
      text: 'ใส่ข้อมูลให้ครบนะจ๊ะ',
      type: 'error'
    });
</script>
@endif



@stop('scripts')
