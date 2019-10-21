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
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="62"   aria-valuemin="0" aria-valuemax="100" style="width: 62%"></div>
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
                          <h6>กรอกการชำระเงิน</h6>
                       </div>

                       <form action="{{url('/submit_payment_package/')}}" method="post" enctype="multipart/form-data" onSubmit="return checkemail()" name="product">
                         {{ csrf_field() }}

                         <div class="form-group course-overall-wrapper">
                            <label class="control-label">ยอดชำระ <span class="main-title text-danger" style="margin-bottom: 0rem;">{{number_format($pack->package_price,2)}} บาท</span></label>
                            <table class="table table-striped">
                              <tbody>
                              <tr>
                                <tr>
                                  <td colspan="4"><label class="control-label">ช่องทางการชำระเงิน</label></td>
                                </tr>
                              @if(isset($bank))
                              @foreach($bank as $u)
                              <tr>
                                <td><img class="media-object img-circle " src="{{url('assets/images/bank/'.$u->image)}}" height="35" alt="..."> ชื่อผู้เรียน</td>
                                <td class="text-right">{{$u->bank_name}}</td>
                                <td>{{$u->bank_number}}</td>
                                <td class="text-right">{{$u->bank_owner}}</td>
                              </tr>
                              @endforeach
                              @endif
                            </tbody>
                          </table>
                         </div>


                         <div class="form-group">
                            <label for="exampleInputPassword1">เลือกธนาคารที่โอน <span class="text-danger">(*จำเป็น)</span></label>
                            <select class="form-control" name="bankname" >
                              <option value="">--เลือกธนาคาร--</option>
                              @foreach($bank as $banks)
                              <option value="{{$banks->id}}">{{$banks->bank_name}}</option>
                              @endforeach
                            </select>
                            @if ($errors->has('bankname'))
                                <span class="help-block">
                                    <strong class="text-danger">เลือกธนาคารด้วยนะจ๊ะ</strong>
                                </span>
                            @endif
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">ยอดโอน <span class="text-danger">(*จำเป็น)</span></label>
                            <input type="number" class="form-control" name="totalmoney" >
                            @if ($errors->has('totalmoney'))
                                <span class="help-block">
                                    <strong class="text-danger">ใส่ยอดโอนด้วยนะจ๊ะ</strong>
                                </span>
                            @endif
                          </div>

                          <div class="form-group">
                            <label for="exampleInputEmail1">สลิปโอนเงิน (*ถ้ามี)</label>
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

                          <div class="row">
                            <div class="col-lg-6">

                              <div class="form-group bank">
                                <label for="exampleInputEmail1">วันที่โอน <span class="text-danger">(*จำเป็น)</span></label>
                                <div class="input-group">
                                  <input class="form-control border-form-control" value="{{$pack->id}}" name="packag_id" type="hidden">
                                  <input class="form-control border-form-control" id="datepicker"  data-provide="datepicker" name="day" type="text" data-date-format="yyyy-mm-dd" data-date-language="th-th">
                                  @if ($errors->has('day'))
                                      <span class="help-block">
                                          <strong class="text-danger">ใส่วันที่โอนด้วยนะจ๊ะ</strong>
                                      </span>
                                  @endif
                                </div>

                              </div>

                            </div>
                            <div class="col-lg-6">

                              <div class="form-group bank" >
                                <label for="exampleInputEmail1">เวลาที่โอน</label>
                                <input type="text" class="form-control" name="timer" >
                              </div>

                            </div>




                          </div>





                        <div class="col-sm-12 text-right">
                          <br />
                           <a href="{{url('all_packag')}}" class="btn btn-danger border-none"> ยกเลิก </a>
                           <button type="submit" class="btn btn-success border-none">  บันทึกและไปขั้นตอนต่อไป </button>
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
