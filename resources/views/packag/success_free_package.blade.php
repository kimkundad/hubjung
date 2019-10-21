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
    <div class="col-lg-9">

      <div class="osahan-progress">
         <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100"   aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
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


                     <div class="col-sm-7">




                       <div class="main-title">
                          <h6 class="text-success">ทำการสมัครทดลองเรียนฟรี สำเร็จ</h6>

                       </div>
                       <p>
                         Package ฟรีที่นักเรียนได้ทำการสมัครไปนั้น จะสามารถดู Video ได้เป็นบางส่วนที่ทาง learnsbuy ได้ตั้งค่าไว้แล้วเท่านั้น
                         ในระหว่างการใช้ Package ฟรี นักเรียนสมารถ เข้าไปคลังข้อสอบและสามารถทำข้อสอบได้ปกติ แต่ถ้าหากนักเรียนต้องการสมัคร
                         Package รายเดือน นักเรียนสามารถสมัครได้ทันที โดยไม่ต้องรอให้หมดอายุก่อน
                       </p>




                         <div class="form-group course-overall-wrapper">
                            <label class="control-label">ข้อมูล Package</label>
                            <table class="table table-striped">
                              <tbody>
                              <tr>
                                <tr>
                                  <td><label class="control-label">{{$pack->package_name}}</label></td>
                                </tr>
                                <tr>
                                  <td><label class="control-label">อายุการใช้งาน {{$pack->package_day}} / วัน</label></td>
                                </tr>
                                <tr>
                                  <td><label class="control-label">สมัครประเภท ทดลองเรียนฟรี</label></td>
                                </tr>

                                <tr>
                                  <td><label class="control-label">เริ่มใช้งานได้ {{$check->start}}</label></td>
                                </tr>

                                <tr>
                                  <td><label class="control-label">สิ้นสุดวันที่ {{$check->end_date}}</label></td>
                                </tr>



                            </tbody>
                          </table>
                         </div>



                         <div class="col-sm-12 text-right">

                            <a href="{{url('account')}}" class="btn btn-success border-none">  กลับไปยังหน้าหลัก </a>
                         </div>






                     </div>
                  </div>







               <br /><br />



@endsection

@section('scripts')
<script src="{{url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>
<script src="{{asset('/assets/datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('/assets/datepicker/js/bootstrap-datepicker-thai.js')}}"></script>
<script src="{{asset('/assets/datepicker/js/bootstrap-datepicker.th.js')}}"></script>
<script>
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
