@extends('packag.layouts.template')

@section('stylesheet')
<link href="{{url('web_stream/css/jquery.steps.css')}}" rel="stylesheet">

@stop('stylesheet')
@section('content')







<div class="video-block section-padding">
   <div class="row">
      <div class="col-md-10">
         <div class="single-video-left" {{$set_zero = 1}}>

           <form class="form-horizontal" id="form" name="Form" action="{{url('post_ans_course')}}" method="post" enctype="multipart/form-data">

             {{ csrf_field() }}

            <div class="single-video-title box mb-3">
               <h2><a href="#" style="margin-right:20px;">แบบทดสอบ : {{$course_detail->examples_name}}, {{$course_detail->name_category}}</a> </h2>
               ทุกข้อที่นักเรียนทำจะทำการเก็บเวลา : <button class="btn btn-outline-danger"><span id="timestamp"></span></button>
               <input type="hidden" name="timmery_time" value="" id="timestamp2">
            </div>
            <div class="single-video-title box mb-3">
              <input type="hidden" class="form-control" name="cat_id" value="{{$course_detail->cat_id}}" >
              <input type="hidden" class="form-control" name="examples_type" value="2" >
              <input type="hidden" class="form-control" name="examples_id" value="{{$course_detail->Eid}}" >
              <div id="example-basic">

                @if(isset($course_tech))
                      @foreach($course_tech as $u)



                <h3>{{$s}}</h3>
                <section {{$sum = 0}}>
                  @if($u->image != null)
                  <img src="{{url('assets/uploads/'.$u->image)}}" class="img-fluid" style="max-width: :350px;">
                  @endif


                  <ul class="list-group answers{{$s}}" > <div>
                  <h6>{{$u->name_questions}}</h6>
                  </div>
                    <input type="hidden" name="value_{{$s}}" value="" class="answers-1" id="get_sum_ship{{$s}}">
                    @if(isset($u->options))
                    @foreach($u->options as $uu)
                    <li  class="switch list-group-item list-group-item-action" access_id="{{$uu->id_option}}" s_id="{{$s}}" {{$sum++}}> {{$sum}}.  {{$uu->name_option}}</li>
                    @endforeach
                    @endif

                  </ul>
                </section {{$s++}} {{$set_zero++}}>
                    @endforeach
                @endif
            </div>
            </div>
            </form {{$set_zero -= 1}}>





         </div>
      </div>


   </div>
</div {{$sum = 0}}>



@endsection

@section('scripts')
<script src="{{url('web_stream/js/jquery.steps.js')}}"></script>
<script src="{{url('web_stream/js/ClockTimer.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

var final_set1 = 0;

console.log({{$s-1}});

function checkInputs() {

  var flag=0;
var result = new Array();

  $("#example-basic :input").each(function(){
      var input = $(this);
      if(input.val() > 0 && input.val() !== '' ) {
          result.push(input.val());
      }
  });

  console.log(result.length);
  final_set1 = result.length;

  if(result.length == {{$set_zero}}){

  } else {

      swal("คำตอบไม่ครบ!", "นักเรียนต้องกลับไปทำข้อสอบให้ครบ!", "error");

  }

}



$(document).ready(function(){


  $('#example-basic a').click(function(event) {
               event.preventDefault();
               var get_data = $(this).attr('href');
              // console.log(final_set1);

               if(get_data == '#finish'){
                 checkInputs();
                 if(final_set1 == {{$set_zero}}){

                   console.log(final_set1);
                   $('#form').submit();
                 }

               }
              //
          });


$("li.switch").click(function(event) {

  var course_id = $(this).closest('li').attr('access_id');
  var c_id = $(this).closest('li').attr('s_id');
  document.getElementById("get_sum_ship"+c_id).value = Number(course_id);
  console.log('fea : '+course_id);
/*  $.ajax({
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
      }); */


  });
    });




$("#example-basic").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    autoFocus: true
});

var price_image = 0;

$(function(){
    console.log('ready');

    @if(isset($course_tech))
          @foreach($course_tech as $u)

    $('.answers{{$set}} li').click(function(e) {
        e.preventDefault()

        $that = $(this);
        price_image = document.getElementById('timestamp').innerText;
        console.log(price_image);
        document.getElementById("timestamp2").value = price_image;
        $('.answers{{$set}}').find('li').removeClass('active');
        $that.addClass('active');
    });

    {{$set++}}
    @endforeach
@endif

    $('.answers2 li').click(function(e) {
        e.preventDefault()

        $that = $(this);

        $('.answers2').find('li').removeClass('active');
        $that.addClass('active');
    });

})

$(document).ready(function() {

 var timmery = clock.config({
    display: 'timestamp'
});

setTimeout(function() {
    clock.StartTime();
}, 1000);

});




</script>

@stop('scripts')
