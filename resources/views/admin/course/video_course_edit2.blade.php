@extends('admin.layouts.template')

@section('admin.stylesheet')

@stop('admin.stylesheet')

@section('admin.content')

				<section role="main" class="content-body">

					<header class="page-header">
						<h2>{{$datahead}}</h2>

						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{url('admin/course/'.$get_video->course_id.'/edit')}}">
										<i class="fa fa-cube" aria-hidden="true"></i> <span> กลับไปคอร์สหลัก</span>
									</a>
								</li>

								<li><span>{{$datahead}}</span></li>
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
                    <h4 class="mb-xlg">แก้ไขไฟล์ Video</h4>

    								<form id="newsForm121" class="form-horizontal" action="{{url('post_edit_video_course2')}}" method="post" enctype="multipart/form-data">

    									{{ csrf_field() }}
    									<input type="hidden" class="form-control" name="course_id"  value="{{$get_video->course_id}}" >
                      <input type="hidden" class="form-control" name="video_id"  value="{{$get_video->id}}" >

    									<div class="form-group">
    										<label class="col-md-3 control-label" for="profileFirstName">ชื่อวีดีโอคอร์ส*</label>
    												<div class="col-md-8">
    														<input type="text" class="form-control" value="{{$get_video->course_video_name}}" name="name_video" required>
    											</div>
    									</div>

											<div class="form-group">
												<label class="col-md-3 control-label" for="profileFirstName">ความยาววีดีโอ*</label>
														<div class="col-md-8">
																<input type="text" class="form-control" value="{{$get_video->time_video}}" name="time_video" placeholder="30.25">
													</div>
											</div>


                      <div class="form-group">
    										<label class="col-md-3 control-label" for="profileFirstName">คำอธิบายวีดีโอคอร์ส*</label>
    												<div class="col-md-8">
    														<textarea class="form-control" name="course_video_detail" rows="3">{{$get_video->course_video_detail}}</textarea>
    											</div>
    									</div>


                      <div class="form-group">
    										<label class="col-md-3 control-label" for="profileFirstName">รูปวีดีโอคอร์ส*</label>
    												<div class="col-md-8">
    														<img src="{{url('web_stream/thumbnail_video/'.$get_video->thumbnail_img)}}" class="img-responsive">
    											</div>
    									</div>



    									<div class="form-group">
    										<label class="col-md-3 control-label" for="exampleInputEmail1">code วีดีโอคอร์ส*</label>
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
    																	<input type="file" name="file" >
    																</span>
    																<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
    															</div>
    														</div>
    														</div>
    									</div>

    									<div class="form-group">
    										<label class="col-md-3 control-label" for="exampleInputEmail1">รูป วีดีโอคอร์ส*</label>
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







    									<div class="panel-footer">
    										<div class="row">
    											<div class="col-md-9 col-md-offset-3">
    												<button type="submit" class="btn btn-primary">แก้ไขวิดีโอคอร์ส</button>
    												<button type="reset" class="btn btn-default">Reset</button>
    											</div>
    										</div>
    									</div>

    								</form>

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
</script>


@stop('admin.scripts')
