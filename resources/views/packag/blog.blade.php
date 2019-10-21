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


<section class="blog-page section-padding">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                        <div class="main-title">
                           <div class="btn-group float-right right-action">
                              <a aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" class="right-action-link text-gray" href="#">
                              Sort by <i aria-hidden="true" class="fa fa-caret-down"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                 <a href="#" class="dropdown-item"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                 <a href="#" class="dropdown-item"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                 <a href="#" class="dropdown-item"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                              </div>
                           </div>
                           <h6>บทความ / ข่าวสาร</h6>
                        </div>
                     </div>
               <div class="col-md-8">

                 @if(isset($blog))
                  @foreach($blog as $u)
                  <div class="card blog mb-4">
                     <div class="blog-header">
                        <a href="{{url('blog_detail/'.$u->id)}}"><img class="card-img-top" src="{{url('assets/blog/'.$u->image)}}" alt="{{$u->title_blog}}"></a>
                     </div>
                     <div class="card-body">
                        <h5 class="card-title"><a href="{{url('blog_detail/'.$u->id)}}">{{$u->title_blog}}</a></h5>
                        <div class="entry-meta">
                           <ul class="tag-info list-inline">
                              <li class="list-inline-item"><a href="#"><i class="fas fa-calendar"></i>   <?php echo DateThai($u->created_at); ?></a></li>

                              <li class="list-inline-item"><i class="fas fa-eye"></i> {{number_format($u->view)}} </li>
                              <li class="list-inline-item"><i class="fas fa-comment"></i> <a href="#">{{$u->count_comment}} Comments</a></li>
                           </ul>
                        </div>
                        <p class="card-text">{{$u->detail_blog}}
                        </p>
                        <a href="{{url('blog_detail/'.$u->id)}}">อ่านต่อ <span class="fas fa-chevron-right"></span></a>
                     </div>
                  </div>
                    @endforeach
                  @endif




                @include('pagination.default', ['paginator' => $blog])

                <br />

               </div>
               <div class="col-md-4">
                  <div class="card sidebar-card mb-4">
                     <div class="card-body">
                        <div class="input-group">
                           <input type="text" placeholder="Search For" class="form-control">
                           <div class="input-group-append">
                              <button type="button" class="btn btn-secondary">Search <i class="fas fa-arrow-right"></i></button>
                           </div>
                        </div>
                     </div>
                  </div>




                  <div class="card sidebar-card mb-4">
                     <div class="card-body">
                        <h5 class="card-title mb-3">Tags</h5>
                        <div class="tagcloud">
                          @if(isset($get_tags))
                            @foreach($get_tags as $u)
                            @if($u != null)
                           <a class="tag-cloud-link" href="#">{{$u}}</a>
                           @endif
                            @endforeach
                           @endif
                        </div>
                     </div>
                  </div>



               </div>
            </div>
         </div>
      </section>




@endsection

@section('scripts')




@stop('scripts')
