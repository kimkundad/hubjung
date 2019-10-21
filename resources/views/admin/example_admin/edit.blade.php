@extends('admin.layouts.template')
@section('admin.content')
<style>
.form-horizontal .form-group {
    margin-right: 1px;
    margin-left: 1px;
}
</style>
        <section role="main" class="content-body">

          <header class="page-header">
            <h2>{{$datahead}}</h2>

            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="dashboard.html">
                    <i class="fa fa-home"></i>
                  </a>
                </li>

                <li><span>{{$datahead}}</span></li>
              </ol>

              <a class="sidebar-right-toggle" data-open="sidebar-right" ><i class="fa fa-chevron-left"></i></a>
            </div>
          </header>


          <!-- start: page -->




              <div class="row">
              <div class="col-xs-12">




                <div class="col-md-6">
                  <h2 class="panel-title">{{$datahead}}</h2>
                  <h5>ชื่อนักเรียน : {{$objs->name}}</h5>
                  <h5>วิชา : {{$objs->title_course}}</h5>
                  <hr>
                  <form id="newsForm" class="form-horizontal" action="{{$url}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="set_id" value="{{$objs->set_id}}" >
                    {{ method_field($method) }}
                    {{ csrf_field() }}
                  @if($course_tech)
                        @foreach($course_tech as $u)
                        <div class="panel-body" style="padding:10px;">

                <div class="form-group" style="border-bottom: 1px solid #efefef;">

                <label class="control-label"><?php if($u->ans_status==1){ echo '<i class="fa fa-check-circle text-success"></i>'; } ?> {{$u->name_questions}}*</label>
                    <textarea class="form-control" rows="5" name="value_{{$u->ans_id}}" required>{{$u->answers}}</textarea>
                    </div>
                    <input type="hidden" class="form-control" name="ans_id[]" value="{{$u->ans_id}}" >
                    <label class="control-label">ความถูกต้องของคำตอบ </label>
                    <select class="form-control" name="ans_status_{{$u->ans_id}}">
                      <option value="0" <?php if($u->ans_status==0){ echo 'selected="selected"'; } ?> >ไม่ถูกต้อง</option>
                      <option value="1" <?php if($u->ans_status==1){ echo 'selected="selected"'; } ?>>ถูกต้อง</option>
                    </select>

                    </div>
                    <br>
                    @endforeach
                    @endif

                    <button type="submit" class="btn btn-primary">ส่งคำตอบ</button>
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

@if ($message = Session::get('success_check_course'))
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


@if ($message = Session::get('delete'))
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
