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

                    <img src="{{url('assets/images/avatar/blank_avatar_240x240.gif')}}" class="rounded img-responsive">


									</div>






								</div>
							</section>

							</div>







              <div class="col-md-8 col-lg-8">

							<div class="tabs">

								<div class="tab-content">

									<div id="edit" class="tab-pane active">

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

										<form class="form-horizontal" action="{{$url}}" method="post" enctype="multipart/form-data">
                      {{ method_field($method) }}
											{{ csrf_field() }}

											<h4 class="mb-xlg">ใส่ข้อมูลนักเรียน</h4>

											<fieldset>
                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">ชื่อนักเรียน*</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="name" value="{{ old('name') }}" id="profileFirstName">
														<input type="hidden" class="form-control" name="is_admin" value="0" id="profileFirstName">
														<input type="hidden" class="form-control" name="position" value="student" id="profileFirstName">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">ไลน์ ไอดี</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="line_id" value="{{ old('line_id') }}" id="profileFirstName">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileLastName">วันเกิด*</label>
													<div class="col-md-8">
														<input type="text" data-plugin-datepicker name="hbd" class="form-control datepicker"  required="">
													</div>
												</div>
                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">อีเมล*</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="email" value="{{ old('email') }}" id="profileCompany" required="">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">เบอร์โทร*</label>
													<div class="col-md-8">
														<input type="number" class="form-control" name="phone" value="{{ old('phone') }}" id="profileCompany" required="">
													</div>
												</div>


                        <div class="form-group">
                          <label class="col-md-3 control-label" for="exampleInputEmail1">รูป Avatar*</label>
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
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileAddress">ที่อยู่</label>
													<div class="col-md-8">
														<textarea class="form-control" rows="2" name="address" id="profileBio">{{ old('address') }}</textarea>
													</div>
												</div>


												<div class="form-group">
													<label class="col-md-3 control-label" for="profileAddress">เกี่ยวกับนักเรียน</label>
													<div class="col-md-8">
														<textarea class="form-control" rows="2" name="bio" id="profileBio">{{ old('address') }}</textarea>
													</div>
												</div>

											</fieldset>


											<hr class="dotted tall">
											<h4 >Password</h4>
											<div class="well warning">ตั้ง password ง่ายๆ 6 ตัว เช่น 123456 หรือ abcdef เพื่อง่ายต่อการจดจำ จากนั้นให้นักเรียนไปทำการเปลี่ยน
												password ที่อีเมล์เอง เนื่องจากเรามีระบบป้องการโจมตีทางโลกไซเบอร์ ที่ไม่สามารถเจาะเข้ามาเอา password ได้</div>
											<fieldset class="mb-xl">
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileNewPassword">Password*</label>
													<div class="col-md-8">
														<input type="password" class="form-control" name="password" placeholder="ใส่พาสเวิร์ด 6 ตัว"  value="{{ old('password') }}">
													</div>
												</div>
                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileNewPassword">Confirm Password*</label>
													<div class="col-md-8">
														<input type="password" class="form-control" name="password_confirmation" placeholder="ใส่พาสเวิร์ด 6 ตัว"  value="{{ old('password_confirmation') }}">
													</div>
												</div>
											</fieldset>




											<div class="panel-footer">
												<div class="row">
													<div class="col-md-9 col-md-offset-3">
														<button type="submit" class="btn btn-primary">Submit</button>
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


@stop('scripts')
