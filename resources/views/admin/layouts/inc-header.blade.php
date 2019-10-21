<div class="header-right">
  <audio id="notif_audio"><source src="{!! asset('sounds/notify.ogg') !!}" type="audio/ogg"><source src="{!! asset('sounds/notify.mp3') !!}" type="audio/mpeg"><source src="{!! asset('sounds/notify.wav') !!}" type="audio/wav"></audio>


  <ul class="notifications">
    <li class="">
          <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-tasks"></i>
            <span class="badge">{{$course_message}}</span>
          </a>


          <div class="dropdown-menu notification-menu">
            <div class="notification-title">

              คำสั่งซื้อใหม่
            </div>

            <div class="content">
              <ul id="messages_notis">

                <li>
                  <a href="{{url('admin/order_shop')}}" class="clearfix">
                    <figure class="image">
                    </figure>
                    <span class="title">รายการสั่งซื้อใหม่</span>
                    <span class="message">นักเรียนได้ทำรายการสั่งซื้อคอร์ส</span>
                  </a>
                </li>

              </ul>



            <!-- <hr>  <div class="text-right">
                 <a href="#" class="view-more">View All</a>
              </div> -->
            </div>
          </div>



        </li>
<li class="">
  <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown" aria-expanded="true">
    <i class="fa fa-envelope"></i>
    <span class="badge" id="new_count_message">{{$count_message}}</span>
  </a>

  <div class="dropdown-menu notification-menu">
    <div class="notification-title">

      ข้อความใหม่
    </div>

    <div class="content">
      <ul id="messages_noti">

        @if(isset($message_user))
          @foreach($message_user as $message_users)
        <li>
          <a href="{{url('admin/inbox_chat/'.$message_users->chat_user_id)}}" class="clearfix">
            <figure class="image">

              @if($message_users->provider == 'email')
              <img src="{{url('assets/images/avatar/'.$message_users->avatar)}}" class="img-circle" style="width:35px; height35px">
              @else
              <img src="//{{$message_users->avatar}}" class="img-circle" style="width:35px; height35px">
              @endif



            </figure>
            <span class="title">{{$message_users->name}}</span>
            <span class="message">มีข้อความมาใหม่ถึงคุณ</span>
          </a>
        </li>
          @endforeach
        @endif

      </ul>



    <!-- <hr>  <div class="text-right">
         <a href="#" class="view-more">View All</a>
      </div> -->
    </div>
  </div>
</li>

</ul>




                    <span class="separator"></span>
                  @if (Auth::guest())
              @else
                    <div id="userbox" class="userbox">
                        <a href="#" data-toggle="dropdown">
                            <figure class="profile-picture">
                              @if(Auth::user()->avatar != NULL)
                                <img src="{{url('./assets/images/avatar/'.Auth::user()->avatar)}}" width="35" height="35"  class="img-circle" data-lock-picture="{{asset('./assets/images/avatar/'.Auth::user()->image)}}" />
                              @else
                              <img src="{{asset('./assets/images/avatar/blank_avatar_240x240.gif')}}" width="35" height="35"  class="img-circle" data-lock-picture="{{asset('./assets/images/avatar/blank_avatar_240x240.gif')}}" />
                              @endif
                            </figure>
                            <div class="profile-info" data-lock-name="{{ Auth::user()->name }}" >
                                <span class="name">{{ Auth::user()->name }}</span>
                                <span class="role"></span>
                            </div>

                            <i class="fa custom-caret"></i>
                        </a>

                        <div class="dropdown-menu">
                            <ul class="list-unstyled">
                                <li class="divider"></li>
                              <!--  <li>
                                    <a role="menuitem" tabindex="-1" href="{{url('admin/profile/')}}" ><i class="fa fa-user"></i> ข้อมูลส่วนตัว</a>
                                </li> -->
                                <li>
                                    <a role="menuitem" tabindex="-1" href="{{url('logout')}}" ><i class="fa fa-power-off"></i> ออกจากระบบ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
@endif


                </div>
