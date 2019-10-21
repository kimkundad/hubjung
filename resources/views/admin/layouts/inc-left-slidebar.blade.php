<style>

ul.nav-main > li.nav-expanded > a {
  box-shadow: 2px 0 0 #32d191  inset;
}
html.no-overflowscrolling .nano > .nano-pane > .nano-slider {
    background: #ee413c;
}
.page-header h2 {
    border-bottom-color: #ee413c;
}
</style>
<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">

					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar" ></i>
						</div>
					</div>

					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li {{ (Request::is('admin/dashboard*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/dashboard/')}}"  >
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>ส่วนควบคุม</span>
										</a>
									</li>
								<!--	<li {{ (Request::is('admin/user*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/user/')}}" >
											<i class="fa fa-male" aria-hidden="true"></i>
											<span>รายชื่อผู้ใช้ทั้งหมด</span>
										</a>
									</li> -->

									<li {{ (Request::is('admin/student*') ? 'class=nav-expanded' : '') }} {{ (Request::is('admin/search_student*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/student/')}}" >
											<i class="fa fa-graduation-cap " aria-hidden="true"></i>
											<span>รายชื่อนักเรียน</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/package_product*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/package_product/')}}" >
											<i class="fa fa-video-camera" aria-hidden="true"></i>
											<span>Package รายเดือน</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/order_package*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/order_package/')}}" >
											<i class="fa fa-external-link" aria-hidden="true"></i>
											<span>สั่งซื้อ Package ใหม่</span>
										</a>
									</li>


                  <li {{ (Request::is('admin/set_video*') ? 'class=nav-expanded' : '') }} {{ (Request::is('admin/search_list_video*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/set_video/')}}" >
											<i class="fa fa-play-circle" aria-hidden="true"></i>
											<span>จัดการ Video ทั้งหมด</span>
										</a>
									</li>

                



									<li {{ (Request::is('admin/course*') ? 'class=nav-expanded' : '') }}
                  {{ (Request::is('video_course_edit*') ? 'class=nav-expanded' : '') }}
                  {{ (Request::is('admin/typecourse*') ? 'class=nav-expanded' : '') }}
                  {{ (Request::is('admin/examination/*') ? 'class=nav-expanded' : '') }}
                  {{ (Request::is('admin/category*') ? 'class=nav-expanded' : '') }}>
										<a href="{{url('admin/course/')}}" >
											<i class="fa fa-cube" aria-hidden="true"></i>
											<span>คอร์สเรียน</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/department*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/department/')}}" >
											<i class="fa fa-flag" aria-hidden="true"></i>
											<span>ภาควิชา</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/card_money*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/card_money/')}}" >
											<i class="fa fa-credit-card" aria-hidden="true"></i>
											<span>บัตรเติมเงิน</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/wallet*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/wallet/')}}" >
											<i class="fa fa-credit-card-alt" aria-hidden="true"></i>
											<span>คำสั่งซื้อบัตรเติมเงิน</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/order_shop*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/order_shop/')}}" >
											<i class="fa fa-external-link" aria-hidden="true"></i>
											<span>รายการสั่งซื้อใหม่</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/play_student*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/play_student/')}}" >
											<i class="fa fa-address-book-o" aria-hidden="true"></i>
											<span>คอร์ส-นักเรียน</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/coupon*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/coupon/')}}"  >
											<i class="fa fa-usd" aria-hidden="true"></i>
											<span>Coupon</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/free_course*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/free_course/')}}" >
											<i class="fa fa-paw" aria-hidden="true"></i>
											<span>สมัครเรียนฟรี</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/inbox*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/inbox/')}}" >
											<i class="fa fa-envelope" aria-hidden="true"></i>
											<span>Inbox</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/bank*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/bank/')}}" >
											<i class="fa fa-bank" aria-hidden="true"></i>
											<span>ธนาคาร</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/slide*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/slide/')}}"  >
											<i class="fa fa-camera" aria-hidden="true"></i>
											<span>Slide Show</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/blog*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/blog/')}}" >
											<i class="fa fa-code" aria-hidden="true"></i>
											<span>ข่าวสาร</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/example*') ? 'class=nav-expanded' : '') }}>
										<a href="{{url('admin/example/')}}" >
											<i class="fa fa-question-circle" aria-hidden="true"></i>
											<span>แบบฝึกหัด</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/example_admin*') ? 'class=nav-expanded' : '') }}>
										<a href="{{url('admin/example_admin/')}}" >
											<i class="fa fa-bug" aria-hidden="true"></i>
											<span>ตรวจแบบฝึกหัด</span>
										</a>
									</li>

									<li {{ (Request::is('admin/setting*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/setting')}}" >
											<i class="fa fa-cog " aria-hidden="true"></i>
											<span>ตั้งค่า</span>
										</a>
									</li>

                  <li {{ (Request::is('admin/logsys*') ? 'class=nav-expanded' : '') }} >
										<a href="{{url('admin/logsys')}}" >
											<i class="fa fa-align-left" aria-hidden="true"></i>
											<span>Log system</span>
										</a>
									</li>

								</ul>



							</nav>



							<hr class="separator" />


						</div>

					</div>

				</aside>
				<!-- end: sidebar -->
