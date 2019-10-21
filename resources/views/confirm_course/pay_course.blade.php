<meta name="csrf-token" content="{{ csrf_token() }}" />
@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet" href="{{url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css')}}">
<link href="{{url('assets/css/select-project.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/css/confirm.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{url('assets/date/css/bootstrap-datepicker.standalone.css')}}">
<style type="text/css">

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
h2{

  margin-bottom: 30px;
}
h4{
  margin-top: 20px;
}
.extra-paddingright {
    padding-left: 5px;
}

    .course-overall-wrapper{

    }
    h4 span{
      font-size: 14px;
      color: #26b899;
    }
    .bank{
    padding-right: 0px;
    padding-left: 0px;
    }

    hr {
    margin-top: 10px;
    margin-bottom: 10px;
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
         <h3>{{$courseinfo->title_course}} <span class="head-lines"></span></h3>

          <div class="col-xs-12  col-md-6 extra-paddingright ">

            <div class="">
            <div class="col-md-12 course-overall-wrapper">
              <h4>บิลเลขที่ {{$courseinfo->Oid}}</h4>
            <table class="table table-striped">
                <tr>
                  <td>ชื่อผู้เรียน</td>
                  <td class="text-right">{{$courseinfo->name}}</td>
                </tr>
                <tr>
                  <td>คอร์สที่สั่งซื้อ</td>
                  <td class="text-right">{{$courseinfo->title_course}}</td>
                </tr>

                <tr>
                  <td>วันที่เรียน</td>
                  <td class="text-right">{{$courseinfo->day_course}}</td>
                </tr>
                <tr>
                  <td>ที่อยู่จัดส่งเอกสาร</td>
                  <td class="text-right">{{$courseinfo->address}}</td>
                </tr>
                <tr>
                  <td>เวลาที่เรียน</td>
                  <td class="text-right">{{$courseinfo->time_course}}</td>
                </tr>

                <tr>
                  <td><i class="fa fa-cloud-download"></i> เอกสารการเรียน</td>
                  <td class="text-right"> จัดส่งฟรี</td>
                </tr>
                <tr>
                  <td><i class="fa fa-video-camera"></i> วีดีโอย้อนหลัง</td>
                  <td class="text-right"> มีให้</td>
                </tr>

                @if(Session::get('coupon') != null && Session::get('coupon.course') == $courseinfo->course_id)
                <tr>
                  <td>นักเรียนใช้คูปอง ส่วนลด</td>
                  <td class="text-right"> {{Session::get('coupon.price')}} บาท</td>
                </tr>
                @endif
                <tr>
                  <br>
                  <td><h3> ยอดชำระ </h3></td>
                  <td class="text-right">


                                      <h3 class="writeinfo3">{{$courseinfo->price_course}} บาท</h3>
                                      <h3 class="writeinfo2"></h3>

                                    </td>
                </tr>
              </table>




              <style>
              .postal-code > input {
                  border: 1px solid #f1f1f1;
                  color: #555555;
                  height: 38px;
                  line-height: 25px;
                  margin-bottom: 27px;
                  outline: medium none;
                  padding: 0 10px;
                  width: 300px;
              }
              .postbutton  {
                  background: #252531 none repeat scroll 0 0;
                  border: 0 none;
                  color: #ffffff;
                  cursor: pointer;
                  display: inline-block;
                  font-size: 13.3px;
                  font-weight: 600;
                  letter-spacing: 0.2px;
                  line-height: 39px;
                  padding: 0 27px;
                  text-transform: uppercase;
              }
              </style>


              <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="postal-code">
                                          <div class="writeinfo" style="    font-size: 16px;"></div>
                                            <input type="text" name="coupon" class="coupon" value="{{ old('coupon') }}" placeholder="ใส่ รหัส Coupon">
                                            <input type="hidden" name="course" class="max_price" value="{{$courseinfo->course_id}}" placeholder="">
                                            <input type="hidden" name="order_id" class="order_id" value="{{$courseinfo->Oid}}" placeholder="">
                                        </div>
                                        <div class="buttons-set">
                                            <button class="postbutton button" type="button"><span>Apply Coupon</span></button>
                                        </div>
                                    </div>
                                </div>
                                <br />


              </div>
              </div>

          </div>




          <div class="col-xs-12  col-md-6">

            <div class="">
            <div class="col-md-12 course-overall-wrapper">
              <h4>แจ้งโอนเงิน <span>( โอนเงินผ่านธนาคาร )</span></h4>
              <hr>

              @foreach($bank as $banks)
              <div class="col-md-6 bank">
                  <div class="media">
                    <div class="media-left">
                      <a href="#">
                        <img class="media-object img-circle " src="{{url('assets/images/bank/'.$banks->image)}}" height="60" alt="...">
                      </a>
                    </div>
                  <div class="media-body" style="text-align:left">
                   <p class="t-gray"> {{$banks->bank_name}}<br>{{$banks->bank_number}}<br>{{$banks->bank_owner}}</p>
                  </div>
            </div>
              </div>
              @endforeach

        <!--      <div class="col-md-6 bank">
                  <div class="media">
                    <div class="media-left">
                      <a href="#">
                        <img class="media-object img-circle " src="{{url('assets/image/kbank.png')}}" height="60" alt="...">
                      </a>
                    </div>
                  <div class="media-body" style="text-align:left">
                   <p class="t-gray"> ธนาคารกสิกรไทย<br>860-0-24048-8<br>kimkundad</p>
                  </div>
            </div>
              </div>

              <div class="col-md-6 bank">
                  <div class="media">
                    <div class="media-left">
                      <a href="#">
                        <img class="media-object img-circle " src="{{url('assets/image/scb.png')}}" height="60" alt="...">
                      </a>
                    </div>
                  <div class="media-body" style="text-align:left">
                   <p class="t-gray"> ธนาคารไทยพาณิชย์<br>860-0-24048-8<br>kimkundad</p>
                  </div>
            </div>
          </div> -->

              <br>

              <div class="col-md-12">
                  <form action="{{url('/bil_course/'.$courseinfo->Oid)}}" method="post" enctype="multipart/form-data" name="product">
                    <input type="hidden" name="_method" value="put">
                    {{ csrf_field() }}
               <div class="form-group">
                  <label for="exampleInputPassword1">เลือกธนาคารที่โอน</label>
                  <select class="form-control" name="bankname" required="">
                    <option value="">--เลือกธนาคาร--</option>
                    @foreach($bank as $banks)
                    <option value="{{$banks->id}}">{{$banks->bank_name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">ยอดโอน</label>
                  <input type="number" class="form-control" name="totalmoney" required="">
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

                <div class="form-group col-md-6 bank" style="width: 48%; margin-right:15px;">
                  <label for="exampleInputEmail1">วันที่โอน</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" data-plugin-datepicker name="day" class="form-control datepicker" required="">
                  </div>

                </div>

                <div class="form-group col-md-6 bank" style="width: 48%; ">
                  <label for="exampleInputEmail1">เวลาที่โอน</label>
                  <input type="text" class="form-control" name="timer" placeholder="10.52น." required="">
                </div>




                <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
                <button type="submit" class="btn btn-success1 btn-lg btn-block"><i class="fa fa-upload"></i> บันทึกข้อมูล</button>
                <br>
              </div>

              </form>

              </div>





              </div>
              </div>

          </div>


        </div>
    </div>



</div>
</div>
@endsection

@section('scripts')
<script src="{{url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>
<script src="{{url('assets/date/js/bootstrap-datepicker.js')}}"></script>
<script>
$.fn.datepicker.defaults.format = "yyyy-mm-dd";
$('.datepicker').datepicker({
});
</script>


<script>
        $(document).ready(function(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(".postbutton").click(function(){
                $.ajax({
                    /* the route pointing to the post function */
                    url: '{{url('post_coupon')}}',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, coupon:$(".coupon").val(), max_price:$(".max_price").val(), order_id:$(".order_id").val()},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        $(".writeinfo").append(data.msg);

                        if(data.status == 'success'){
                          $(".writeinfo3").empty()
                          $(".writeinfo2").append('คุณได้รับส่วนลดจำนวน '+data.coupon);
                          $(".writeinfo3").append({{$courseinfo->price_course}}-data.coupon);

                        }

                        setTimeout(function() {
                             $(".writeinfo").empty()
                        }, 5000);
                    }
                });
            });
       });
    </script>

@stop('scripts')
