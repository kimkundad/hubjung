@extends('admin.layouts.template')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="{{URL::asset('assets/text/dist/summernote.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('./assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
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

<style>
.fileupload .uneditable-input .fa {
    position: absolute;
    margin-top: 4px;
    /* top: 12px; */
}
.note-editor.note-frame .note-editing-area .note-editable {
    padding: 40px;
    overflow: auto;
    color: #000;
    background-color: #fff;
}
</style>

           <div class="row">
              <div class="row">
                <div class="col-xs-1">
                </div>
              <div class="col-xs-10">

            <section class="panel">
              <header class="panel-heading">
                <div class="panel-actions">
                  <a href="#"  class="panel-action panel-action-toggle" data-panel-toggle></a>

                </div>

                <h2 class="panel-title">{{$header}}</h2>
              </header>
              <div class="panel-body">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

              <form action="{{$url}}" method="post" enctype="multipart/form-data">
                {{ method_field($method) }}


                <div class="form-group">
                  <label for="exampleInputEmail1">ชื่อ บทความ</label>
                  <input type="text" class="form-control" name="title" placeholder="ใส่หัวข้อบทความ"  value="{{ old('title') }}" required>

                </div>

                <div class="form-group ">

                  <label for="exampleInputEmail1">Tags</label>
                    <input name="tags" id="tags-input"  data-role="tagsinput" data-tag-class="badge badge-primary" value="{{ old('tags') }}" class="form-control"  />
                    <p>
                      กดเครื่องหมาย <code>" , "</code> เพื่อทำการเพิ่ม Tags
                    </p>

                </div>



                <div class="form-group">
                  <label for="exampleInputEmail1">รูป บทความ</label>
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

                <div class="form-group">
                  <label for="exampleInputEmail1">รายละเอียด</label>
                  <textarea class="form-control" name="detail_website" id="summernote" rows="20" required>{{old('detail_website')}}</textarea>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">คำบรรยายตอนใช้แชร์โพส ไม่ต้องยาวมาก</label>
                  <textarea class="form-control" name="detail"  rows="10" >{{old('detail')}}</textarea>
                </div>












              <br>
              <hr>
              <button type="submit" class="btn btn-default pull-right">เพิ่ม บทความ</button>
            </form>

              </div>
            </section>

              </div>
              <div class="col-xs-1">
              </div>
            </div>
        </div>
</section>



@stop

@section('scripts')

<script src="{{URL::asset('assets/text/dist/summernote.js')}}"></script>
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

<script type="text/javascript">
$(document).ready(function() {
  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
  $('#summernote').summernote({

    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
    disableDragAndDrop: true,
    height: 500,                 // set editor height
    minHeight: null,             // set minimum height of editor
    maxHeight: null,             // set maximum height of editor
    focus: true                  // set focus to editable area after initializing summernote

  });
});
var postForm = function() {
var content = $('textarea[name="detail"]').html($('#summernote').code());
}
</script>


@stop('scripts')
