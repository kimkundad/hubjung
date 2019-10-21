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
							<div class="col-md-4 col-lg-3">


                <section class="panel">
								<div class="panel-body">
									<div class="thumb-info mb-md">
                    @if($objs->avatar != NULL && $objs->provider == "email")
										<img src="{{url('assets/images/avatar/'.$objs->avatar)}}" class="rounded img-responsive" alt="{{$objs->name}}">
										@elseif ($objs->provider == 'facebook')
										<img src="http://{{$objs->avatar}}" class="rounded img-responsive" alt="{{$objs->name}}">
                    @else
                    <img src="{{url('assets/images/avatar/blank_avatar_240x240.gif')}}" class="rounded img-responsive" alt="{{$objs->name}}">
                    @endif
										<div class="thumb-info-title" style="background: rgba(36, 27, 28, 0.0);">

											<span class="thumb-info-type">{{ $objs->position }}</span>
										</div>
									</div>

									<div class="widget-toggle-expand mb-md">
										<div class="widget-header">
											<h6>กรอกข้อมูลสำเร็จ</h6>
											<div class="widget-toggle">+</div>
										</div>
										<div class="widget-content-collapsed">
											<div class="progress progress-xs light">
												<div class="progress-bar" role="progressbar" aria-valuenow="{{$score}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$score}}%;">
													{{$score}}%
												</div>
											</div>
										</div>
                    <style>
                    ul.simple-todo-list li {
                        position: relative;
                        padding: 0px;
                    }
                    </style>
										<div class="widget-content-expanded">
											<ul class="simple-todo-list">
												<li><i class="fa fa-user"></i> {{ $objs->name }} </li>
                        <li><i class="fa fa-envelope-o "></i> {{ $objs->email }} </li>
												<li><i class="fa fa-phone"></i> {{ $objs->phone }} </li>
                        <li><i class="fa fa-gavel "></i> {{ $objs->position }} </li>
												<li><i class="fa fa-comment-o "></i> Line : {{$objs->line_id}} </li>
											</ul>
										</div>
									</div>





								</div>
							</section>

							</div>







              <div class="col-md-8 col-lg-8">

							<div class="tabs">

								<div class="tab-content">

									<div id="edit" class="tab-pane active">

										<form class="form-horizontal" action="{{$url}}" method="post" enctype="multipart/form-data">
                      {{ method_field($method) }}
											{{ csrf_field() }}

											<h4 class="mb-xlg">ข้อมูลส่วนตัวของนักเรียน</h4>
                      @if (count($errors) > 0)
                      <br>
                          <div class="alert alert-danger">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
											<fieldset>
                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">ชื่อนักเรียน</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="name" value="{{ $objs->name }}" id="profileFirstName">
													</div>
												</div>

                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">อีเมล์</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="email" value="{{ $objs->email }}" id="profileCompany" readonly>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">เบอร์โทร</label>
													<div class="col-md-8">
														<input type="number" class="form-control" name="phone" value="{{ $objs->phone }}" id="profileCompany" >
													</div>
												</div>


												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">ไลน์ ไอดี</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="line_id" value="{{ $objs->line_id }}" id="profileCompany" >
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">จำนวน Coin</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="user_coin" value="{{ $objs->user_coin }}" >
													</div>
												</div>


												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">วันเกิด</label>
													<div class="col-md-8">
														<input type="text" data-plugin-datepicker name="hbd" class="form-control datepicker" value="{{$objs->hbd}}" required="">
													</div>
												</div>

												@if($objs->provider == 'email')
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="exampleInputEmail1">รูป Avatar</label>
                          <div class="col-md-8">
                          <div class="fileupload fileupload-new" data-provides="fileupload">
        														<div class="input-append">
        															<div class="uneditable-input">
        																<i class="fa fa-file fileupload-exists"></i>
        																<span class="fileupload-preview"></span>
        															</div>
        															<span class="btn btn-default btn-file">
        																<span class="fileupload-exists">Change</span>
        																<span class="fileupload-new">Select file</span>
        																<input type="file" name="image">
        															</span>
        															<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
        														</div>
        													</div>
                                  </div>
                        </div>
												@endif


												<div class="form-group">
													<label class="col-md-3 control-label" for="profileAddress">ที่อยู่</label>
													<div class="col-md-8">
														<textarea class="form-control" rows="2" name="address" id="profileBio">{{ $objs->address }}</textarea>
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label" for="profileAddress">เกี่ยวกับนักเรียน</label>
													<div class="col-md-8">
														<textarea class="form-control" rows="2" name="bio" id="profileBio">{{ $objs->bio }}</textarea>
													</div>
												</div>

											</fieldset>





											<div class="panel-footer">
												<div class="row">
													<div class="col-md-9 col-md-offset-3">
														<button type="submit" class="btn btn-primary">Update</button>
														<button type="reset" class="btn btn-default">Reset</button>
													</div>
												</div>
											</div>

										</form>

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
