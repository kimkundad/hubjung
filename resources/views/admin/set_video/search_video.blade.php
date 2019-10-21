@extends('admin.layouts.template')
@section('admin.content')

        <section role="main" class="content-body">

          <header class="page-header">
            <h2>จัดการ video ทั้งหมด</h2>

            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="dashboard.html">
                    <i class="fa fa-home"></i>
                  </a>
                </li>

                <li><span>จัดการ video ทั้งหมด</span></li>
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

                <h2 class="panel-title">จัดการ video ทั้งหมด</h2>
              </header>
              <div class="panel-body">

                <div class="row">
                  <div class="col-md-6">

                  </div>
                  <div class="col-md-6">

                    <form class="form-horizontal form-bordered" method="GET" action="{{url('admin/search_list_video')}}">
                      {{ csrf_field() }}

											<div class="form-group row">
                        <div class="col-lg-10">
                          <input type="text" class="form-control" name="q" id="q" value="{{$q}}" placeholder="ค้นหา คอร์สเรียน, ชื่อวิดีโอ">
                        </div>


                        <div class="col-lg-1">
                        <button type="submit" class="mb-1 mt-1 mr-1 btn btn-info"><i class="fa fa-search"></i> </button>
                        </div>
											</div>

									</form>
                  <br />
                  </div>

                </div>


                <table class="table table-bordered table-striped mb-none  " >
                  <thead>
                    <tr>
                      <th>#ชื่อวิดีโอ</th>
                      <th>คอร์สเรียน</th>

                      <th>ภาควิชา</th>
                      <th>เติมเงิน / รายเดือน</th>
                      <th>Featured Videos</th>
                      <th>ทดลองใช้</th>
                      <th>ความยาว / นาที</th>
                    </tr>
                  </thead>
                  <tbody>

                    @if($video_list)
                    @foreach($video_list as $u)

                    <tr id="{{$u->id_v}}" class="c_test" access_id="{{$u->id_v}}" free_id="{{$u->id_v}}">
                      <td>{{$u->id_v}} : {{$u->course_video_name}}</td>
                      <td>{{$u->title_course}}</td>
                      <td>{{$u->name_department}}</td>
                      <td>

                        @if($u->set_type_c == 0)
                        เติมเงิน
                        @else
                        รายเดือน
                        @endif

                      </td>
                      <td>
                        <div class="switch switch-sm switch-success">
                          <input type="checkbox" id="fea_video" class="switch" name="switch" data-plugin-ios-switch
                          @if($u->fea_video == 1)
                          checked="checked"
                          @endif
                          />
                        </div>
                      </td>

                      <td>
                        <div class="switch switch-sm switch-success">
                          <input type="checkbox" name="switch2" class="switch2" data-plugin-ios-switch
                          @if($u->free_video == 1)
                          checked="checked"
                          @endif
                          />
                        </div>
                      </td>
                      <td>

                        <form id="cutproduct" class="typePay2 " novalidate="novalidate" action="" method="post"  role="form">
                          <div class="numbers-row">
                            <input type="text" value="{{$u->time_video}}" id="quantity_{{$u->id_v}}" class="qty2 form-control" style="width:65px;" name="time_video">
                          </div>
                          <input type="hidden" class="ids" name="id" value="{{$u->id_v}}">

                        </form>



                      </td>


                      </tr>

                    @endforeach
                    @endif

                  </tbody>
                </table>
                <div class="pagination"> {{ $video_list->links() }} </div>
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



  $('form input').change(function() {
console.log('Textarea Change');


    //  var username = $('form#cutproduct input[name=id]').val();


    var $form = $(this).closest("form#cutproduct");
    var formData =  $form.serializeArray();
    var qty2 =  $form.find(".qty2").val();
    var ids =  $form.find(".ids").val();

    console.log(ids);


      if(qty2){
        $.ajax({
          type: "POST",
          url: "{{url('admin/add_qty2_photo')}}",
          headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          data: {
            qty2 : qty2,
            ids : ids
          },
          dataType: "json",
       success: function(json){
           if(json.status == 1001) {

             setTimeout(function() {

               PNotify.prototype.options.styling = "fontawesome";
               new PNotify({
                     title: 'ยินดีด้วยค่ะ',
                     text: 'คุณได้ทำการแก้ไขข้อมูลสำเร็จแล้ว',
                     type: 'success'
                   });

           }, 1800);

            } else {

            }
          },
          failure: function(errMsg) {
            alert(errMsg.Msg);
          }
        });
      }else{


      }
    });









  $("input.switch").change(function(event) {




    var course_id = $(this).closest('tr').attr('access_id');

    console.log('fea : '+course_id);
    $.ajax({
            type:'POST',
            url:'{{url('admin/fea_video')}}',
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


$(document).ready(function(){
  $("input.switch2").change(function(event) {

    var course_id = $(this).closest('tr').attr('free_id');

    console.log('free : '+course_id);
    $.ajax({
            type:'POST',
            url:'{{url('admin/free_video')}}',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data: { "course_id" : course_id },
            success: function(data){
              if(data.data.success){

                PNotify.prototype.options.styling = "fontawesome";
                new PNotify({
                      title: 'ยินดีด้วยค่ะ',
                      text: 'ยินดีด้วย ได้ทำการแก้ไขข้อมูล สำเร็จเรียบร้อยแล้วค่ะ',
                      type: 'success'
                    });





              }
            }
        });
    });
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
