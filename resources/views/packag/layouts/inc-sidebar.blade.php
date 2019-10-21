<!-- Sidebar -->
        <ul class="sidebar navbar-nav">


          @if (Auth::guest())
          <li class="nav-item">
             <a class="nav-link" href="{{url('/')}}">
             <i class="fas fa-fw fa-home"></i>
             <span>Learnsbuy</span>
             </a>
          </li>

          <li class="nav-item {{ (Request::is('japanonline') ? 'active' : '') }} {{ (Request::is('info_package/*') ? 'active' : '') }} {{ (Request::is('submit_info_package') ? 'active' : '') }}">
             <a class="nav-link" href="{{url('japanonline')}}">
             <i class="fa fa-play-circle"></i>
             <span>Package รายเดือน</span>
             </a>
          </li>

           <li class="nav-item">
              <a class="nav-link" href="{{url('/japanonline/login')}}">
              <i class="fas fa-fw fa-user"></i>
              <span>เข้าสู่ระบบ</span>
              </a>
           </li>

           <li class="nav-item">
              <a class="nav-link" href="{{url('japanonline/register')}}">
              <i class="fa fa-lock"></i>
              <span>สมัครสมาชิก</span>
              </a>
           </li>

           <li class="nav-item {{ (Request::is('blog') ? 'active' : '') }} {{ (Request::is('blog_detail*') ? 'active' : '') }}">
              <a class="nav-link" href="{{url('blog')}}">
              <i class="fas fa-fw fa-folder"></i>
              <span>ข่าวสารอัพเดต</span>
              </a>
           </li>

           <li class="nav-item">
              <a class="nav-link" href="https://line.me/R/ti/p/%40za-shi" target="_blank">
              <i class="fas fa-fw fa-comment"></i>
              <span>สอบถาม</span>
              </a>
           </li>

           @else


           <li class="nav-item">
              <a class="nav-link" href="{{url('/')}}">
              <i class="fas fa-fw fa-home"></i>
              <span>Learnsbuy</span>
              </a>
           </li>

            <li class="nav-item {{ (Request::is('account') ? 'active' : '') }} {{ (Request::is('my_history') ? 'active' : '') }} {{ (Request::is('profile_user_package') ? 'active' : '') }} {{ (Request::is('my_example') ? 'active' : '') }}">
               <a class="nav-link" href="{{url('account')}}">
               <i class="fas fa-fw fa-user-circle"></i>
               <span>Account</span>
               </a>
            </li>



           <li class="nav-item {{ (Request::is('japanonline') ? 'active' : '') }} {{ (Request::is('info_package/*') ? 'active' : '') }} {{ (Request::is('submit_info_package') ? 'active' : '') }}">
              <a class="nav-link" href="{{url('japanonline')}}">
              <i class="fa fa-play-circle"></i>
              <span>Package รายเดือน</span>
              </a>
           </li>
           <li class="nav-item {{ (Request::is('channels') ? 'active' : '') }} {{ (Request::is('e_testing*') ? 'active' : '') }} {{ (Request::is('course_detail*') ? 'active' : '') }} {{ (Request::is('single_channel*') ? 'active' : '') }}  {{ (Request::is('single_channel') ? 'active' : '') }} {{ (Request::is('course_detail') ? 'active' : '') }} {{ (Request::is('e_testing') ? 'active' : '') }}">
               <a class="nav-link" href="{{url('channels')}}">
               <i class="fas fa-fw fa-users"></i>
               <span>Channels</span>
               </a>
            </li>
            <li class="nav-item {{ (Request::is('new_video') ? 'active' : '') }} ">
               <a class="nav-link" href="{{url('new_video')}}">
               <i class="fas fa-fw fa-video"></i>
               <span>วิดีโอใหม่</span>
               </a>
            </li>

            <li class="nav-item {{ (Request::is('all_e_testing') ? 'active' : '') }} {{ (Request::is('start_test2*') ? 'active' : '') }} {{ (Request::is('success_ans_package2*') ? 'active' : '') }}">
               <a class="nav-link" href="{{url('all_e_testing')}}">
               <i class="fa fa-briefcase"></i>
               <span>คลังข้อสอบ</span>
               </a>
            </li>

          <!--  <li class="nav-item {{ (Request::is('history_video') ? 'active' : '') }}">
               <a class="nav-link" href="{{url('history_video')}}">
               <i class="fas fa-fw fa-history"></i>
               <span>ประวัติการเข้าชม</span>
               </a> blog_detail
            </li> -->

            <li class="nav-item {{ (Request::is('blog') ? 'active' : '') }} {{ (Request::is('blog_detail*') ? 'active' : '') }}">
               <a class="nav-link" href="{{url('blog')}}">
               <i class="fas fa-fw fa-folder"></i>
               <span>ข่าวสารอัพเดต</span>
               </a>
            </li>

            @endif














        </ul>
