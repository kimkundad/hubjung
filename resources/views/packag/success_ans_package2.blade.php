@extends('packag.layouts.template')

@section('stylesheet')
<link href="{{url('web_stream/css/jquery.steps.css')}}" rel="stylesheet">

@stop('stylesheet')
@section('content')







<div class="video-block section-padding">
   <div class="row">
      <div class="col-md-10">
         <div class="single-video-left" >



           <div class="single-video-title box mb-3">
              <h2><a href="#" style="margin-right:20px;">แบบทดสอบ : {{$course_detail->examples_name}}, {{$course_detail->name_category}}</a> </h2>
              <br />
              ทำเวลาในการทำข้อสอบ : <button class="btn btn-outline-danger"><span id="timestamp">{{$course_tech_get->time_ans}} / นาที</span></button>
              <br /><br />
              ทำคะแนนรวมได้ : <button class="btn btn-outline-success"><span id="timestamp">{{$course_tech_count}} / {{$course_tech_count_all}} คะแนน</span></button>
              <input type="hidden" name="timmery_time" value="" id="timestamp2">

              <br /><br /><br />
              <div class="main-title">
                 <h6>ดูข้อสอบที่ทำล่าสุดตอนนี้</h6>
               </div>
               <hr />


               @if($course_tech)
                     @foreach($course_tech as $u)

               <label for="e3">{{$u->name_questions}}
                 @if( $u->ans_status == 1)
                   <span class="text-success"> (ตอบถูก)</span>
                   @else
                   <span class="text-danger"> (ผิด)</span>
                   @endif
               </label>

               @if(isset($u->options))
               @foreach($u->options as $uu)
               <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customCheck1" @if( $u->answers == $uu->id_option)
                    checked='checked'
                    @endif>
                  <label class="custom-control-label" for="customCheck1">{{$uu->name_option}}</label>
               </div>
               @endforeach
               @endif


               <hr />
                    @endforeach
               @endif


           </div>







         </div>
      </div>

      <div class="col-sm-10 text-right">
         <a href="{{url('all_e_testing/')}}" class="btn btn-danger border-none"> กลับไปยังคลังข้อสอบ </a>
         <a href="{{url('start_test2/'.$course_detail->Eid)}}" class="btn btn-success border-none">  ทำแบบฝึกหัดอีกครั้ง </a>
         <br /><br /><br />
      </div>



   </div>
</div {{$sum = 0}}>



@endsection

@section('scripts')
<script src="{{url('web_stream/js/jquery.steps.js')}}"></script>
<script src="{{url('web_stream/js/ClockTimer.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>





$("#example-basic").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    autoFocus: true
});








</script>

@stop('scripts')
