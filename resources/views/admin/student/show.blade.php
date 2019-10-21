@extends('admin.layouts.template')
@section('admin.content')






				<section role="main" class="content-body">

					<header class="page-header">
						<h2>{{$header}}</h2>

						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="dashboard.html">
										<i class="fa fa-home"></i>
									</a>
								</li>

								<li><span>{{$header}}</span></li>
							</ol>

							<a class="sidebar-right-toggle" data-open="sidebar-right" ><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>


					<!-- start: page -->




							<div class="row">
							<div class="col-md-2">


                <section class="panel">
								<div class="panel-body">
									<div class="thumb-info mb-md">
                    @if($objs->avatar != NULL && $objs->provider == "email")
										<img src="{{url('assets/images/avatar/'.$objs->avatar)}}" class="rounded img-responsive" alt="{{$objs->name}}">
										@elseif ($objs->provider == 'facebook')
										<img src="//{{$objs->avatar}}" class="rounded img-responsive" alt="{{$objs->name}}">
                    @else
                    <img src="{{url('assets/images/avatar/blank_avatar_240x240.gif')}}" class="rounded img-responsive" alt="{{$objs->name}}">
                    @endif
										<div class="thumb-info-title" style="background: rgba(36, 27, 28, 0.0);">

											<span class="thumb-info-type">{{ $objs->position }}</span>
										</div>
									</div>







								</div>
							</section>

							</div>







              <div class="col-md-8">

							<div class="tabs">

								<div class="tab-content">

									<div id="edit" class="tab-pane active">



											<h4 class="mb-xlg">ข้อมูลส่วนตัวของนักเรียน</h4>

                      <table class="table ">
                        <tbody>
                          <tr>
                            <td>จำนวน coin</td><td>{{$objs->user_coin}}</td>
                          </tr>
                          <tr>
                            <td>ชื่อของคุณ</td><td>{{$objs->name}}</td>
                          </tr>
                          <tr>
                            <td>อีเมล์</td><td>{{$objs->email}}</td>
                            </tr>
                            <tr>
                            <td>เบอร์โทร</td><td>{{$objs->phone}}</td>
                            </tr>
														<tr>
                            <td>Coin</td><td>{{$objs->user_coin}}</td>
                            </tr>
                            <tr>
                            <td>ID Line</td><td>{{$objs->line_id}}</td>
                            </tr>
                            <tr>
                            <td>วันเกิดของฉัน</td><td>{{$objs->hbd}}</td>
                            </tr>
                            <tr>
                            <td>ที่อยู่</td><td>{{$objs->address}}</td>
                            </tr>
                            <tr>
                            <td>เกี่ยวกับนักเรียน</td><td>{{$objs->bio}}</td>
                          </tr>
                        </tbody>
                      </table>
                      <hr><a type="button" href="{{url('admin/student/'.$objs->id.'/edit')}}" class="btn btn-default">แก้ไขข้อมูล</a>


									</div>
								</div>
							</div>






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




               <div class="tabs">

 								<div class="tab-content">

 									<div id="edit" class="tab-pane active">



 											<h4 class="mb-xlg">คอร์สที่ลงทะเบียนเรียน</h4>

                       <table class="table ">
                         <thead>
                           <tr>
                             <th>รายการที่ทำ</th>
                             <th>วันที่ลงทะเบียน</th>
														 <th>
												 		 	จัดการ
														 </th>
                           </tr>
                         </thead>
                         <tbody>
                           @if($coursess)
                           @foreach($coursess as $course_success)
                           <tr>
                             <td><a href="{{url('admin/play_student/'.$course_success->Oid.'/edit')}}">{{$course_success->title_course}}</a></td>
                             <td><?php echo DateThai($course_success->created_at_user); ?></td>
														 <td>
															<a target="_blank" class="btn btn-warning btn-xs" href="{{url('admin/play_student/'.$course_success->Oid.'/print')}}" role="button"><i class="fa fa-print"></i> </a>
														 </td>
                           </tr>
                           @endforeach
                           @endif
                         </tbody>
                       </table>
                       {{ $coursess->links() }}


 									</div>
 								</div>
 							</div>




              <div class="tabs">

								<div class="tab-content">

									<div id="edit" class="tab-pane active">



											<h4 class="mb-xlg">ประวัติการสั่งซื้อ</h4>

                      <table class="table ">
                        <thead>
                          <tr>
                            <th>รายการที่ทำ</th>
                            <th>จำนวนเงิน</th>
                            <th>วันที่</th>

                          </tr>
                        </thead>
                        <tbody>
                          @if($coursess_suc)
                          @foreach($coursess_suc as $suc)
                          <tr>
                            <td>
                              {{$suc->name}}

                              </td>
                            <td>{{$suc->money}}</td>
                            <td><?php echo DateThai($suc->created_at); ?></td>
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                      </table>
                      {{ $coursess_suc->links() }}


									</div>
								</div>
							</div>



						</div>











						</div>

</section>
@stop

@section('scripts')

<script>

socket.on( 'new_count_message', function( data ) {

$( "#new_count_message" ).html( data.new_count_message );
  console.log(data.new_count_message);
});

socket.on( 'new_message', function( data ) {
  console.log(data.message_in);
  if(data.check_noti === 0 ){
    if(data.provider === 'email'){
      $( "#messages_noti" ).append('<li><a href="{{url('admin/inbox_chat/')}}/'+ data.chat_user_id +'" class="clearfix"><figure class="image"><img src="{{url('assets/images/avatar/')}}/'+data.avatar+'" width="35" height="35" class="img-circle"></figure><span class="title">'+ data.name +'</span><span class="message">มีข้อความมาใหม่ถึงคุณ</span></a></li>');
    }else{
      $( "#messages_noti" ).append('<li><a href="{{url('admin/inbox_chat/')}}/'+ data.chat_user_id +'" class="clearfix"><figure class="image"><img src="//'+data.avatar+'" width="35" height="35" class="img-circle"></figure><span class="title">'+ data.name +'</span><span class="message">มีข้อความมาใหม่ถึงคุณ</span></a></li>');
    }
  }
  console.log(data.check_noti);
  $("#messages_show").scrollTop($("#messages_show")[0].scrollHeight);
  $('#notif_audio')[0].play();
});

</script>

<script>
$.fn.datepicker.defaults.format = "yyyy-mm-dd";
$('.datepicker').datepicker({
});
</script>

@if ($message = Session::get('success'))
<script type="text/javascript">
var stack_bar_top = {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0};
var notice = new PNotify({
      title: 'ยินดีด้วยค่ะ',
      text: '{{$message}}',
      type: 'success',
      addclass: 'stack-bar-top',
      stack: stack_bar_top,
      width: "100%"
    });
</script>
@endif

@stop('scripts')
