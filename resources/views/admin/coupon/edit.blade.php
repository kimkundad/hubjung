@extends('admin.layouts.template')





@section('admin.content')






        <section role="main" class="content-body">

          <header class="page-header">
            <h2>{{$datahead}}</h2>

            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="{{url('admin/dashboard')}}">
                    <i class="fa fa-home"></i>
                  </a>
                </li>

                <li><span>{{$datahead}}</span></li>
              </ol>

              <a class="sidebar-right-toggle" data-open="sidebar-right" ><i class="fa fa-chevron-left"></i></a>
            </div>
          </header>

          <!-- start: page -->

          <div class="row">
          							<div class="col-md-2 col-lg-2">

          							</div>


                        <div class="col-md-8 col-lg-8">

          							<div class="tabs">

          								<div class="tab-content">

          									<div id="edit" class="tab-pane active">


                              <form  method="POST" action="{{$url}}" enctype="multipart/form-data">
                                          {{ method_field($method) }}
                                          {{ csrf_field() }}

          											<h4 class="mb-xlg">แก้ไข Coupon</h4>

          											<fieldset>
                                  <div class="form-group">
          													<label class="col-md-3 control-label" for="profileFirstName">Coupon Code*</label>
          													<div class="col-md-8">
          														<input type="text" class="form-control" name="c_code" value="{{$objs->c_code}}">
          														</div>
          												</div>

                                  <div class="form-group">
          													<label class="col-md-3 control-label" for="profileFirstName">จำนวนของ Coupon*</label>
          													<div class="col-md-8">
          														<input type="text" class="form-control" name="c_max" value="{{$objs->c_max}}">
          														</div>
          												</div>

                                  <div class="form-group">
          													<label class="col-md-3 control-label" for="profileFirstName">ส่วนลด Coupon*</label>
          													<div class="col-md-8">
          														<input type="text" class="form-control" name="c_price" value="{{$objs->c_price}}">
          														</div>
          												</div>


                                  <div class="form-group">
          													<label class="col-md-3 control-label" for="profileFirstName">ชนิดของคูปอง*</label>
          													<div class="col-md-8">

                                      <select name="c_type" class="form-control mb-md" required>

                                        <option value="0" @if( $objs->c_type == 0)
                                              selected='selected'
                                              @endif>-- ส่วนลดเป็นบาท --</option>
  								                      <option value="1" @if( $objs->c_type == 1)
                                              selected='selected'
                                              @endif>-- ส่วนลดเป็นเปอร์เซ็นต์ --</option>
  								                    </select>


          														</div>
          												</div>

                                  <div class="form-group">
          													<label class="col-md-3 control-label" for="profileFirstName">คูปองใช้กับ Course*</label>
          													<div class="col-md-8">

                                      <select name="c_price_product" class="form-control mb-md" required>

                                        <option value="0" @if( $objs->c_price_product == 0)
                                              selected='selected'
                                              @endif >-- ใช้กับทุก Course --</option>
                                          @foreach($courses as $course)
                                             <option value="{{$course->id}}" @if( $objs->c_price_product == $course->id)
                                                   selected='selected'
                                                   @endif
                                                   >{{$course->title_course}}</option>
                                          @endforeach
                                      </select>

          														</div>
          												</div>



                                  <br>

          											</fieldset>







          											<div class="panel-footer">
          												<div class="row">
          													<div class="col-md-9 col-md-offset-3">
          														<button type="submit" class="btn btn-primary">แก้ไขข้อมูล</button>
          														<button type="reset" class="btn btn-default">ยกเลิก</button>
          													</div>
          												</div>
          											</div>

          										</form>

          									</div>
          								</div>
          							</div>
          						</div>









          						</div>

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









                      <div class="row">
                      <div class="col-xs-12">

                    <section class="panel">


                      <div class="panel-body">




                        <table class="table table-bordered table-striped mb-0" id="datatable-default">
                          <thead>
                            <tr>
                              <th>
                                #
                              </th>
                              <th>นักเรียน</th>
                              <th>คอร์ส</th>

                              <th>เวลา</th>
                              <th>วันที่โอน</th>
                              <th>สั่งซื้อวันที่</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if($coursess)
                        @foreach($coursess as $u)
                            @if($u->get_order != null)
                            <tr>
                              <td>
                                {{$u->get_order->Oid}}
                              </td>
                              <td><a href="{{url('admin/student/'.$u->get_order->Ustudent.'/edit')}}" target="_blank">{{$u->get_order->name}}</a></td>
                              <td><a href="{{url('admin/course/'.$u->get_order->Ucourse.'/edit')}}" target="_blank">{{$u->get_order->title_course}}</a></td>

                              <td>{{$u->get_order->hrcourse}}</td>
                              <td>{{$u->get_order->date_tran}}</td>
                              <td>{{$u->get_order->Dcre}}</td>


                              <td>

                                @if($u->get_order->status == 1)
                                      <b class="text-danger">ยังไม่อนุมัติ</b>
                                    @else
                                    <b class="text-success">อนุมัติแล้ว</b>
                                    @endif




                                <a style="float:left; margin-right:4px;" target="_blank" class="btn btn-primary btn-xs" href="{{url('admin/play_student/'.$u->get_order->Oid.'/edit')}}"
                                  role="button"><i class="fa fa-wrench"></i> </a>



                              </td>


                              </tr>
                              @else
                              <tr>
                              <td>
                                  {{$u->order_id}}
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              </tr>
                              @endif
                               @endforeach
                      @endif

                          </tbody>
                        </table>
                      </div>
                    </section>

                      </div>
                    </div>




</section>
@stop



@section('scripts')
<script src="{{asset('/assets/javascripts/tables/examples.datatables.default.js')}}"></script>


@if ($message = Session::get('edit_success'))
<script type="text/javascript">

  var stack_topleft = {"dir1": "down", "dir2": "right", "push": "top"};
      var notice = new PNotify({
            title: 'ทำรายการสำเร็จ',
            text: 'ยินดีด้วย ได้ทำการแก้ไขข้อมูล สำเร็จเรียบร้อยแล้วค่ะ',
            type: 'success',
            addclass: 'stack-topright'
          });
</script>
@endif

@stop('scripts')
