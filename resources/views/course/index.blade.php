
@extends('layouts.app')
@section('stylesheet')
<link href="{{url('assets/css/select-project.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/css/confirm.css')}}" rel="stylesheet" type="text/css" />
@stop('stylesheet')
@section('content')

<style>
.show {
  display: block;
}
.filterDiv {

  display: none; /* Hidden by default */
}
</style>


<div class="container" >
    <div class="row">
        <div class="col-md-12 " >
          <h3>คอร์สเรียนออนไลน์ทั้งหมด</h3>
          <hr>

          <div id="myBtnContainer">
            <button class="btn btn-default active" onclick="filterSelection('all')" style="font-size: 12px;height: 35px;"> Show all</button>
            @if(isset($get_cat))
						@foreach($get_cat as $k)
            <button class="btn btn-default" onclick="filterSelection('{{$k->name_department}}')" style="font-size: 12px;"><img src="{{url('assets/image/department/'.$k->image)}}" height="22"> {{$k->name_department}}</button>
            @endforeach
						@endif

          </div>


          <div class="body-project">

                    <div class="row">

                  @if(isset($objs))
                  @foreach($objs as $obj)
                  @if($obj->set_type_c == 0)
                  <div class="col-xs-6 col-md-3 filterDiv {{$obj->name_department}}">
                        <div class="thumbnail">
                          <a href="{{url('/courseinfo/'.$obj->A)}}">
                          <img src="{{url('assets/uploads/'.$obj->image_course)}}" >
                          </a>
                          <div class="caption" style="padding: 3px;">
                            <div class="descript bold">
                                <a href="{{url('/courseinfo/'.$obj->A)}}" data-dismiss="modal" data-toggle="modal" data-target="#show_detail54"> {{$obj->title_course}}</a>
                            </div>
                            <div class="descript" style="border-bottom: 1px dashed #999;">
                                {{$obj->type_name}} เรียน {{$obj->day_course}}, {{$obj->time_course}}
                            </div>

                            <div class="descript" style="height: 20px;">
                              <div class="descript-t">
                              <div class="postMetaInline-authorLockup">
                                <div >
                                  <span class="readingPrice">
                                <span class="text-primary hidden-sm hidden-xs">{{$obj->code_course}},</span> ฿ @if($obj->price_course == 0)
                                    Free Course
                                                            @else
                                                      {{$obj->price_course}}  บาท
                                                            @endif
                                  </span>
                                </div>
                              </div>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                      @endif
                  @endforeach
                  @endif


                    </div>

          </div>



        <!--    <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Your Application's Landing Page.
                </div>
            </div> -->



        </div>
    </div>
</div>
@endsection


@section('scripts')


<script>
filterSelection("all")
function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("filterDiv");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
  }
}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);
    }
  }
  element.className = arr1.join(" ");
}

// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("btn");

</script>
@stop('scripts')
