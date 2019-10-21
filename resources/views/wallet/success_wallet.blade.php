
@extends('layouts.app')
@section('stylesheet')
<link href="{{url('assets/css/select-project.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/css/confirm.css')}}" rel="stylesheet" type="text/css" />
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
    .status{
      font-size: 15px;
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
        <div class="col-md-10 col-md-offset-3" >
         <h3 style="margin-bottom: 0px;" class="">{{$courseinfo->name_card}} <span class="head-lines"></span></h3>

          <div class="col-xs-12  col-md-8 ">

              @if($courseinfo->status == 0)
              <h3 class="text-center" style="color:#f36510">
                <i class="fa fa-smile-o"></i> รอการตรวจสอบ
              </h3>
              <img src="{{url('assets/uploads/'.$courseinfo->image_card)}}" class="img-responsive" style="margin: 0 auto">
              <br>
              <p class="text-center"> ระบบได้ทำการส่ง ใบเสร็จของการซื้อบัตรเติมเงิน Learnsbuy ไปที่อีเมล์ของคุณแล้วครับ หลังจากที่เจ้าหน้าที่ทำการตรวจสอบข้อมูล จะทำการส่งอีเมล์แจ้งให้เริ่มเรียนได้ภายใน 48 ชม. จากนั้นเจ้าหน้าที่จะทำการเติมเงินเข้าสู่ระบบ</p>

              @endif




            <div class="">
            <div class="col-md-12 course-overall-wrapper">
              <h4>บิลเลขที่ {{$courseinfo->Uid}}</h4>
            <table class="table table-striped">
                <tr>
                  <td>ชื่อผู้เรียน</td>
                  <td class="text-right">{{$courseinfo->name}}</td>
                </tr>
                <tr>
                  <td>บัตรเติมเงิน</td>
                  <td class="text-right">{{$courseinfo->name_card}}</td>
                </tr>
                <tr>
                  <td>ช่วงวันที่เติม</td>
                  <td class="text-right"><?php echo DateThai($courseinfo->date_transfer); ?></td>
                </tr>
                <tr>
                  <td>เวลา</td>
                  <td class="text-right">{{$courseinfo->time_transfer}}</td>
                </tr>
                <tr>
                  <td>Coin ที่ได้รับ</td>
                  <td class="text-right">{{$courseinfo->card_point}}</td>
                </tr>

                <tr>
                  <td><b class="status"> สถานะ</b></td>
                  <td class="text-right text-danger"> <b class="status">โอนเงินแล้ว </b></td>
                </tr>

                <tr>
                  <br>
                  <td><h3> ยอดชำระ</h3></td>
                  <td class="text-right"><h3> {{$courseinfo->money_user}} บาท</h3></td>
                </tr>
              </table>

              <a type="submit" href="{{url('/')}}" class="btn btn-success1 btn-lg btn-block"><i class="fa fa-upload"></i> กลับสู่หน้าหลัก</a>
              <br>
              </div>
              </div>



          </div>







        </div>
    </div>



</div>
</div>
@endsection
