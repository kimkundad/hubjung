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
                          <h6>Popular Channels</h6>
                       </div>
                    </div>

                    @if(isset($depart))
                    @foreach($depart as $u)
                    <div class="col-xl-3 col-sm-6 mb-3">
                       <div class="channels-card">
                          <div class="channels-card-image">
                             <a href="{{url('single_channel/'.$u->id)}}"><img class="img-fluid" src="{{url('assets/image/department/'.$u->image)}}" alt=""></a>
                             <div class="channels-card-image-btn"><button type="button" class="btn btn-outline-danger btn-sm">Subscribe </button></div>
                          </div>
                          <div class="channels-card-body">
                             <div class="channels-title">
                                <a href="{{url('single_channel/'.$u->id)}}">คอร์ส ภาษา{{$u->name_department}}</a>
                             </div>
                             <div class="channels-view">
                               @if($u->get_count_video != null)
                               {{$u->get_count_video}} video
                               @else
                               &nbsp
                               @endif

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
