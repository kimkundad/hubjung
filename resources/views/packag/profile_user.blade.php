@extends('packag.layouts.template')

@section('stylesheet')
<link rel="stylesheet" href="{{asset('./assets/datepicker/css/datepicker.css')}}">
<link rel="stylesheet" href="{{url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css')}}">
@stop('stylesheet')
@section('content')

<style>
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



                  <div class="row">

                     <div class="col-sm-8">
                       <div class="main-title">
                          <h6>ข้อมูลส่วนตัว</h6>

                       </div>

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









               <br /><br />



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
