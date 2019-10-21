@extends('packag.layouts.template')

@section('stylesheet')

@stop('stylesheet')
@section('content')





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
                            <h6>Packag รายเดือน</h6>
                         </div>
                      </div>

                      @if(isset($pack))
                        @foreach($pack as $u)

                      <div class="col-xl-3 col-sm-6 mb-3">
                         <div class="video-card">
                            <div class="video-card-image">

                               <a href="{{url('info_package/'.$u->id)}}"><img class="img-fluid" src="{{url('web_stream/img/package/'.$u->package_image)}}" alt="{{$u->package_name}}"></a>

                            </div>
                            <div class="video-card-body">
                               <div class="video-title">
                                  <a href="#">{{$u->package_name}}</a>
                               </div>
                               <div class="channels-card-image-btn">
                                 <a href="{{url('info_package/'.$u->id)}}" class="btn btn-success btn-sm border-none">สมัครเรียน</a>
                               </div>

                            </div>
                         </div>
                      </div>
                        @endforeach
                      @endif


                   </div>
                </div>



@endsection

@section('scripts')
@stop('scripts')
