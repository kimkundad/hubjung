@extends('admin.layouts.template')
@section('admin.content')

				<section role="main" class="content-body">

					<header class="page-header">
						<h2>เพิ่ม Package รายเดือน</h2>

						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="dashboard.html">
										<i class="fa fa-home"></i>
									</a>
								</li>

								<li><span>เพิ่ม Package รายเดือน</span></li>
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

										<form class="form-horizontal" action="{{$url}}" method="post" enctype="multipart/form-data">
											{{ csrf_field() }}

											<h4 class="mb-xlg">แก้ไขหมวดหมู่ภาควิชา</h4>

											<fieldset>
                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">ชื่อ Package*</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="package_name" value="{{ old('package_name') }}" >
														</div>
												</div>

                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileAddress">ภาควิชา*</label>
													<div class="col-md-8">
														<select name="department_id" class="form-control mb-md" required>

								                      <option value="">-- เลือกภาควิชา --</option>
								                      @foreach($department as $departments)
													  <option value="{{$departments->id}}">{{$departments->name_department}}</option>
													  @endforeach
								                    </select>
													</div>
												</div>

                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileAddress">จำนวนวัยของ Package*</label>
													<div class="col-md-8">
														<select name="package_day" class="form-control mb-md" required>

								                      <option value="7">-- 7 วัน  --</option>
                                      <option value="30">-- 30 วัน / 1 เดือน  --</option>
                                      <option value="60">-- 60 วัน / 2 เดือน  --</option>
                                      <option value="90">-- 90 วัน / 3 เดือน  --</option>
                                      <option value="120">-- 120 วัน / 4 เดือน  --</option>
                                      <option value="180">-- 180 วัน / 6 เดือน  --</option>
                                      <option value="365">-- 1 ปี  --</option>
								                    </select>
													</div>
												</div>

                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">ราคา Package*</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="package_price" value="{{ old('package_price') }}" >
														</div>
												</div>

                        <div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">Package ลำดับ (ใส่ตัวเลขเพื่อเรียงลำดับการแสดง)*</label>
													<div class="col-md-8">
														<input type="number" class="form-control" name="package_sort" value="{{ old('package_sort') }}" >
														</div>
												</div>


												<div class="form-group">
                          <label class="col-md-3 control-label" for="exampleInputEmail1">รูป Package*</label>
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

@stop('scripts')
