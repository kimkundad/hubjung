@extends('admin.layouts.template')

@section('admin.stylesheet')

<link rel="stylesheet" href="{{asset('./assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">

@stop('admin.stylesheet')

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
							<div class="col-md-2 col-lg-2">



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

										<form id="newsForm" class="form-horizontal" action="{{$url}}" method="post" enctype="multipart/form-data">
                      {{ method_field($method) }}
											{{ csrf_field() }}

											<h4 class="mb-xlg">ใส่ข้อมูลคอร์ส</h4>

											<fieldset>

                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">ชื่อคอร์ส*</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="มินนะ โนะ นิฮงโกะ みんなの日本語 かんじ N5+N4">
													</div>
												</div>



												<div class="form-group">
													<label class="col-md-3 control-label" for="profileAddress">ภาควิชา*</label>
													<div class="col-md-8">
														<select name="name_department" class="form-control mb-md" required>

								                      <option value="">-- เลือกภาควิชา --</option>
								                      @foreach($department as $departments)
													  <option value="{{$departments->id}}">{{$departments->name_department}}</option>
													  @endforeach
								                    </select>
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label" for="profileAddress">ประเภทคอร์ส*</label>
													<div class="col-md-8">
														<select name="typecourses" class="form-control mb-md" required>

								                      <option value="">-- เลือกประเภทคอร์ส --</option>
								                      @foreach($course as $courses)
													  <option value="{{$courses->id}}">{{$courses->type_name}}</option>
													  @endforeach
								                    </select>
													</div>
												</div>


												<div class="form-group">
													<label class="col-md-3 control-label" for="profileAddress">วีดีโอย้อนหลัง*</label>
													<div class="col-md-8">
														<select name="video_back" class="form-control mb-md" required>
															  <option value="0">-- ไม่มีให้ --</option>
																  <option value="1">-- มีให้ --</option>
								                    </select>
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label" for="profileAddress">ระบบคอร์ส เติมเงิน / รายเดือน*</label>
													<div class="col-md-8">
														<select name="set_type_c" class="form-control mb-md" required>
															  <option value="0">-- เติมเงิน --</option>
																  <option value="1">-- รายเดือน --</option>
								                    </select>
													</div>
												</div>


												<div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">เอกสารการเรียน</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="file_study" value="{{ old('file_study') }}" placeholder="ข้อมูลเอกสารการเรียน">
													</div>
												</div>


												<div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">อาจารย์ผู้สอน</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="te_study" value="{{ old('te_study') }}" placeholder="ครูพี่โฮม , เอ็ตจัง">
													</div>
												</div>








										<div class="form-group">
												<label class="col-md-3 control-label" for="profileFirstName">รหัสคอร์ส*</label>
														<div class="col-md-8">
																<input type="text" class="form-control" name="code_course" value="{{ old('code_course') }}" placeholder="EN101">
														</div>
										</div>

                      <div class="form-group">
                        <label class="col-md-3 control-label" for="profileFirstName">ราคาคอร์ส* (ไม่มีให้ใส่ 0)</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="price" value="{{ old('price') }}" placeholder="1500">
                          </div>
                      </div>


											<div class="form-group">
                        <label class="col-md-3 control-label" for="profileFirstName">ราคาส่วนลด* (ไม่มีให้ใส่ 0)</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="discount" value="{{ old('discount') }}" placeholder="500">
                          </div>
                      </div>

											<div class="form-group">
                        <label class="col-md-3 control-label" for="profileFirstName">อัตราการสูญเสีย ดู video* (ไม่มีให้ใส่ 0)</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="del_video" value="{{ old('del_video') }}" placeholder="1.75">
                          </div>
                      </div>

											<div class="form-group row">
												<label for="tags-input" class="col-lg-3 control-label text-lg-right pt-2">Input Tags</label>
												<div class="col-lg-8">
													<input name="tags" id="tags-input"  data-role="tagsinput" data-tag-class="badge badge-primary" value="{{ old('tags') }}" class="form-control"  />
													<p>
														กดเครื่องหมาย <code>" , "</code> เพื่อทำการเพิ่ม Tags
													</p>
												</div>
											</div>


                      <div class="form-group">
                        <label class="col-md-3 control-label" for="profileFirstName">ช่วงเวลา (ไม่ต้องใส่ก็ได้)</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="time_course" value="{{ old('time_course') }}" placeholder="10:00-11:59 น.">
                          </div>
                      </div>


                      <div class="form-group">
                        <label class="col-md-3 control-label" for="profileFirstName">วันที่สอน (ไม่ต้องใส่ก็ได้)</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="day_course" value="{{ old('day_course') }}" placeholder="อาทิตย์, จันทร์">
                          </div>
                      </div>


                        <div class="form-group">
                          <label class="col-md-3 control-label" for="exampleInputEmail1">รูป คอร์ส*</label>
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
													<label class="col-md-3 control-label" for="profileFirstName">รายละเอียดคอร์ส*</label>
													<div class="col-md-8">
                            <textarea class="form-control" name="detail" rows="4">{{ old('detail') }}</textarea>
													</div>
												</div>



												<div class="form-group">
	                        <label class="col-md-3 control-label" for="profileFirstName">ข้อมูลเวลาการเรียน (ไม่ต้องใส่ก็ได้)</label>
	                            <div class="col-md-8">
	                                <textarea class="form-control" name="time_course_text" rows="3">{{ old('time_course_text') }}</textarea>
	                          </div>
	                      </div>


                  <!--      <div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">วันเริ่มคอร์ส*</label>
													<div class="col-md-8">
                            <div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" data-plugin-datepicker="" name="start_course" class="form-control">
													</div>
													</div>
												</div>


                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">วันสิ้นสุดคอร์ส*</label>
													<div class="col-md-8">
                            <div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" data-plugin-datepicker="" name="end_course" class="form-control">
													</div>
													</div>
												</div> -->


											</fieldset>







											<div class="panel-footer">
												<div class="row">
													<div class="col-md-9 col-md-offset-3">
														<button type="submit" class="btn btn-primary">เพิ่มคอร์ส</button>
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


<script src="{{url('./assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
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
</script>


@stop('admin.scripts')
