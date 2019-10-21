@extends('layouts.app')
@section('stylesheet')
<link href="{{url('assets/css/select-project.css')}}?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet" type="text/css" />
<link href="{{url('assets/css/golf-style.css')}}" rel="stylesheet" type="text/css">
<link href="{{url('assets/slide/css/owl.carousel.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{url('assets/slide/css/responsive.css')}}?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet" type="text/css">
<style type="text/css">
.descript-t {
    float: right;
    height: 40px;
}
.content-section-b {
    padding: 50px 0;
     background-color: #f5f5f5;
}
footer {
    margin-top: 0px;

  }
  .banner {
      border-bottom: 1px solid #e0e0e0;
      background-color: #fff;
  }
  @media (min-width: 1200px)
          {
            #search_container {
                margin-bottom: 22px;
            }
            .t_v_midden{
              border-right: 1px solid #e0e0e0;
            }

            .start-detail{
              margin-left: 30px;
            }
            .single-slide p{
              width: 50%;
            }
          }

#first-slider .slide1 {
    background-image: url({{url('assets/image/bg_180226_0002.jpg')}});
}
#first-slider .slide2 {
    background-image: url({{url('assets/image/learnsbuy_cover01.png')}});
}
#first-slider .slide3 {
    background-image: url({{url('assets/image/bg_180226_0002.jpg')}});
}
#first-slider .slide4 {
    background-image: url({{url('assets/image/learnsbuy_cover01.png')}});
}
#first-slider h3{
    color: #000 !important;
}
#first-slider h4 {
    color: #666 !important;
        font-size: 22px !important;
}
.carousel-control .fa-angle-right {
    color: #666;
    border: 3px solid #666;
}
.carousel-control .fa-angle-left {
    color: #666;
    border: 3px solid #666;
}
.carousel-style-one {position: relative}
.carousel-style-one .owl-nav > div {
    background: #ffffff none repeat scroll 0 0;
    border: 4px solid #d7d7d7;
    border-radius: 50%;
    color: #54545b;
    font-size: 14px;
    height: 49px;
    left: -30px;
    line-height: 41px;
    position: absolute;
    top: 40.8%;
    transition: all 0.4s ease-out 0s;
    width: 49px;
}
.carousel-style-one .owl-nav > .owl-next {left: auto; right: -30px;}
.carousel-style-one .owl-nav {opacity: 0; transition: .2s}
.carousel-style-one:hover .owl-nav {opacity: 1}
.carousel-style-dot .owl-dots {
    bottom: 25px;
    left: 0;
    line-height: 0;
    position: absolute;
    right: 0;
    text-align: center;
}
.carousel-style-dot .owl-dots .owl-dot {
    background: #f6f6f6 none repeat scroll 0 0;
    border: 2px solid #c7b694;
    border-radius: 20px;
    display: block;
    height: 12px;
    margin: 5px 7px;
    opacity: .5;
    width: 12px;
    display: inline-block;
    transition: .3s
}
.carousel-style-dot .owl-dots .owl-dot:hover, .carousel-style-dot .owl-dots .owl-dot.active {opacity: 1}
.custom-row {margin-left: -15px; margin-right: -15px}
.custom-col {padding-left: 15px; padding-right: 15px}
.custom-col.w-20 {width: 20%; float: left}
.slider-area, .slider-two-area, .slider-three-area, .slider-four-area {overflow: hidden; position: relative}
.single-slide {
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
    background-position: center center;
    background-size: cover;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;

}
.slider-banner {padding-left: 25px;}
.single-slide h1 {
  line-height: 25px;
    color: #252531;

    font-weight: 200;
    margin-bottom: 7px;
    padding-top: 47px;
    text-transform: uppercase;
    width: 100%;
}
.owl-item.active .single-slide h1 {-webkit-animation: 1100ms ease-in-out 0s normal none 1 running fadeInRight;animation: 1100ms ease-in-out 0s normal none 1 running fadeInRight;}
.single-slide h2 {
    color: #252531;
    font-size: 48px;
    font-weight: bold;
    line-height: 35px;
    margin: 0 0 22px;
    text-transform: uppercase;
}
.owl-item.active .single-slide h2 {-webkit-animation: 1500ms ease-in-out 0s normal none 1 running fadeInLeft;animation: 1500ms ease-in-out 0s normal none 1 running fadeInLeft;}
.single-slide p {
    color: #252531;
    font-family: 'Prompt', sans-serif;
    font-size: 16px;
    font-weight: normal;
    line-height: 25px;
    margin: 0;
}
.owl-item.active .single-slide p {-webkit-animation: 2200ms ease-in-out 0s normal none 1 running bounceInDown;animation: 2200ms ease-in-out 0s normal none 1 running bounceInDown;}
.banner-btn {
    background: #252531 none repeat scroll 0 0;
    color: #ffffff;
    display: inline-block;
    font-size: 13.3px;
    font-weight: 600;
    margin-top: 25px;
    padding: 10px 30px;
    text-transform: uppercase;
    letter-spacing: .2px
}
.banner-btn:hover, .banner-btn:focus, .banner-btn:active {
    background: #BDA87F none repeat scroll 0 0;
    color: #fff
}

.owl-item.active .banner-btn {-webkit-animation:  2000ms ease-in-out 0s normal none 1 running bounceInDown;animation:  2000ms ease-in-out 0s normal none 1 running bounceInDown}
.owl-item.active .slide-two h1 {-webkit-animation: 1500ms ease-in-out 0s normal none 1 running fadeInLeft;animation: 1500ms ease-in-out 0s normal none 1 running fadeInLeft;}
.owl-item.active .slide-two h2 {-webkit-animation: 1800ms ease-in-out 0s normal none 1 running fadeInLeft;animation: 1800ms ease-in-out 0s normal none 1 running fadeInLeft}
.owl-item.active .slide-two p {-webkit-animation: 1200ms ease-in-out 0s normal none 1 running slideInDown;animation: 1200ms ease-in-out 0s normal none 1 running slideInDown}
.owl-item.active .slide-two .banner-btn {-webkit-animation: 1400ms ease-in-out 0s normal none 1 running zoomInUp;animation: 1400ms ease-in-out 0s normal none 1 running zoomInUp}
</style>
@stop('stylesheet')
@section('content')

<!-- Slider Two Area Start -->
	    <div class="slider-two-area" >
	        <div class="slider-wrapper owl-carousel carousel-style-dot">
            @if($slide)
              @foreach($slide as $slider)
	            <div class="single-slide" style="background-image: url('{{url('assets/image/slide/'.$slider->image_slide)}}');">
                    <div class="slider-banner">
                        <h1>{{$slider->text_slide1}}</h1>
                        <p>{{$slider->text_slide3}}</p>
                        @if($slider->btn_slide != null)
                        <a href="{{$slider->btn_url}}" class="banner-btn">{{$slider->btn_slide}}</a>
                        @endif
                    </div>
                </div>
                @endforeach
	            @endif
	        </div>
	    </div>
	    <!-- Slider Two Area End -->



                <div class="content-section-b" style="    padding: 0px 0; ">
                <div class="banner hidden-sm hidden-xs" style="border-top: 1px solid #e0e0e0;">
                    <div class="container" style="background-color: #fff;">
                            <div class="g_main g_col1 " style="padding-top:30px; ">

                                <div class="col-sm-4 m-b t_v_midden" >
                                    <div class="t_v_mid ">
                                        <div class="g_ib">
                                            <div class="t_v_mid_box">
                                                <div class="t_v_mid"><img src="{{url('assets/image/icon_home/icon1_1.png')}}"></div>
                                                <div class="t_v_mid t_left">
                                                    <p class="t16 g_ma_8">เลิร์นสบาย</p>
                                                    <p class="t14 t_gray g_ma_8">เรียนออนไลน์ได้ทุกที่ 24 ชม.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 m-b t_v_midden" >
                                    <div class="t_v_mid ">
                                        <div class="g_ib">
                                          <div class="t_v_mid_box">
                                            <div class="t_v_mid"><img src="{{url('assets/image/icon_home/icon2_2.png')}}"></div>
                                            <div class="t_v_mid t_left">
                                                    <p class="t16 g_ma_8">ล้ำสมัย</p>
                                                    <p class="t14 t_gray g_ma_8">ด้วยแอพพลิเคชั่น iOS- และ Android.</p>
                                          </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 m-b" >
                                    <div class="t_v_mid ">
                                        <div class="g_ib">
                                            <div class="t_v_mid_box">
                                                <div class="t_v_mid"><img src="{{url('assets/image/icon_home/icon3.png')}}"></div>
                                                <div class="t_v_mid t_left">
                                                    <p class="t16 g_ma_8">ไลฟ์แชท</p>
                                                    <p class="t14 t_gray g_ma_8">ระบบถามตอบสดๆ และแบบทดสอบประมวลเป็นกราฟ</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                </div>
                        </div>
                </div>



<div class="content-section-a">
        <div class="container" >
 <!--   <div class="row">
        <div class="col-md-12" >

            <h3>ครูพี่โฮม ตัวเตอร์ภาษาญี่ปุ่น</h3>
            <p>พบกับเฉลยข้อสอบ PAT 7.3 ภาษาญี่ปุ่นล่าสุด ติวสอบวัดระดับภาษาญี่ปุ่น <b>N1 N2 N3 N4 N5</b>
                <br>กวดวิชาภาษาญี่ปุ่น ติวไวยากรณ์ ศัพท์ คันจิ N1 N2 N3 N4 N5 กับครูพี่โฮม <br>
                อัพเดตเนื้อหาใหม่ล่าสุด 2559 รับสมัครแล้ว !!</p>
        </div>
    </div>  -->


    <div class="row">

      <div class="col-md-3">
        <div class="media-text__media">
<img src="{{url('assets/image/app_learnsbuy.jpg')}}" class="img-responsive" alt="">
        </div>

      </div>

      <div class="col-md-6" style="padding-right: 0px; ">
        <h1 class="entry-title"><span id="typed">ZA-SHI </span>ครูพี่โฮม</h1>
        <p class="lead-th" style="text-decoration:none">เรียนภาษาญี่ปุ่นเทคนิคเพียบกับครูพี่โฮมและอาจารย์ชาวญี่ปุ่น ภาษาญี่ปุ่นพื้นฐาน ภาษาญี่ปุ่นสำหรับศิลป์-ญี่ปุ่นและคนที่ไม่ได้เรียนศิลป์-ญี่ปุ่น ภาษาญี่ปุ่นสำหรับคนทำงาน ติว PAT 7.3 ภาษาญี่ปุ่น และติวสอบวัดระดับภาษาญี่ปุ่น ติว N1 N2 N3 N4 N5 ติวไวยากรณ์ ศัพท์ คันจิ การอ่าน การฟัง ระหว่างเรียนมีฟังก์ชั่นไลฟ์แชทและฟังก์ชั่นแบบทดสอบ วิเคราะห์ผลคะแนนออกมาเป็นกราฟ รู้จุดอ่อนจุดแข็งและประเมินโอกาสสอบผ่าน
เรียนภาษาญี่ปุ่นออนไลน์กับครูพี่โฮม คนแรกและคนเดียวที่ได้ PAT ญี่ปุ่น 300 คะแนนเต็ม เกียรตินิยมอันดับ 1 (เหรียญทอง) อักษรศาสตร์ จุฬาฯ</p>




          <div class="row " style="padding-left:17px;">

            <p class="news-app-detail text-primary" style="float:right; margin-right: 45px;">
     "มาเรียนภาษาญี่ปุ่นกันเถอะ" เรียนออนไลน์ วันนี้ ทั้ง
        <a class="news-app-box" href="https://itunes.apple.com/us/app/learnsbuy/id1308032037?mt=8" target="_blank"><img src="{{url('assets/images/app.png')}}" data-pin-nopin="true"></a>
          และ <a class="news-app-box" href="https://play.google.com/store/apps/details?id=com.learnsbuy.zashi&hl=th" target="_blank"><img src="{{url('assets/images/play.png')}}" data-pin-nopin="true"></a></p>

          </div>


      </div>




<div class="col-md-3" style="padding-left: 15px;">

        <div class="home-downstat">
              <h2 class="text-center">สมัครเรียนกับครูพี่โฮม</h2>
           <a href="{{url('register')}}" style="    width: 100%;" class="ui facebook fluid button"><i class="fa fa-facebook icon-fa"></i> สมัครหรือล็อกอินด้วย Facebook</a>

           <a href="{{url('register')}}" style="margin-top:12px;     width: 100%;" class="ui google plus fluid button"><i class="fa fa-google-plus icon-fa"></i> สมัครหรือล็อกอินด้วย Google</a>

            <a class="ui fluid button" href="{{url('register')}}" style="margin-top:12px;   width: 100%;"><i class="fa fa-envelope icon-fa"></i> สมัครหรือล็อกอินด้วย Email</a>
            <p class="text-center" style="margin-top:15px;">สบายใจ หายห่วง เพราะเรา ไม่มีนโยบายเก็บหรือแชร์ข้อมูลส่วนตัวของคุณ</p>
        </div>

      </div>




    </div>
<hr>

<div class="row" style="margin-top:30px;">


  <div class="col-md-6">
    <div class="category-left left-image">
      <div class="hvrbox">
        <img src="https://banyanthemes.com/template/courcity/images/1.jpg" alt="slide 1" class="hvrbox-layer_bottom">
        <div class="hvrbox-layer_top">
          <div class="hvrbox-text">
            <a href="#">Design Introduction</a>
            <h5>800 Course</h5>
            <a href="#" class="btn-small">View Details</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-6">
        <div class="category-left right-image">
          <div class="hvrbox">
            <img src="https://banyanthemes.com/template/courcity/images/5.jpg" alt="slide 1" class="hvrbox-layer_bottom">
            <div class="hvrbox-layer_top hvrbox-text">
              <div class="hvrbox-text">
                <a href="#">Web Developement</a>
                <h5>700 Course</h5>
                <a href="#" class="btn-small">View Details</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="category-left right-image">
          <div class="hvrbox">
            <img src="https://banyanthemes.com/template/courcity/images/2.jpg" alt="slide 1" class="hvrbox-layer_bottom">
            <div class="hvrbox-layer_top hvrbox-text">
              <div class="hvrbox-text">
                <a href="#">Digital Marketing</a>
                <h5>350 Course</h5>
                <a href="#" class="btn-small">View Details</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="category-left right-image">
          <div class="hvrbox">
            <img src="https://banyanthemes.com/template/courcity/images/3.jpg" alt="slide 1" class="hvrbox-layer_bottom">
            <div class="hvrbox-layer_top hvrbox-text">
              <div class="hvrbox-text">
                <a href="#">Busines</a>
                <h5>250 Course</h5>
                <a href="#" class="btn-small">View Details</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="category-left right-image">
          <div class="hvrbox">
            <img src="https://banyanthemes.com/template/courcity/images/4.jpg" alt="slide 1" class="hvrbox-layer_bottom">
            <div class="hvrbox-layer_top hvrbox-text">
              <div class="hvrbox-text">
                <a href="#">Photography</a>
                <h5>180 Course</h5>
                <a href="#" class="btn-small">View Details</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>

<!--

    <div class="row" style="margin-top:30px;">
        <div class="col-md-6" >
       <img src="{{url('assets/images/Untitled-2.png')}}" class="img-responsive show-img">
        </div>

        <div class="col-md-6" >

            <div class="m-t">

            <div class="media">
              <div class="media-left">
                <a href="#">
                  <img class="media-object img-circle " src="{{url('assets/image/timeline_25610920_165703.jpg')}}" height="80" alt="...">
                </a>
              </div>
              <div class="media-body" style="text-align:left">
                <h4 class="media-heading">ครูพี่โฮม ตัวจริง PAT ญี่ปุ่น</h4>
               <p class="t-gray"> ครูพี่โฮม กวดวิชาภาษาญี่ปุ่นได้รับเชิญจากสื่อชั้นนำระดับประเทศไปติว PAT 7 ภาษาญี่ปุ่น
                 ติวเตอร์ภาษาญี่ปุ่นหนึ่งเดียวทาง GMM CHANNEL, TRUE VISIONS, PLOOK, ETV (กระทรวงศึกษาธิการ)</p>
              </div>
            </div>


            <div class="media">
              <div class="media-left">
                <a href="#">
                  <img class="media-object img-circle " src="{{url('assets/image/timeline_25610920_165704.jpg')}}" height="80" alt="...">
                </a>
              </div>
              <div class="media-body" style="text-align:left">
                <h4 class="media-heading">ติวสอบวัดระดับกับครูพี่โฮม & เอ็ตจัง</h4>
               <p class="t-gray"> เรียนภาษาญี่ปุ่นและติวสอบ JLPT กับครูพี่โฮมและเอ็ตจัง ติวสอบวัดระดับ N1 N2 N3 N4 N5 สอนละเอียดทั้งไวยากรณ์
                 ศัพท์ คันจิ การอ่าน การฟังและตะลุยข้อสอบวัดระดับ N1 N2 N3 N4 N5 ย้อนหลัง </p>
              </div>
            </div>

            <div class="media">
              <div class="media-left">
                <a href="#">
                  <img class="media-object img-circle " src="{{url('assets/image/timeline_25610920_165705.jpg')}}" height="80" alt="...">
                </a>
              </div>
              <div class="media-body" style="text-align:left">
                <h4 class="media-heading">PrePat7 และ PreJLPT</h4>
               <p class="t-gray"> จำลองสนามสอบ PAT7 และ JLPT N1 N2 N3 N4 N5 พร้อม Startdard Report รายงานคะแนนสอบ โปรแกรมประเมินโอกาสสอบผ่านและสอบติด
                 Admission และ TCAS  พร้อมคลิปเฉลยอย่างละเอียดเสริมเทคนิคการทำคำแนนโดยครูพี่โฮม </p>
              </div>
            </div>

            </div>

        </div>
    </div>
-->


</div></div>









<div class="content-section-b">
        <div class="container" >


          <div class="row">
        <div class="col-md-12 " >
          <h3>คอร์สใหม่ล่าสุด </h3>

          <hr>
          <div class="body-project">

                    <div class="row">

                  @if(isset($objs))
                  @foreach($objs as $obj)

                  <div class="col-xs-6 col-md-3">
                        <div class="thumbnail">
                          <a href="{{url('/courseinfo/'.$obj->A)}}">
                          <img src="{{url('assets/uploads/'.$obj->image_course)}}" >
                          </a>
                          <div class="caption" style="padding: 3px;">
                            <div class="descript bold">
                                <a href="{{url('/courseinfo/'.$obj->A)}}" data-dismiss="modal" data-toggle="modal" data-target="#show_detail54"> {{$obj->title_course}}</a>
                            </div>
                            <div class="descript" style="border-bottom: 1px dashed #999;">
                                {{$obj->type_name}} เรียน {{$obj->day_course}}, {{$obj->time_course}}
                            </div>

                            <div class="descript" style="height: 20px;">
                              <div class="descript-t">
                              <div class="postMetaInline-authorLockup">
                                <div >
                                  <span class="readingPrice">
                                <span class="text-primary hidden-sm hidden-xs">{{$obj->code_course}},</span> ฿ @if($obj->price_course == 0)
                                    Free Course
                                                            @else
                                                      {{$obj->price_course}}  บาท
                                                            @endif
                                  </span>
                                </div>
                              </div>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                  @endforeach
                  @endif
                  <!--    <div class="col-sm-4 col-md-3">
                        <div class="thumbnail">
                          <a href="{{url('/courseinfo')}}">
                          <img src="{{url('assets/image/1480125677senseino-ln-02.png')}}" >
                          </a>
                          <div class="caption" style="padding: 3px;">
                            <div class="descript bold">
                                <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#show_detail54"> เรียนออนไลน์ภาษาจีนระดับต้น 2 บทที่ 1-10</a>
                            </div>
                            <div class="descript" style="border-bottom: 1px dashed #999;">
                                ภาษาจีนระดับต้น 2 เรียนวันจันทร์, พุธ 20.00 น.
                            </div>

                            <div class="descript" style="height: 20px;">
                              <div class="descript-t">
                              <div class="postMetaInline-authorLockup">
                                <div >
                                  <span class="readingPrice">
                                ฿ 2,500 บาท
                                  </span>
                                </div>
                              </div>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>  -->





                    </div>



          </div>
        <!--    <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Your Application's Landing Page.
                </div>
            </div> -->



        </div>
    </div>



        </div>
</div>

<!--
<div class="footer-mailchimp">
        <div class="container text-center">


                <h2>ติดตามเพิ่มเติมได้ที่เมนู "ติวญี่ปุ่นฟรี" </h2>
                <h4>ฝากอีเมลของคุณไว้ ทางทีมงานของเรายินดีที่จะติดต่อกลับไปโดยเร็วที่สุด</h4>
                <div id="mc_embed_signup">
                    <form role="form" action="#" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank" novalidate="">
                    <div class="input-group input-group-lg">
                    <input type="email" name="EMAIL" class="form-control" id="mce-EMAIL" placeholder="Email address...">
                    <span class="input-group-btn">
                    <button type="submit" name="subscribe" id="mc-embedded-subscribe" class="btn btn-default">Subscribe!</button>
                    </span>
                    </div>
                    <div id="mce-responses">
                    <div class="response" id="mce-error-response" style="display:none"></div>
                    <div class="response" id="mce-success-response" style="display:none"></div>
                    </div>
                    </form>
                </div>

        </div>
        </div>      -->

@endsection

@section('scripts')
<script type="text/javascript" src="{{url('assets/slide/js/owl.carousel.min.js')}}"></script>

<script>
$(document).ready(function(){
$('.slider-wrapper').owlCarousel({
        loop:true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 2500,
        autoplay:true,
        autoplayTimeout:4000,
        autoplayHoverPause:true,
        items:1,
        nav:false,
        dots: true
    });
    });

</script>

@stop('scripts')
