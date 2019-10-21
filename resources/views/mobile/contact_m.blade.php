
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
        <div class="col-md-9 " >
          <h3>ติดต่อเรา ครูพี่โฮม</h3>

          <hr>
          <div class="body-project">

                    <div class="row">

                      <div class="col-md-12">
                        <form action="{{url('/contact_m_p')}}" method="post" enctype="multipart/form-data" name="product">
                          <input type="hidden" name="_method" value="post">
                          {{ csrf_field() }}
                          <div class="row" style=" padding-right: 15px; ">

                            <div class="col-md-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                              <label >ชื่อ-นามสกุล <span class="text-green">*</span></label>
                              <input type="text" class="form-control" name="name">
                              @if ($errors->has('name'))
                                  <span class="help-block">
                                      <strong>ใส่ ชื่อ-นามสกุล ด้วยนะ</strong>
                                  </span>
                              @endif
                            </div>
                            </div>

                            <div class="col-md-4">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                              <label >อีเมล์ <span class="text-green">*</span></label>
                              <input type="email" class="form-control" name="email">
                              @if ($errors->has('email'))
                                  <span class="help-block">
                                      <strong>ใส่ อีเมล์ ด้วยนะ</strong>
                                  </span>
                              @endif
                            </div>
                            </div>

                            <div class="col-md-4">
                            <div class="form-group">
                              <label >เบอร์โทรศัพท์</label>
                              <input type="text" class="form-control" name="phone">
                            </div>
                            </div>

                            <div class="col-md-12">
                            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">

                              <div class="g-recaptcha" data-sitekey="6LccQR0UAAAAAI32GUP3mIFYBTThZVtHN1uYGitB"></div>
                              @if ($errors->has('g-recaptcha-response'))
                                  <span class="help-block">
                                      <strong>คุณเป็นหุ่นยนต์หรือป่าวหล่ะ!</strong>
                                  </span>
                              @endif
                            </div>
                            </div>

                            <div class="col-md-12">
                            <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                              <label >ข้อความ <span class="text-green">*</span></label>
                              <textarea class="form-control" rows="6" placeholder="พิมพ์ข้อความที่นี่..." name="detail"></textarea>
                              @if ($errors->has('detail'))
                                  <span class="help-block">
                                      <strong>ใส่ข้อความติดต่อด้วยนะ!</strong>
                                  </span>
                              @endif
                            </div>
                            </div>




                            <div class="col-md-12">
                            <button type="submit"  class="btn btn-green">ส่งข้อความ</button>
                            </div>
                            </div>
                          </form>
                      </div>



                    </div>




          </div>




        </div>
        <div class="col-md-3" style="margin-top: 0px;">

          <h3>สอบถามรายละเอียด</h3>

          <hr>
          <p style="color: #888;"><b>ZA-SHI สาขาสยามสแควร์</b></p>
          <p class="conn"><strong><i class="fa fa-globe"></i> Website: </strong><a href="http://www.learnsabuy.com">www.learnsabuy.com</a><br>
            <strong><i class="fa fa-envelope-o"></i> Email:</strong> learnsbuy@gmail.com<br>
            <strong><i class="fa fa-mobile"></i> Phone:</strong> 02-658-3819<br>
          </p>
          <h3 style="font-size: 18px;">ติดตามข่าวสาร</h3>
          <hr>
          <p class="conn">
            <strong><i class="fa fa-facebook"></i> Facebook:</strong> <a target="_blank" href="https://www.facebook.com/zashischool">zashischool</a><br>
            <strong><i class="fa fa-youtube"></i> Youtube:</strong> <a target="_blank" href="https://www.youtube.com/user/zashischool">zashischool</a><br>
          </p>
        </div>

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
