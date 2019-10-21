@extends('layouts.app')
@section('content')
<style>
body{
      background-color: #f5f5f5;
}
.ui.button {
  width: 100%;
  text-decoration: none;
    cursor: pointer;
    display: inline-block;
    min-height: 1em;
    outline: 0;
    border: none;
    background: #e0e1e2;
    color: #fff;
    margin: 0 .25em 0 0;
    padding: .78571429em 1.5em;
    text-shadow: none;
    font-weight: 700;
    line-height: 1em;
    font-style: normal;
    text-align: center;
    border-radius: .28571429rem;
    user-select: none;
    -webkit-transition: opacity .1s ease,background-color .1s ease,color .1s ease,box-shadow .1s ease,background .1s ease;
    transition: opacity .1s ease,background-color .1s ease,color .1s ease,box-shadow .1s ease,background .1s ease;
    will-change: '';
}
.ui.facebook.button {
    background-color: #3b5998;
    text-shadow: none;
}
.ui.facebook.button:hover {
    background-color: #334d84;
    text-shadow: none;
}
.ui.facebook.button, .ui.google.plus.button, .ui.instagram.button, .ui.pinterest.button, .ui.twitter.button, .ui.vk.button, .ui.youtube.button {
    background-image: none;
    box-shadow: 0 0 0 0 rgba(34,36,38,.15) inset;
    color: #fff;
}
.panel-default>.panel-heading {
    background-image: url({{url('assets/image/login_bg.png')}});

}
.panel-heading {
    padding: 5px 5px;
}
.login_box {

    margin: 56px auto;
    padding: 15px 15px 0;
}
.t_mid {
    text-align: center;
}
.g_right {
  margin-top: -5px;
    float: right;
}
.logo-login{
      margin: 0 auto 20px auto;
}
.t_gray {

    color: #9e9e9e;
}
.login_box .sign_up_btn, .login_box .login_btn {
    background-color: #fff;
    color: #424242;
    padding: 10px 25px;
}
.ap-questions-featured {
    margin-left: -10px;
    border: medium none;
    color: #ff951e;
    display: inline;
    font-size: 16px;
    height: auto;
    margin-right: 5px;
    padding: 0;
    position: static;
    vertical-align: baseline;
    width: auto;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 ">
            <div class="panel panel-default login_box">

                <div class="panel-body">


                  <div class="ap-profile-box clearfix" >

                    <h3 class="ap-user-page-title clearfix" style="font-size: 20px; color: #a94442; border:none;  margin-bottom: 5px;">อันดับนักเรียนยอดเยี่ยม </h3>

                    <div class="table-responsive">

                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>ชื่อนักเรียน</th>
                            <th>คะแนนทำข้อสอบ</th>
                          </tr>
                        </thead>
                        <tbody>

                          @if($ranking != NULL)
                          @foreach($ranking as $uu)
                          <tr class="{{$s1++}}">
                            <td style="display: table-cell;">{{$s1}}</td>
                            <td scope="row"><a href="{{url('friend_reps/'.$uu->id)}}">  @if($uu->provider == 'email')
                              <img data-view="user_avatar_1980" alt="" src="{{url('assets/images/avatar/'.$uu->avatar)}}"
                              class="avatar avatar-40 photo" width="40" height="40" data-pin-nopin="true">
                              @else
                              <img data-view="user_avatar_1980" alt="" src="//{{$uu->avatar}}"
                              class="avatar avatar-40 photo" width="40" height="40" data-pin-nopin="true">
                              @endif

                              {{$uu->name}}</a></td>
                              @foreach($uu->options as $u)
                              <td><span class="ap-user-reputation"><i class="ap-questions-featured fa fa-trophy" style="margin-left:8px;"></i> Level.
                                @if($u->id != null)

                                  @if($u->id > 1)
                                  {{$u->id+1}}
                                  @else
                                  1
                                  @endif

                                @else
                                1
                                @endif
                              </span> / {{$uu->point_level}} Point</td>
                              @endforeach
                          </tr>
                            @endforeach
                          @endif

                             </tbody>
                      </table>

                    </div>

                    <div class="text-center">
                     <div class="pagination"> {{$ranking->links()}} </div>
                    </div>



                  </div>




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
