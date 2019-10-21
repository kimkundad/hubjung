@extends('admin.layouts.template')
@section('admin.content')

        <section role="main" class="content-body">

          <header class="page-header">
            <h2>Package รายเดือน</h2>

            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="dashboard.html">
                    <i class="fa fa-home"></i>
                  </a>
                </li>

                <li><span>Package รายเดือน</span></li>
              </ol>

              <a class="sidebar-right-toggle" data-open="sidebar-right" ><i class="fa fa-chevron-left"></i></a>
            </div>
          </header>


          <!-- start: page -->



<div class="row">
              <div class="row">
              <div class="col-xs-12">

            <section class="panel">

              <div class="row">

                <div class="col-md-12">
                <a class="btn btn-default " href="{{url('admin/package_product/create')}}" role="button">
                  <i class="fa fa-plus"></i> เพิ่ม Package รายเดือน</a>
                  <br /><br />
                </div>


                @if($objs)
                  @foreach($objs as $u)
                  <div class="col-md-3">
                    <a href="{{url('admin/package_product/'.$u->id.'/edit')}}">
                      <img src="{{url('web_stream/img/package/'.$u->package_image)}}" class="img-responsive" />

                    </a>
                    <p>
                      @if($u->package_status == 1)
                      เปิดใช้งาน
                      @else
                      ปิดใช้งาน
                      @endif
                    </p>
                  </div>
                  @endforeach
                @endif

                </div>




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

@if ($message = Session::get('edit_success'))
<script type="text/javascript">

  var stack_topleft = {"dir1": "down", "dir2": "right", "push": "top"};
      var notice = new PNotify({
            title: 'ทำรายการสำเร็จ',
            text: 'ยินดีด้วย ได้ทำการแก้ไขข้อมูล สำเร็จเรียบร้อยแล้วค่ะ',
            type: 'success',
            addclass: 'stack-topright'
          });
</script>
@endif


@if ($message = Session::get('success'))
<script type="text/javascript">

  var stack_topleft = {"dir1": "down", "dir2": "right", "push": "top"};
      var notice = new PNotify({
            title: 'ทำรายการสำเร็จ',
            text: 'ยินดีด้วย ได้ทำการแก้ไขข้อมูล สำเร็จเรียบร้อยแล้วค่ะ',
            type: 'success',
            addclass: 'stack-topright'
          });
</script>
@endif

@if ($message = Session::get('delete'))
<script type="text/javascript">

  var stack_topleft = {"dir1": "down", "dir2": "right", "push": "top"};
      var notice = new PNotify({
            title: 'ทำรายการสำเร็จ',
            text: 'ยินดีด้วย ได้ทำการแก้ไขข้อมูล สำเร็จเรียบร้อยแล้วค่ะ',
            type: 'success',
            addclass: 'stack-topright'
          });
</script>
@endif

@stop('scripts')
