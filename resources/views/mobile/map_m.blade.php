
@extends('layouts.app')
@section('stylesheet')
<link href="{{url('assets/css/select-project.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/css/confirm.css')}}" rel="stylesheet" type="text/css" />
@stop('stylesheet')
@section('content')

<style>
.text-green{
      color: #038206;
}
h2 span, h3 span, h4 span, h5 span, h6 span {
    color: #038206;
}
ul.list_order {
    margin: 0 0 30px;
    padding: 0;
    line-height: 30px;
    font-size: 14px;
}
ul.list_order li {
    position: relative;
    padding-left: 40px;
    margin-bottom: 10px;
}
ul.list_order li span {
    background-color: #038206;
    color: #fff;
    position: absolute;
    left: 0;
    top: 0;
    text-align: center;
    font-size: 18px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    line-height: 30px;
}
 ul.list_order {
    list-style: none;
}
.conn{

  color: #888;
}
.navbar{
  display: none;
}
footer{
  display: none;
}
</style>




<div class="container" >
    <div class="row">


        <div class="col-md-12" style="margin-top:40px;">
          <h3>แผนที่ ZA-SHI สาขาสยามสแควร์</h3>
          <h5 class="text-green"> หากมารถไฟฟ้า เดินมาตาม Siamsquare One สะดวกมากค่ะ ตรงมาเรื่อยๆ จะเจอร้านอาการ บ้านคุณแม่ สถาบันอยู่ถัดไปเล็กน้อยค่ะ</h5>
          <hr>
          <div class="col-md-9 col-md-offset-2">
            <img src="{{url('assets/image/map_siam.jpg')}}" class="img-responsive">
          </div>
        </div>


    </div>
</div>
@endsection

@section('scripts')
<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>


@stop('scripts')
