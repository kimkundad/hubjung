@extends('packag.layouts.single-channel')

@section('stylesheet')
<link rel="stylesheet" href="{{asset('./assets/datepicker/css/datepicker.css')}}">
<link rel="stylesheet" href="{{url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css')}}">
@stop('stylesheet')
@section('content')

<style>
.z-1 {
    font-size: 14px;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
.t-l{
  padding-left: 8px;
}
.course-overall-wrapper {
    background: #ffffff;
    border: 1px solid #ddd;
    padding: 7px;
}
.main-title{
  font-size: 18px;
}
.btn-file {
    border-color: #dcdfdf;
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

<div class="single-channel-image">
               <img class="img-fluid" alt="" src="{{url('assets/images/channel-banner.png')}}">
               <div class="channel-profile">
                  <img class="channel-profile-img" alt="" src="{{url('assets/images/avatar/'.Auth::user()->avatar)}}">

               </div>
            </div>

<div class="single-channel-nav">
               <nav class="navbar navbar-expand-lg navbar-light">
                  <a class="channel-brand" href="#">{{Auth::user()->name}} <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                           <a class="nav-link" href="{{url('account')}}">My Package </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="{{url('my_history')}}">ประวัติการเติม </a>
                        </li>

                        <li class="nav-item active">
                           <a class="nav-link" href="{{url('profile_user_package')}}">ข้อมูลส่วนตัว </a>
                        </li>

                        <li class="nav-item ">
                           <a class="nav-link" href="{{url('my_example')}}">ผลข้อสอบ </a>
                        </li>





                     </ul>
                    <!-- <form class="form-inline my-2 my-lg-0">


                        <button class="btn btn-outline-danger btn-sm" type="button">Subscribe <strong>1.4M</strong></button>
                     </form> -->
                  </div>
               </nav>
            </div>

                  <div class="container-fluid">
                    <div class="row">









                  <div class="col-lg-8">
                     <div class="main-title">
                        <h6>ข้อมูลส่วนตัว </h6>
                     </div>
                     <hr>

                     <form action="{{url('update_user_package/')}}" method="post" enctype="multipart/form-data" onSubmit="return checkemail()" name="product">
                       {{ csrf_field() }}


                     <div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                         <label class="control-label">ชื่อนักเรียน <span class="required">*</span></label>
                         <input class="form-control border-form-control" value="{{Auth::user()->name}}" name="nickname" type="text">
                         @if ($errors->has('nickname'))
                             <span class="help-block">
                                 <strong class="text-danger">กรอกชื่อนักเรียนด้วยนะจ๊ะ</strong>
                             </span>
                         @endif
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <div class="form-group">
                         <label class="control-label">อีเมล์ <span class="required">*</span></label>
                         <input class="form-control border-form-control" value="{{Auth::user()->email}}"  type="text" readonly>
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <div class="form-group">
                         <label class="control-label">เบอร์โทร <span class="required">*</span></label>
                         <input class="form-control border-form-control" value="{{Auth::user()->phone}}" name="phone"  type="text">
                         @if ($errors->has('phone'))
                             <span class="help-block">
                                 <strong class="text-danger">กรอกเบอร์โทรนักเรียนด้วยนะจ๊ะ</strong>
                             </span>
                         @endif
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <div class="form-group">
                         <label class="control-label">ID Line <span class="required">*</span></label>
                         <input class="form-control border-form-control" value="{{Auth::user()->line_id}}" name="line_id"  type="text">
                      </div>
                   </div>
                   <div class="col-sm-6">
                      <div class="form-group">
                         <label class="control-label">วันเกิดของฉัน <span class="required">*</span></label>

                         <input class="form-control border-form-control" id="datepicker"  value="{{ Auth::user()->hbd}}" data-provide="datepicker" name="hbd" type="text" data-date-format="yyyy-mm-dd" data-date-language="th-th">
                         @if ($errors->has('hbd'))
                             <span class="help-block">
                                 <strong class="text-danger">กรอกวันเกิดนักเรียนด้วยนะจ๊ะ</strong>
                             </span>
                         @endif
                      </div>
                   </div>

                   <div class="col-sm-6">
                   <div class="form-group">
                     <label for="exampleInputEmail1">รูปประจำตัว</label>
                     <div class="fileupload fileupload-new" data-provides="fileupload">
                       <div class="input-append">
                         <div class="uneditable-input">
                           <i class="fa fa-file fileupload-exists" style="float:left; margin-right:8px;"></i>
                           <span class="fileupload-preview"></span>
                         </div>
                         <span class="btn btn-default btn-file">
                           <span class="fileupload-exists">Change</span>
                           <span class="fileupload-new">Select file</span>
                           <input type="file" name="image"/>
                         </span>
                         <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                       </div>
                     </div>

                   </div>
                   </div>


                   <div class="col-sm-12">
                      <div class="form-group">
                         <label class="control-label">ที่อยู่ <span class="required">*</span></label>
                         <textarea class="form-control border-form-control" name="address">{{Auth::user()->address}}</textarea>
                         @if ($errors->has('address'))
                             <span class="help-block">
                                 <strong class="text-danger">กรอกที่อยู่ เพื่อรับเอกสารและหนังสือเรียนด้วยนะจ๊ะ </strong>
                             </span>
                         @endif
                      </div>
                   </div>
                   <div class="col-sm-12 text-right">

                      <button type="submit" class="btn btn-success border-none">  อัพเดทข้อมูล </button>
                   </div>
                </div>


                </form>
                  </div>














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
<script src="{{url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>
<script src="{{asset('/assets/datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('/assets/datepicker/js/bootstrap-datepicker-thai.js')}}"></script>
<script src="{{asset('/assets/datepicker/js/bootstrap-datepicker.th.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



<script>

@if ($message = Session::get('success'))
  swal("สำเร็จ!", "ทำการอัพเดทข้อมูลสำเร็จ!", "success");
@endif


$('#datepicker').datepicker();
</script>

<script language="javaScript">
function checkemail(str){
	var emailFilter=/^.+@.+\..{2,3}$/;
	var str=document.form.text1.value;
if (!(emailFilter.test(str))) {
       alert ("ท่านใส่อีเมล์ไม่ถูกต้อง");
	   return false;
}
    return true;
}
</script>
@stop('scripts')
