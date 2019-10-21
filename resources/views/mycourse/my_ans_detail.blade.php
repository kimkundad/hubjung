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
    padding: 10px 0;
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
    width: 39px;
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
.highlight {
    background-color: #0088CC;
    color: #FFF;
    padding: 4px 7px;
    font-weight: 700;
}
.list_ans{
  margin-left: 20px;
}
.radio-custom {
	position: relative;
	padding: 0 0 0 25px;
	margin-bottom: 7px;
	margin-top: 0;
}

.radio-custom.radio-inline {
	display: inline-block;
	vertical-align: middle;
}

.form-group .radio-custom.radio-inline {
	margin-top: 7px;
	padding-top: 0;
}

.radio-custom:last-child, .radio-custom:last-of-type {
	margin-bottom: 0;
}

.radio-custom input[type="radio"] {
	opacity: 0;
	position: absolute;
	top: 50%;
	left: 3px;
	margin: -6px 0 0 0;
	z-index: 2;
	cursor: pointer;
}

.radio-custom input[type="radio"]:checked + label:after {
	content: '';
	position: absolute;
	top: 50%;
	left: 4px;
	margin-top: -5px;
	display: inline-block;
	font-size: 11px;
	line-height: 1;
	width: 10px;
	height: 10px;
	background-color: #444;
	border-radius: 50px;
	-webkit-box-shadow: 0px 0px 1px #444;
	box-shadow: 0px 0px 1px #444;
}

.radio-custom input[type="radio"]:disabled {
	cursor: not-allowed;
}

.radio-custom input[type="radio"]:disabled:checked + label:after {
	color: #999;
}

.radio-custom input[type="radio"]:disabled + label {
	cursor: not-allowed;
}

.radio-custom input[type="radio"]:disabled + label:before {
	background-color: #eee;
}

.radio-custom label {
	cursor: pointer;
	margin-bottom: 0;
	text-align: left;
	line-height: 1.2;
}

.radio-custom label:before {
	content: '';
	position: absolute;
	top: 50%;
	left: 0;
	margin-top: -9px;
	width: 18px;
	height: 18px;
	display: inline-block;
	border-radius: 50px;
	border: 1px solid #bbb;
	background: #fff;
}

.radio-custom label + label.error {
	display: block;
}

html.dark .radio-custom label:before {
	background: #282d36;
	border-color: #21262d;
}

html.dark .radio-custom input[type="radio"]:checked + label:after {
	background-color: #fff;
}

html.dark .radio-custom input[type="radio"]:disabled + label:before {
	background: #242830;
	border-color: #242830;
}

.radio-primary input[type="radio"]:checked + label:after,
.radio-primary input[type="radio"]:checked + label:after {
	background: #CCC;
	-webkit-box-shadow: 0px 0px 1px #CCC;
	box-shadow: 0px 0px 1px #CCC;
}
html.dark .radio-primary input[type="radio"]:checked + label:after, .radio-primary input[type="radio"]:checked + label:after {
    background: #0088CC;
    -webkit-box-shadow: 0px 0px 1px #0088CC;
    box-shadow: 0px 0px 1px #0088CC;
}

.alert-default {
    background-color: #ebebeb;
    border-color: #e3e3e3;
    color: #6c6c6c;
}
.alert-default .alert-link {
    color: #454545;
}
.alert {
    padding: 1px 15px;
  }
  .social-google {
        padding: 3px 7px;
    color: #fff;
  background-color: #da573b;
  border-color: #be5238;
}
.social-google:hover{
  color: #fff;
  background-color: #be5238;
  border-color: #9b4631;
}

.social-twitter {
      padding: 3px 7px;
  color: #fff;
  background-color: #1daee3;
  border-color: #3997ba;
}
.social-twitter:hover {
  color: #fff;
  background-color: #3997ba;
  border-color: #347b95;
}

.social-facebook {
      padding: 3px 7px;
  color: #fff;
  background-color: #4c699e;
  border-color: #47618d;
}
.social-facebook:hover {
  color: #fff;
  background-color: #47618d;
  border-color: #3c5173;
}

.social-linkedin {
      padding: 3px 7px;
  color: #fff;
  background-color: #4875B4;
  border-color: #466b99;
}
.social-linkedin:hover {
  color: #fff;
  background-color: #466b99;
  border-color: #3b5a7c;
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
          <img data-view="user_avatar_1980" alt="" src="{{url('assets/images/avatar/'.$objs->avatar)}}"
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
            <h3 class="ap-user-page-title clearfix" style="font-size: 20px; color: #a94442;">
              <i class="ap-questions-featured fa fa-graduation-cap" style="font-size: 24px;"></i>
              {{$course_detail->examples_name}}
            </h3>
            <div class="alert alert-default">
              <h5><b style="color: #454545;">หมวดหมู่<b/> : {{$course_detail->name_category}}</h5>
              <h5 style="line-height: 1.4em;"><b syle="color: #454545;">จำนวนข้อ</b> : {{$sum}}</h5>
              <h5 style="line-height: 1.4em;"><b syle="color: #454545;">สร้างเมื่อ</b> : <?php echo DateThai($course_detail->created_at_date); ?></h5>
              <p><span style="color: #25A5A2"><i class="fa fa-share-alt"></i> แชร์ข้อสอบนี้ <i class="fa fa-hand-o-right"></i></span> &nbsp&nbsp
                <a style="color: #fff;" class="btn btn-primary social-login-btn social-facebook" href="#"><i class="fa fa-facebook"></i></a>
                <a style="color: #fff;" class="btn btn-primary social-login-btn social-twitter" href="#"><i class="fa fa-twitter"></i></a>
                <a style="color: #fff;" class="btn btn-primary social-login-btn social-linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                <a style="color: #fff;" class="btn btn-primary social-login-btn social-google" href="#"><i class="fa fa-google-plus"></i></a>
                </p>
            </div>





            <div>
              <h5 style="line-height: 1.4em;"><b syle="color: #454545;">รายละเอียด</b> : {{$course_detail->examples_detail}}</h5>
                <form id="newsForm" id="formID" action="{{url('ans_detail_post')}}"  method="post" enctype="multipart/form-data" style="font-size: 12px;">
                  {{ csrf_field() }}

                  @if($course_tech)
                        @foreach($course_tech as $u)
                        <input type="hidden" class="form-control" name="examples_id" value="{{$u->category_id}}" >
                        <input type="hidden" class="form-control" name="cat_id" value="{{$course_detail->cat_id}}" >

                        <div class="form-group" style="border-bottom: 1px solid #efefef;">

                                <br>
                <label class="control-label"><!--{{$list}}.--> {{$u->name_questions}}</label>
                @if($u->image != null)
                <img src="{{url('assets/uploads/'.$u->image)}}" class="img-responsive" style="max-height:350px;">
                @endif
                  <fieldset id="group{{$u->id_questions}}">

                    @foreach($u->options as $uu)


                        @if($uu->type_option == 2)
                        <input type="hidden" class="form-control" name="examples_type" value="2" >
                    <div class="radio-custom radio-primary" id="{{ $s++}}" style="margin-top:15px;">

                  <!--    <input type="hidden" class="form-control" name="option_id" value="{{$uu->id_option}}" >
                      <input type="hidden" class="form-control" name="q_id" value="{{$uu->question_id}}" >  -->

												<input type="radio" name="value_{{$uu->question_id}}" value="{{$uu->id_option}}" required>
												<label for="radioExample2">{{$uu->name_option}}</label>
										</div>

                    @if($s == 4)
                <div style="display:none">  {{$s = 0}}  </div>
                    @else
                    @endif
                        @else
                        <input type="hidden" class="form-control" name="examples_type" value="1" >
                          <textarea class="form-control" rows="3" name="value_{{$uu->question_id}}" required></textarea>
                        @endif

                    @endforeach

                  <fieldset {{$list++}}>


                    </div>



                        @endforeach
                  @endif


                  <button type="submit" class="btn btn-success">ส่งคำตอบ</button>
                </form>
            </div>

            <br>


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
var form = document.getElementById('formID'); // form has to have ID: <form id="formID">
form.noValidate = true;
form.addEventListener('submit', function(event) { // listen for form submitting
        if (!event.target.checkValidity()) {
            event.preventDefault(); // dismiss the default functionality
            alert('กรุณากรอกข้อมูลให้ครบด้วยค่ะ'); // error message
        }
    }, false);
</script>

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
