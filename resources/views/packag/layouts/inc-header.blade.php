<nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top">
         &nbsp;&nbsp;
         <button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">
         <i class="fas fa-bars"></i>
         </button> &nbsp;&nbsp;
         <a class="navbar-brand mr-1" href="{{url('japanonline')}}"><img class="img-fluid" alt="" src="{{url('web_stream/img/logo.png?v1')}}"></a>
         <!-- Navbar Search -->
         <form action="{{url('search/')}}" method="post" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search">
           {{ csrf_field() }}
            <div class="input-group">
               <input type="text" class="form-control" name="search" placeholder="Search for..." >
               <div class="input-group-append">
                  <button class="btn btn-light" type="button">
                  <i class="fas fa-search"></i>
                  </button>
               </div>
            </div>
         </form>
         <!-- Navbar -->
         <ul class="navbar-nav ml-auto ml-md-0 osahan-right-navbar">


           @if (Auth::guest())
           <li class="nav-item mx-1">
               <a class="nav-link btn btn-success border-none" href="{{url('info_package/1')}}" style="color:#fff;">
                ทดลองเรียนฟรี 7 วัน</a>


            </li>


           @else
            <li class="nav-item dropdown no-arrow mx-1">
               <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-envelope fa-fw"></i>
               <span class="badge badge-success" id="messages_count">0</span>
               </a>
               <div class="dropdown-menu dropdown-menu-right" id="messages" aria-labelledby="messagesDropdown">
                <!--  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-edit "></i> &nbsp; Action</a>
                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-headphones-alt "></i> &nbsp; Another action</a> -->

               </div>
            </li>

            <li class="nav-item dropdown no-arrow osahan-right-navbar-user">
               <a class="nav-link dropdown-toggle user-dropdown-link" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 @if(Auth::user()->provider == 'email')
                 <img alt="Avatar" src="{{url('assets/images/avatar/'.Auth::user()->avatar)}}">

                 @else
                 <img alt="Avatar" src="//{{Auth::user()->avatar}}">

                 @endif



               {{Auth::user()->name}}
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="{{url('my_package')}}"><i class="fas fa-fw fa-user-circle"></i> &nbsp; My Package</a>
                  <a class="dropdown-item" href="{{url('my_history')}}"><i class="fas fa-fw fa-history"></i> &nbsp; ประวัติการเติม</a>
                  <a class="dropdown-item" href="{{url('profile_user_package')}}"><i class="fas fa-fw fa-cog"></i> &nbsp; ข้อมูลส่วนตัว</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-fw fa-sign-out-alt"></i> &nbsp; ออกจากระบบ</a>
               </div>
            </li>
            @endif
         </ul>
      </nav>
