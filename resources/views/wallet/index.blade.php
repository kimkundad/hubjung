
@extends('layouts.app')
@section('stylesheet')
<link href="{{url('assets/css/select-project.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('assets/css/confirm.css')}}" rel="stylesheet" type="text/css" />
@stop('stylesheet')
@section('content')
<style>
.sm-top {
    margin-top: 20px;
}
.text-primary {
    color: #1abc9c;
}
small, .small {
    font-size: 83%;
    line-height: 2.067;
}
</style>
<div class="container" >
    <div class="row">
        <div class="col-md-12 " >
          <h3 style="    color: #34495e;">Learnsbuy Wallet</h3>
          <p style="    color: #34495e;">เมื่อเข้าสู่ระบบแล้วเติมเงิน จำนวน Coin ที่ได้สามารถนำไปดู Video ที่สั่งซื้อได้ทุกคอร์ส</p>
          <hr>
          <div class="body-project">

                    <div class="row">

                      @if(isset($objs))
                      @foreach($objs as $obj)

                      <div class="col-sm-4 col-md-3">


                        <div class="well text-center">
                          <img class="img-responsive block-center" src="{{url('assets/uploads/'.$obj->image_card)}}" alt="{{$obj->name_card}}">
                          <p class="sm-top">
                          {{$obj->name_card}} <br>
                          ราคา:
                          <span class="tooltips text-dotted">
                          {{$obj->money_card_sum}}
                          </span>
                          coin:
                          <span class="tooltips text-dotted">
                          {{$obj->card_point}}
                          </span>
                          </p>
                          <div class="text-center">
                          <div class="text-primary">
                          <i class="fa fa-check"></i> พร้อมจำหน่าย
                          </div>
                          @if (Auth::guest())
                          <small>(เข้าสู่ระบบเพื่อซื้อ)</small>
                          @else
                          <a href="{{url('/get_wallet/'.$obj->id)}}" class="btn btn-info btn-sm btn-embossed mrs" rel="nofollow">กดสั่งซื้อ coin</a>
                          @endif

                          </div>
                          </div>


                          </div>

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
