
@extends('layouts.app')
@section('stylesheet')
<link href="{{url('assets/css/select-project.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/css/confirm.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{asset('./assets/datepicker/css/datepicker.css')}}">
<link rel="stylesheet" href="{{url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css')}}">

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
         <h2>{{$objs->title_course}} <span class="head-lines"></span></h2>

          <div class="col-xs-12  col-md-6 extra-paddingright ">

            <div class="">
            <div class="col-md-12 course-overall-wrapper">
              <h4>รายละเอียด คอร์สเรียน ที่สั่งซื้อ</h4>
            <table class="table table-striped">
                <tr>
                  <td>ชื่อผู้เรียน</td>
                  <td class="text-right">{{Auth::user()->name}}</td>
                </tr>
                <tr>
                  <td>ชื่อคอร์ส</td>
                  <td class="text-right">{{$objs->title_course}}</td>
                </tr>

                <tr>
                  <td>วันที่เรียน</td>
                  <td class="text-right">{{$objs->day_course}}</td>
                </tr>
                <tr>
                  <td>เวลาที่เรียน</td>
                  <td class="text-right">{{$objs->time_course}}</td>
                </tr>

                <tr>
                  <td><i class="fa fa-cloud-download"></i> เอกสารการเรียน</td>
                  <td class="text-right"> จัดส่งฟรี</td>
                </tr>
                <tr>
                  <td><i class="fa fa-video-camera"></i> วีดีโอย้อนหลัง</td>
                  <td class="text-right"> มีให้</td>
                </tr>

                <tr>
                  <br>
                  <td><h3> ยอดชำระ</h3></td>
                  <td class="text-right"><h3> @if($objs->price_course == 0)
                      Free course
                                              @else
                                        {{$objs->price_course}}  บาท
                                              @endif
                                               </h3></td>
                </tr>



              </table>




              </div>
              </div>

          </div>




          <div class="col-xs-12  col-md-6">

            <div class="">
            <div class="col-md-12 course-overall-wrapper">
              <h4>กรอกข้อมูลติดต่อ</h4>
              <p class="text-danger">*นักเรียนต้องกรอกข้อมูลส่วนตัวให้ครบก่อนนะ</p>
              @if ($message = Session::get('hbd'))
                  <span class="help-block">
                      <strong class="text-danger">**กรอกวันเกิดนักเรียนด้วยนะจ๊ะ ไม่ใช่ ปี0000 เดือน00 วัน00</strong>
                  </span>
              @endif
              <hr>

              @if($objs->type_course == 3)
              <form action="{{url('/submit_course_free/'.$objs->id)}}" method="post" enctype="multipart/form-data" name="product">
              @else
              <form action="{{url('/submit_course/'.$objs->id)}}" method="post" enctype="multipart/form-data" onSubmit="return checkemail()" name="product">
              @endif


                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <label for="exampleInputPassword1">ชื่อ-นามสกุล (ภาษาไทย)</label>
                  <input type="text" class="form-control input-sm" name="name" value="{{Auth::user()->name}}">
                  @if ($errors->has('name'))
                      <span class="help-block">
                          <strong class="text-danger">กรอกชื่อนักเรียนด้วยนะจ๊ะ</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">เบอร์โทร</label>
                  <input type="text" class="form-control input-sm" name="phone" value="{{old('phone', Auth::user()->phone)}}">
                  @if ($errors->has('phone'))
                      <span class="help-block">
                          <strong class="text-danger">กรอกเบอร์โทรนักเรียนด้วยนะจ๊ะ</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="email" class="form-control input-sm" id='email' name="email" value="{{Auth::user()->email}}" >
                </div>

                <style>
                .hbd_form{
                  height:60px;
                }
                @media (max-width: 768px){
                  .hbd_form{
                    height:125px;
                  }
                }

                </style>

                @if(Auth::user()->hbd == "0000-00-00" || Auth::user()->hbd == null)

                <div class="form-group hbd_form" >
                  <label for="exampleInputEmail1" class="col-md-12">วันเกิด</label>

                  <div class="col-md-4">
                    <select name="day_hbd" class="form-control mb-md" required>
                      <option value="">-- วันที่ --</option>
                      @for ($i = 1; $i <= 32; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                      @endfor

                    </select>
                  </div>
                  <div class="col-md-4">
                    <select name="mo_hbd" class="form-control mb-md" required>
                      <?php $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม "); ?>
                      <?PHP for($i=0; $i<sizeof($month); $i++) {?>
                      <option value="<?PHP echo $i?>">
                      <?PHP echo $month[$i]?></option>
                      <?PHP }?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control input-sm " id='hbd' name="year_hbd" placeholder="1995 ปีเกิดนักเรียน">
                  </div>

                </div>

                @else

                <?php
                $pieces = explode("-", Auth::user()->hbd);
                ?>

                <div class="form-group hbd_form" >
                  <label for="exampleInputEmail1" class="col-md-12">วันเกิด</label>

                  <div class="col-md-4">
                    <select name="day_hbd" class="form-control mb-md" required>
                      <option value="">-- วันที่ --</option>
                      @for ($i = 1; $i <= 32; $i++)
                          <option value="{{ $i }}"
                          @if($pieces[2] == $i)
                          selected='selected'
                          @endif
                          >{{ $i }}</option>
                      @endfor

                    </select>
                  </div>
                  <div class="col-md-4">
                    <select name="mo_hbd" class="form-control mb-md" required>
                      <?php $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม "); ?>
                      <?PHP for($i=0; $i<sizeof($month); $i++) {?>
                      <option value="<?PHP echo $i?>" @if(($pieces[1]-1) == $i)
                      selected='selected'
                      @endif>
                      <?PHP echo $month[$i]?></option>
                      <?PHP }?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control input-sm " id='hbd' name="year_hbd" value="{{$pieces[0]}}" placeholder="1995 ปีเกิดนักเรียน">
                  </div>

                </div>

                @endif



              <!--  <div class="form-group">
                  <label for="exampleInputEmail1">ปี-เดือน-วันเกิด</label>
                  <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input type="text" data-plugin-datepicker="" name="hbd" value="{{ Auth::user()->hbd}} "
                  class="form-control datepicker">

                </div>
              </div> -->

                <div class="form-group">
                  <label for="exampleInputPassword1">Line ID</label>
                  <input type="text" class="form-control input-sm" name="line" value="{{old('line', Auth::user()->line_id)}}">
                  @if ($errors->has('line'))
                      <span class="help-block">
                          <strong class="text-danger">กรอกไอดีไลน์ นักเรียนด้วยนะจ๊ะ</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">ที่อยู่จัดส่งเอกสาร, หนังสือเรียน *</label>
                  <textarea class="form-control" rows="2" name="address" id="comment">{{old('address', Auth::user()->address)}}</textarea>
                  @if ($errors->has('address'))
                      <span class="help-block">
                          <strong class="text-danger">กรอกที่อยู่ เพื่อรับเอกสารและหนังสือเรียนด้วยนะจ๊ะ </strong>
                      </span>
                  @endif
                </div>

                <button type="submit" class="btn btn-success1 btn-lg btn-block"><i class="fa fa-upload"></i> บันทึกและไปขั้นตอนต่อไป</button>
              </form>
              <br><br>
              </div>
              </div>

          </div>


        </div>
    </div>




</div>
</div>
@endsection


@section('scripts')
<script src="{{asset('/assets/datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{url('assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>
<script>
$('.datepicker').datepicker({
  changeYear: true,
	yearRange: '1930:2000',
  dateFormat: 'yyyy-mm-dd'
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
