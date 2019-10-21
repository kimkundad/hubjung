@extends('admin.layouts.template')
@section('admin.content')

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
              <div class="row">
              <div class="col-xs-12">

            <section class="panel">
              <header class="panel-heading">
                <div class="panel-actions">
                  <a href="#"  class="panel-action panel-action-toggle" data-panel-toggle></a>

                </div>

                <h2 class="panel-title">{{$datahead}}</h2>
              </header>
              <div class="panel-body">

                <div class="row">
                  <div class="col-md-12">
                    <a class="btn btn-default " href="{{url('admin/course/create')}}" role="button">
                      <i class="fa fa-plus"></i> เพิ่มคอร์สเรียน</a>
                      <a class="btn btn-danger " href="{{url('admin/typecourse')}}" role="button">
                      <i class="fa fa-cubes"></i> ประเภทคอร์ส</a>
                      <a class="btn btn-success " href="{{url('admin/category')}}" role="button">
                      <i class="fa fa-question-circle"></i> หมวดหมู่แบบฝึกหัด</a>
                  </div>

                </div>

                <br>
                <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none dataTable " >
                  <thead>
                    <tr>
                      <th>#ลำดับ</th>
                      <th>คอร์สเรียน</th>
                      <th>ประเภท</th>
                      <th>ภาควิชา</th>
                      <th>เติมเงิน / รายเดือน</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($objs)
                @foreach($objs as $u)
                    <tr id="{{$u->id}}">
                      <td>{{$u->sort_corse}}</td>
                      <td>{{$u->title_course}}</td>
                      <td>@foreach($course as $courses)
                        @if($u->type_course == $courses->id)
                        {{$courses->type_name}}
                        @endif
                        @endforeach
                        </td>
                        <td>@foreach($department as $departments)
                          @if($u->department_id == $departments->id)
                          {{$departments->name_department}}
                          @endif
                          @endforeach
                          </td>
                      <td>

                        @if($u->set_type_c == 0)
                        เติมเงิน
                        @else
                        รายเดือน
                        @endif

                      </td>

                      <td>
                        <div class="switch switch-sm switch-success">
                          <input type="checkbox" name="switch" data-plugin-ios-switch
                          @if($u->ch_status == 1)
                          checked="checked"
                          @endif
                          />
                        </div>
                      </td>

                      <td>
                        <a style="float:left; margin:3px;" class="btn btn-warning btn-xs" href="{{url('admin/message_chat/'.$u->c_id)}}" role="button"><i class="fa fa-commenting-o"></i> </a>
                        @if($u->e_id)
                        <a style="float:left; margin:3px;" class="btn btn-success btn-xs" href="{{url('admin/course/'.$u->c_id)}}" role="button"><i class="fa fa-question-circle"></i> </a>
                        @endif
                        <a style="float:left; margin:3px;" class="btn btn-primary btn-xs" href="{{url('admin/course/'.$u->id.'/edit')}}" role="button"><i class="fa fa-wrench"></i> </a>

                          <form  action="{{url('admin/course/'.$u->id)}}" method="post" onsubmit="return(confirm('Do you want Delete'))">
                            <input type="hidden" name="_method" value="DELETE">
                             <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" style="float:left; margin:3px;" class="btn btn-danger btn-xs"><i class="fa fa-times "></i></button>
                          </form>

                      </td>


                      </tr>
                       @endforeach
              @endif

                  </tbody>
                </table>
                </div>
                <div class="pagination"> {{ $objs->links() }} </div>
              </div>
            </section>

              </div>
            </div>
        </div>
</section>
@stop



@section('scripts')


<script type="text/javascript">
$(document).ready(function(){
  $("input:checkbox").change(function() {
    var course_id = $(this).closest('tr').attr('id');

    $.ajax({
            type:'POST',
            url:'{{url('admin/post_status')}}',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data: { "course_id" : course_id },
            success: function(data){
              if(data.data.success){


                PNotify.prototype.options.styling = "fontawesome";
                new PNotify({
                      title: 'ยินดีด้วยค่ะ',
                      text: 'คุณได้ทำการเลือกข้อมูลสำเร็จแล้ว',
                      type: 'success'
                    });



              }
            }
        });
    });
});
</script>


<script>

socket.on( 'new_count_message', function( data ) {

$( "#new_count_message" ).html( data.new_count_message );
  console.log(data.new_count_message);
});

socket.on( 'new_message', function( data ) {
  var sum_check = 0;
  console.log(data.message_in);
  if(data.check_noti === sum_check ){

    if(data.provider === 'email'){
      $( "#messages_noti" ).append('<li><a href="{{url('admin/inbox_chat/')}}/'+ data.chat_user_id +'" class="clearfix"><figure class="image"><img src="{{url('assets/images/avatar/')}}/'+data.avatar+'" width="35" height="35" class="img-circle"></figure><span class="title">'+ data.name +'</span><span class="message">มีข้อความมาใหม่ถึงคุณ</span></a></li>');
    }else{

      $( "#messages_noti" ).append('<li><a href="{{url('admin/inbox_chat/')}}/'+ data.chat_user_id +'" class="clearfix"><figure class="image"><img src="//'+data.avatar+'" width="35" height="35" class="img-circle"></figure><span class="title">'+ data.name +'</span><span class="message">มีข้อความมาใหม่ถึงคุณ</span></a></li>');
    }
  }
  console.log(data.check_noti);

  $('#notif_audio')[0].play();
});

</script>

@if ($message = Session::get('success_course'))
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
