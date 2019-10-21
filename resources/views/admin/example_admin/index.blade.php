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

              <div class="col-xs-12">

            <section class="panel">
              <header class="panel-heading">
                <div class="panel-actions">
                  <a href="#"  class="panel-action panel-action-toggle" data-panel-toggle></a>

                </div>

                <h2 class="panel-title">{{$datahead}}</h2>
              </header>
              <div class="panel-body">

                <table class="table table-bordered table-striped mb-none dataTable " id="datatable-default">
                  <thead>
                    <tr>
                      <th>#นักเรียน</th>
                      <th>รหัสวิชา</th>
                      <th>แบบฝึกหัด</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>

                    @if($objs)
                    @foreach($objs as $u)
                    <tr>
                      <td>
                        <a href="{{url('admin/student/'.$u->u_id.'/edit')}}">
                        @if($u->provider == 'email')

                        @if($u->avatar != NULL)
                        <img src="{{url('assets/images/avatar/'.$u->avatar)}}"
                        class="img-circle" width="25" height="25" style="margin-right:3px;">
                        @else
                        <img src="{{url('assets/images/avatar/blank_avatar_240x240.gif')}}"
                        class="img-circle" width="25" height="25" style="margin-right:3px;">
                        @endif

                        @else
                        <img src="//{{$u->avatar}}"
                        class="img-circle" width="25" height="25" style="margin-right:3px;">
                        @endif
                        {{$u->name}}</a>
                      </td>
                      <td>{{$u->code_course}}</td>
                      <td>{{$u->examples_name}}</td>


                      <td>

                        <a style="float:left; margin:3px;" class="btn btn-primary btn-xs" href="{{url('admin/example_admin/'.$u->set_id.'/edit')}}" role="button"><i class="fa fa-wrench"></i> </a>

                          <form  action="{{url('admin/example_admin/'.$u->set_id)}}" method="post" onsubmit="return(confirm('Do you want Delete'))">
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
            </section>

              </div>

        </div>



        <div class="row">

                      <div class="col-xs-12">

                    <section class="panel">
                      <header class="panel-heading">
                        <div class="panel-actions">
                          <a href="#"  class="panel-action panel-action-toggle" data-panel-toggle></a>

                        </div>

                        <h2 class="panel-title">แบบฝึกหัดตรวจแล้ว</h2>
                      </header>
                      <div class="panel-body">

                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>#นักเรียน</th>
                              <th>รหัสวิชา</th>
                              <th>แบบฝึกหัด</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>

                            @if($objs_old)
                            @foreach($objs_old as $u)
                            <tr>
                              <td>
                                <a href="{{url('admin/student/'.$u->u_id.'/edit')}}">
                                @if($u->provider == 'email')

                                @if($u->avatar != NULL)
                                <img src="{{url('assets/images/avatar/'.$u->avatar)}}"
                                class="img-circle" width="25" height="25" style="margin-right:3px;">
                                @else
                                <img src="{{url('assets/images/avatar/blank_avatar_240x240.gif')}}"
                                class="img-circle" width="25" height="25" style="margin-right:3px;">
                                @endif

                                @else
                                <img src="//{{$u->avatar}}"
                                class="img-circle" width="25" height="25" style="margin-right:3px;">
                                @endif
                                {{$u->name}}</a>
                              </td>
                              <td>{{$u->code_course}}</td>
                              <td>{{$u->examples_name}}</td>


                              <td>

                                <a style="float:left; margin:3px;" class="btn btn-primary btn-xs" href="{{url('admin/example_admin/'.$u->set_id.'/edit')}}" role="button"><i class="fa fa-wrench"></i> </a>

                                  <form  action="{{url('admin/example_admin/'.$u->set_id)}}" method="post" onsubmit="return(confirm('Do you want Delete'))">
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
                        {{ $objs_old->links() }}
                      </div>
                    </section>

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
