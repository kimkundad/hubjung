
@extends('layouts.app')
@section('stylesheet')
<link href="{{url('assets/css/select-project.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/css/confirm.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/bootstrap-sweetalert-master/dist/sweetalert.css')}}" rel="stylesheet" type="text/css" />
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

.text-muted {
    color: #3c763d;
}
.block-box-content {
    overflow: hidden;
    height: 100%;
}
.block-box-content>a:first-child {
    font-size: 15px;
    font-weight: bold;
    display: block;
    margin-bottom: 10px;
    color: #2f3c4e;
}
.block-box-content>a:hover {
    font-size: 15px;
    font-weight: bold;
    display: block;
    margin-bottom: 10px;
    color: #038206;
}
.block-box-content span {
    float: left;
    margin-right: 30px;
    display: inline-block;
    margin-bottom: 8px;
    font-size: 12px;
    text-transform: uppercase;
}
.block-box-content p{
  margin-bottom: 0;
  margin: 0 0 20px 0;
line-height: 22px;
font-size: 13px;
color: #6d7683;
}
ol, ul, li {
    list-style: none;
        -webkit-padding-start: 0px;
}
.block-recent-1 li {
    float: left;
    width: 100%;
}
.block-box-1 li {
    list-style: none;
    float: right;

    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #ecedee;
    clear: right;
}
</style>

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
 <style>
 .juicer-feed h1.referral{
   display: none !important;
 }
 </style>
<div class="container" >
    <div class="row">




        <div class="col-md-12" >

          <h3>ข่าวสารอัพเดต</h3>
          <hr>




         <style>
         .blog-1x .blog-single img {
    width: 100%;
    max-height: 275px;
    object-fit: cover;
}
.blog-1x .blog-single {
    margin-bottom: 30px;
}
.blog-1x .blog-single .blog-single-content {
    background: #fff;
    padding: 30px;
    border: 1px solid #eee;
}
.blog-1x .blog-single .blog-single-content a {
    display: block;
    font-size: 18px;
    font-weight: 600;
    color: #454545;
    margin-bottom: 15px;
    -webkit-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
.blog-1x .blog-single .blog-single-content h3 {
    font-size: 15px;
    font-weight: 300;
    padding: 20px 0 0 0;
    margin-top: 15px;
    border-top: 1px solid #eee;
}
.blog-1x .blog-single .blog-single-content h3 i {
    color: #9f9f9f;
    margin-right: 7px;
}
          </style>

         <div class="blog-1x blog-1x-no-bg">




          @foreach($objs as $u)
        <div class="col-md-4">
					<div class="blog-single">
            <a href="{{url('news/'.$u->id)}}" >
						<img src="assets/blog/{{$u->image}}" alt="{{$u->title_blog}}" style="min-height:230px; max-height:230px;">
            </a>
						<div class="blog-single-content" style="padding: 10px 20px;">
							<a href="{{url('news/'.$u->id)}}" style="font-size: 16px; height:44px;"> {{$u->title_blog}} </a>

							<h3>
								<i class="fa fa-calendar-check-o"></i> <?php echo DateThai($u->created_at); ?>
								<span><i class="fa fa-heart-o"></i> {{$u->view}} </span>
							</h3>
						</div>
					</div>
				</div>
        @endforeach


    {{ $objs->links() }}



    </div>



</div>














    </div>
</div>
@endsection

@section('scripts')
<script src="{{url('assets/bootstrap-sweetalert-master/dist/sweetalert.js')}}"></script>

<script>

  //  swal("ส่งข้อความสำเร็จ!", "ข้อความถูกส่งไปยังครูพี่โฮมเรียบร้อยแล้ว!", "success")

  </script>

<script src="https://assets.juicer.io/embed.js" type="text/javascript"></script>
<link href="https://assets.juicer.io/embed.css" media="all" rel="stylesheet" type="text/css" />
@stop('scripts')
