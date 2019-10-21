@extends('packag.layouts.template')

@section('stylesheet')

@stop('stylesheet')
@section('content')





<div class="video-block section-padding">
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
            <h6>ดูประวัติ</h6>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="video-card">
            <div class="video-card-image">
               <a class="video-close" href="#"><i class="fas fa-times-circle"></i></a>
               <a class="play-icon" href="{{url('play_video')}}"><i class="fas fa-play-circle"></i></a>
               <a href="{{url('play_video')}}"><img class="img-fluid" src="https://learnsbuy.com/assets/uploads/1537158008.png" alt=""></a>
               <div class="time">3:50</div>
            </div>
            <div class="video-card-body">
               <div class="video-title">
                  <a href="{{url('play_video')}}">ภาษาญี่ปุ่นพื้นฐาน 1</a>
               </div>
               <div class="video-page text-success">
                  ภาษาญี่ปุ่น  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
               </div>
               <div class="video-view">
                  1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="video-card">
            <div class="video-card-image">
              <a class="video-close" href="#"><i class="fas fa-times-circle"></i></a>
              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
               <a href="#"><img class="img-fluid" src="https://learnsbuy.com/assets/uploads/1560315124.png" alt=""></a>
               <div class="time">3:50</div>
            </div>
            <div class="video-card-body">
               <div class="video-title">
                  <a href="#">ภาษาเยอรมันพื้นฐาน 1</a>
               </div>
               <div class="video-page text-success">
                  ภาษาญี่ปุ่น  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
               </div>
               <div class="video-view">
                  1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="video-card">
            <div class="video-card-image">
              <a class="video-close" href="#"><i class="fas fa-times-circle"></i></a>
              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
               <a href="#"><img class="img-fluid" src="https://learnsbuy.com/assets/uploads/1537354061.png" alt=""></a>
               <div class="time">3:50</div>
            </div>
            <div class="video-card-body">
               <div class="video-title">
                  <a href="#">ภาษาญี่ปุ่นพื้นฐาน 1</a>
               </div>
               <div class="video-page text-success">
                  ภาษาญี่ปุ่น  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
               </div>
               <div class="video-view">
                  1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="video-card">
            <div class="video-card-image">
              <a class="video-close" href="#"><i class="fas fa-times-circle"></i></a>
              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
               <a href="#"><img class="img-fluid" src="https://learnsbuy.com/assets/uploads/1538986152.png" alt=""></a>
               <div class="time">3:50</div>
            </div>
            <div class="video-card-body">
               <div class="video-title">
                  <a href="#">ภาษาญี่ปุ่นพื้นฐาน 1</a>
               </div>
               <div class="video-page text-success">
                  ภาษาญี่ปุ่น  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
               </div>
               <div class="video-view">
                  1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="video-card">
            <div class="video-card-image">
              <a class="video-close" href="#"><i class="fas fa-times-circle"></i></a>
              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
               <a href="#"><img class="img-fluid" src="https://learnsbuy.com/assets/uploads/1538992130.png" alt=""></a>
               <div class="time">3:50</div>
            </div>
            <div class="video-card-body">
               <div class="video-title">
                  <a href="#">ภาษาญี่ปุ่นพื้นฐาน 1</a>
               </div>
               <div class="video-page text-success">
                  ภาษาญี่ปุ่น  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
               </div>
               <div class="video-view">
                  1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="video-card">
            <div class="video-card-image">
              <a class="video-close" href="#"><i class="fas fa-times-circle"></i></a>
              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
               <a href="#"><img class="img-fluid" src="https://learnsbuy.com/assets/uploads/1537662788.png" alt=""></a>
               <div class="time">3:50</div>
            </div>
            <div class="video-card-body">
               <div class="video-title">
                  <a href="#">ภาษาญี่ปุ่นพื้นฐาน 1</a>
               </div>
               <div class="video-page text-success">
                  ภาษาญี่ปุ่น  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
               </div>
               <div class="video-view">
                  1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="video-card">
            <div class="video-card-image">
              <a class="video-close" href="#"><i class="fas fa-times-circle"></i></a>
              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
               <a href="#"><img class="img-fluid" src="https://learnsbuy.com/assets/uploads/1537158008.png" alt=""></a>
               <div class="time">3:50</div>
            </div>
            <div class="video-card-body">
               <div class="video-title">
                  <a href="#">ภาษาญี่ปุ่นพื้นฐาน 1</a>
               </div>
               <div class="video-page text-success">
                  ภาษาญี่ปุ่น  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
               </div>
               <div class="video-view">
                  1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="video-card">
            <div class="video-card-image">
              <a class="video-close" href="#"><i class="fas fa-times-circle"></i></a>
              <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
               <a href="#"><img class="img-fluid" src="https://learnsbuy.com/assets/uploads/1559488816.png" alt=""></a>
               <div class="time">3:50</div>
            </div>
            <div class="video-card-body">
               <div class="video-title">
                  <a href="#">ภาษาญี่ปุ่นพื้นฐาน 1</a>
               </div>
               <div class="video-page text-success">
                  ภาษาญี่ปุ่น  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
               </div>
               <div class="video-view">
                  1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
               </div>
            </div>
         </div>
      </div>
   </div>
</div>




@endsection

@section('scripts')
@stop('scripts')
