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


                           <h6>{{$blog->title_blog}}</h6>
                        </div>
                     </div>
               <div class="col-md-8">
                  <div class="card blog mb-4">
                     <div class="blog-header">
                        <a href="#"><img class="card-img-top" src="{{url('assets/blog/'.$blog->image)}}" alt="{{$blog->title_blog}}"></a>
                     </div>
                     <div class="card-body">
                        <h5 class="card-title"><a href="#">{{$blog->title_blog}}</a></h5>
                        <div class="entry-meta">
                           <ul class="tag-info list-inline">
                              <li class="list-inline-item"><a href="#"><i class="fas fa-calendar"></i>   <?php echo DateThai($blog->created_at); ?></a></li>

                              <li class="list-inline-item"><i class="fas fa-eye"></i> {{number_format($blog->view)}} </li>
                              <li class="list-inline-item"><i class="fas fa-comment"></i> <a href="#">{{$count_blog}} Comments</a></li>
                           </ul>
                        </div>


                        <p>
                          {!! $blog->detail_blog_website !!}
                        </p>



                        <footer class="entry-footer">
                           <div class="blog-post-tags">
                              <ul class="list-inline">
                                <li class="list-inline-item"><i class="fas fa-tag"></i> Tags: </li>
                                @if(isset($get_tags_s))
                                  @foreach($get_tags_s as $u)
                                  @if($u != null)

                                 <li class="list-inline-item"><a rel="tag" href="#">{{$u}}</a> </li>
                                 @endif
                                  @endforeach
                                 @endif


                              </ul>
                           </div>
                        </footer>
                     </div>
                  </div>
                  <div class="card padding-card reviews-card mb-4">
                     <div class="card-body">
                        <h5 class="card-title mb-4">{{$count_blog}} Reviews</h5>

                        @if(isset($get_comment))
                          @foreach($get_comment as $u)
                        <div class="media mb-4">

                          @if($u->provider == 'email')
                          <img alt="Avatar" src="{{url('assets/images/avatar/'.$u->avatar)}}" class="d-flex mr-3 rounded">

                          @else
                          <img alt="Avatar" src="//{{$u->avatar}}" class="d-flex mr-3 rounded">

                          @endif


                          
                           <div class="media-body">
                              <h5 class="mt-0">{{$u->name}}, <small><?php echo DateThai($u->created_ats); ?></small>
                                @if(Auth::user()->id == $u->u_id)
                                <a href="#" data-toggle="modal" data-target="#modalBasic-{{$u->id_com}}"><span class="star-rating float-right">
                                 <i class="fa fa-cog "></i>
                                 </span></a>

                                 <div class="modal" id="modalBasic-{{$u->id_com}}">

                                   <div class="modal-dialog">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h6 class="modal-title">แก้ไข comment นักเรียน</h6>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                      <form action="{{url('/edit_comment_user/')}}" method="post" enctype="multipart/form-data"  name="product">
                                      <!-- Modal body -->
                                      <div class="modal-body">


                                          {{ csrf_field() }}

                                           <div class="control-group form-group">
                                              <div class="controls">

                                                 <input class="form-control border-form-control" value="{{$blog->id}}" name="blog_id" type="hidden">
                                                 <input class="form-control border-form-control" value="{{$u->id_com}}" name="comment_id" type="hidden">
                                                 <textarea class="form-control" name="comment" cols="100" rows="6">{{$u->comment}}</textarea>
                                              </div>
                                           </div>


                                      </div>

                                      <!-- Modal footer -->
                                      <div class="modal-footer">
                                        <a href="{{url('/del_comment/'.$u->id_com)}}" class="btn btn-danger pull-left" >ลบ comment</a>

                                        <button class="btn btn-success" type="submit">อัพเดท comment</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                                      </div>
                                      </form>
                                    </div>
                                  </div>

               									</div>

                                 @endif
                              </h5>
                              <p>
                                {{$u->comment}}
                              </p>
                           </div>
                        </div>
                          @endforeach
                        @endif




                     </div>
                  </div>
                  <div class="card blog">
                     <div class="card-body">
                        <h5 class="card-title mb-4">Leave a Comment</h5>
                        <form action="{{url('/post_comment_user/')}}" method="post" enctype="multipart/form-data" onSubmit="return checkemail()" name="product">

                          {{ csrf_field() }}

                           <div class="control-group form-group">
                              <div class="controls">
                                 <label>Review <span class="text-danger">*</span></label>
                                 <input class="form-control border-form-control" value="{{$blog->id}}" name="blog_id" type="hidden">
                                 <textarea class="form-control" name="comment" cols="100" rows="8"></textarea>
                              </div>
                           </div>
                           <button class="btn btn-success" type="submit">Post Comment</button>
                        </form>

                     </div>
                  </div>
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
@if ($message = Session::get('success'))
  swal("สำเร็จ!", "ทำการอัพเดทข้อมูลสำเร็จ!", "success");
@endif
</script>
@stop('scripts')
