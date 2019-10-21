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
             <h6>กรอกการชำระเงิน</h6>
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
                          <h6>ยืนยันชำระเงินสำเร็จแล้ว</h6>

                       </div>
                       <p>
                         ระบบได้ส่งใบเสร็จการซื้อคอร์สแบบรายเดือนของ Learnsbuy ไปที่อีเมลของคุณแล้วครับ    หลังจากที่เจ้าหน้าที่ตรวจสอบข้อมูล จะส่งอีเมลแจ้งให้เริ่มเรียนได้ภายใน 48 ชม.  หนังสือเรียนจะถูกจัดส่งไปตามที่อยู่ ใช้เวลา 3-14 วัน (ขึ้นอยู่กับสต็อกหนังสือและไปรษณีย์ครับ)
                       </p>

                         <div class="form-group course-overall-wrapper">
                            <label class="control-label">ข้อมูลที่นักเรียนยื่นชำระเงิน</label>
                            <table class="table table-striped">
                              <tbody>
                              <tr>
                                <tr>
                                  <td><label class="control-label">ORDER ID</label></td>
                                  <td>
                                    {{$his->id}}
                                  </td>
                                </tr>
                                <tr>
                                  <td><label class="control-label">Package</label></td>
                                  <td>
                                    {{$pack->package_name}}
                                  </td>
                                </tr>
                                <tr>
                                  <td><label class="control-label">รายละเอียด Package</label></td>
                                  <td>
                                    {{$pack->package_day}} / วัน , คอร์สภาษา{{$depart->name_department}}
                                  </td>
                                </tr>

                                <tr>
                                  <td><label class="control-label">ราคา</label></td>
                                  <td>
                                    {{$pack->package_price}} / บาท
                                  </td>
                                </tr>

                                <tr>
                                  <td><label class="control-label">ชื่อนักเรียน</label></td>
                                  <td>
                                    {{$user->name}}
                                  </td>
                                </tr>

                                <tr>
                                  <td><label class="control-label">จำนวนเงิน</label></td>
                                  <td>
                                    {{$his->money_tran}}
                                  </td>
                                </tr>

                                <tr>
                                  <td><label class="control-label">โอนเข้าธนาคาร</label></td>
                                  <td>
                                    {{$banks->bank_name}}
                                  </td>
                                </tr>

                                <tr>
                                  <td><label class="control-label">วัน / เวลา</label></td>
                                  <td>
                                    {{$his->date_tran}} / {{$his->time_tran}}
                                  </td>
                                </tr>

                                @if($his->slip_img != null)
                                <tr>
                                  <td><label class="control-label">หลักฐานการโอนเงิน</label></td>
                                  <td>
                                    <img class="img-fluid" src="{{url('assets/bill/'.$his->slip_img)}}" >
                                  </td>
                                </tr>
                                @endif


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
