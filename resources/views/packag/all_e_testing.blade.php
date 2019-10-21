@extends('packag.layouts.template')

@section('stylesheet')

@stop('stylesheet')
@section('content')


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


<div class="video-block section-padding pb-50">
   <div class="row">
      <div class="col-md-12">
         <div class="main-title">
            <div class="btn-group float-right right-action">
               <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
               </a>
               <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
               </div>
            </div>
            <h6>คลังข้อสอบ</h6>
         </div>
      </div>


      <div class="col-md-12">

        <div class="table-responsive">
         <table class="table">
           <thead>
             <tr>
               <th scope="col">ข้อสอบ</th>
               <th scope="col">หมวดหมู่</th>
               <th scope="col">คอร์ส</th>
               <th scope="col">จำนวนข้อ</th>
               <th scope="col"></th>
             </tr>
           </thead>
           <tbody>
             @if(isset($objs))
              @foreach($objs as $u)
              <tr>
                <th scope="row">{{$u->examples_name}}</th>
                <td>{{$u->name_category}}</td>
                <td>{{$u->title_course}}</td>
                <td>{{$u->options}}</td>
                <td class="text-right"><a class="btn btn-outline-success btn-sm" href="{{url('start_test2/'.$u->e_id)}}">เริ่มทำข้อสอบ</a></td>
              </tr>
                @endforeach
              @endif

            </tbody>
         </table>
        </div>
      </div>



   </div>
</div>



@endsection

@section('scripts')
@stop('scripts')
