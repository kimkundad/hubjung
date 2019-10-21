@extends('packag.layouts.template')

@section('stylesheet')
<link rel="stylesheet" href="{{asset('./assets/datepicker/css/datepicker.css')}}">
@stop('stylesheet')
@section('content')





<div class="row">
    <div class="col-lg-9">

      @if($pack->package_type == 0)
      <div class="osahan-progress">
         <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="38"   aria-valuemin="0" aria-valuemax="100" style="width: 38%"></div>
         </div>
         <div class="row">
           <div class="col-sm-3 text-center">
             <h6>เลือก Package</h6>
           </div>
           <div class="col-sm-3 text-center">
             <h6>กรอกข้อมูลติดต่อ</h6>
           </div>
           <div class="col-sm-3 text-center">
             <h6>กรอกการชำระเงิน</h6>
           </div>
           <div class="col-sm-3 text-center">
             <h6>สำเร็จ</h6>
           </div>
         </div>
      </div>
      @else
      <div class="osahan-progress">
         <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="38"   aria-valuemin="0" aria-valuemax="100" style="width: 38%"></div>
         </div>
         <div class="row">
           <div class="col-sm-3 text-center">
             <h6>เลือก Package</h6>
           </div>
           <div class="col-sm-3 text-center">
             <h6>กรอกข้อมูลติดต่อ</h6>
           </div>
           <div class="col-sm-3 text-center">
             <h6>ยืนยันการสมัคร</h6>
           </div>
           <div class="col-sm-3 text-center">
             <h6>สำเร็จ</h6>
           </div>
         </div>
      </div>
      @endif


      <br />
      <br />
      </div>



 </div>



                  <div class="row">
                     <div class="col-sm-3">
                       <div class="main-title">
                          <h6>Package</h6>
                       </div>
                       <div class="video-card">
                          <div class="video-card-image">

                             <a href="#"><img class="img-fluid" src="{{url('web_stream/img/package/'.$pack->package_image)}}" alt="{{$pack->package_name}}"></a>

                          </div>
                          <div class="video-card-body">
                             <div class="video-title">
                                <a href="#">{{$pack->package_name}}</a>
                             </div>

                          </div>
                       </div>

                     </div>
                     <div class="col-sm-6">
                       <div class="main-title">
                          <h6>กรอกข้อมูลติดต่อ</h6>
                          @if ($message = Session::get('hbd'))
                              <span class="help-block">
                                  <strong class="text-danger">**กรอกวันเกิดนักเรียนด้วยนะจ๊ะ ไม่ใช่ ปี0000 เดือน00 วัน00</strong>
                              </span>
                          @endif
                       </div>

                       <form action="{{url('/submit_info_package/')}}" method="post" enctype="multipart/form-data" onSubmit="return checkemail()" name="product">

                         {{ csrf_field() }}
                        <div class="form-group">
                           <label class="control-label">ชื่อ-นามสกุล (ภาษาไทย) <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="{{Auth::user()->name}}" name="name" type="text">
                           <input class="form-control border-form-control" value="{{$pack->id}}" name="packag_id" type="hidden">
                           <input class="form-control border-form-control" value="{{$pack->package_type}}" name="package_type" type="hidden">
                           @if ($errors->has('name'))
                               <span class="help-block">
                                   <strong class="text-danger">กรอกชื่อนักเรียนด้วยนะจ๊ะ</strong>
                               </span>
                           @endif
                        </div>

                        <div class="form-group">
                           <label class="control-label">เบอร์ติดต่อ <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="{{old('phone', Auth::user()->phone)}}" name="phone" type="text">
                           @if ($errors->has('phone'))
                               <span class="help-block">
                                   <strong class="text-danger">กรอกเบอร์โทรนักเรียนด้วยนะจ๊ะ</strong>
                               </span>
                           @endif
                        </div>

                        <div class="form-group">
                           <label class="control-label">Email <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="{{Auth::user()->email}}" name="email" type="text">
                        </div>

                        <div class="form-group">
                           <label class="control-label">วันเกิด <span class="required">*</span></label>
                           <input class="form-control border-form-control" id="datepicker"  value="{{ Auth::user()->hbd}}" data-provide="datepicker" name="hbd" type="text" data-date-format="yyyy-mm-dd" data-date-language="th-th">
                           @if ($errors->has('hbd'))
                               <span class="help-block">
                                   <strong class="text-danger">กรอกวันเกิดนักเรียนด้วยนะจ๊ะ</strong>
                               </span>
                           @endif
                        </div>


                        <div class="form-group">
                           <label class="control-label">Line ID <span class="required">*</span></label>
                           <input class="form-control border-form-control" value="{{old('line', Auth::user()->line_id)}}" name="line" type="text">
                        </div>

                        <div class="form-group">
                           <label class="control-label">ที่อยู่จัดส่งเอกสาร, หนังสือเรียน * <span class="required">*</span></label>
                           <textarea class="form-control border-form-control" name="address">{{old('address', Auth::user()->address)}}</textarea>
                           @if ($errors->has('address'))
                               <span class="help-block">
                                   <strong class="text-danger">กรอกที่อยู่ เพื่อรับเอกสารและหนังสือเรียนด้วยนะจ๊ะ </strong>
                               </span>
                           @endif
                        </div>

                        <div class="col-sm-12 text-right">
                           <a href="{{url('all_packag')}}" class="btn btn-danger border-none"> ยกเลิก </a>
                           <button type="submit" class="btn btn-success border-none">  บันทึกและไปขั้นตอนต่อไป </button>
                        </div>

                        </form>

                     </div>
                  </div>







               <br /><br />



@endsection

@section('scripts')

<script src="{{asset('/assets/datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('/assets/datepicker/js/bootstrap-datepicker-thai.js')}}"></script>
<script src="{{asset('/assets/datepicker/js/bootstrap-datepicker.th.js')}}"></script>

<script>
$('#datepicker').datepicker({
	yearRange: '1930:2000'
})
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
