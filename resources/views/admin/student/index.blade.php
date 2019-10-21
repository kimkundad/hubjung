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
                  <div class="col-md-6">
                    <a class="btn btn-default " href="{{url('admin/student/create')}}" role="button">
                      <i class="fa fa-plus"></i> เพิ่มนักเรียน</a>
                  </div>
                  <div class="col-md-6">

                    <form class="form-horizontal form-bordered" method="GET" action="{{url('admin/search_student')}}">
                {{ csrf_field() }}

											<div class="form-group row">
                        <div class="col-lg-10">
                          <input type="text" class="form-control" name="q" id="q" placeholder="Search...">
                        </div>


                        <div class="col-lg-1">
                        <button type="submit" class="mb-1 mt-1 mr-1 btn btn-info"><i class="fa fa-search"></i> </button>
                        </div>
											</div>

									</form>
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
                <br>
                <div class="table-responsive">
                <table class="table table-bordered table-striped mb-none dataTable " >
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>ชื่อผู้ใช้งาน</th>
                      <th>อีเมล</th>
                      <th>Line ID</th>
                      <th>เบอร์โทร</th>
                      <th>วันเกิด</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($objs)
                @foreach($objs as $u)
                    <tr>
                      <td>{{$u->id}}</td>
                      <td>

                        @if($u->provider == 'email')
                        <img data-view="user_avatar_1980" alt="" src="{{url('assets/images/avatar/'.$u->avatar)}}"
                        class="avatar avatar-32 photo" width="32" height="32" data-pin-nopin="true">
                        @else
                        <img data-view="user_avatar_1980" alt="" src="//{{$u->avatar}}"
                        class="avatar avatar-32 photo" width="32" height="32" data-pin-nopin="true">
                        @endif

                        {{$u->name}}</td>
                      <td>{{$u->email}}</td>
                      <td>{{$u->line_id}}</td>
                      <td>{{$u->phone}}</td>
                      <td><?php echo DateThai($u->hbd); ?></td>


                      <td>




                        <a style="float:left; margin-right:3px;" class="btn btn-success btn-xs" href="{{url('admin/inbox_chat/'.$u->id)}}"
                          role="button"><i class="fa fa-commenting-o"></i> </a>

                       <a style="float:left; margin-right:3px;" class="btn btn-primary btn-xs" href="{{url('admin/student/'.$u->id)}}"
                          role="button"><i class="fa fa-wrench"></i> </a>
                          @if(Auth::user()->id != $u->id)
                         <form  action="{{url('admin/student/'.$u->id)}}" method="post" onsubmit="return(confirm('Do you want Delete'))">
                            <input type="hidden" name="_method" value="DELETE">
                             <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-danger btn-xs" style="float:left;"><i class="fa fa-times "></i></button>
                          </form>
                          @else

                          @endif

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
