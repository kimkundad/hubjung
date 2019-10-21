<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT');
header("Access-Control-Allow-Headers: Authorization, X-Requested-With,  Content-Type, Accept");

Route::get('/', 'HomeController@home');




Route::get('test/', 'HomeController@home_test');

Route::get('/course', 'HomeController@course');
Route::get('/course_teaching', 'HomeController@Teaching');
Route::get('/course_free', 'HomeController@course_free');

Route::get('/wallet', 'WalletController@index');

Route::get('/courseinfo/{id}', 'CourseinfoController@show');

Route::get('/download_file_course/{id}', 'CourseinfoController@download_file_course');

// Password Reset Routes
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');


Route::get('/password/reset_m', function () {
    return view('auth.passwords.email_m');
});

Route::get('contact_m', 'ContactController@contact_m');

Route::post('/contact_m_p', 'ContactController@contact_m_p');

Route::resource('/contact', 'ContactController');

Route::get('/contact_success', function () {
    return view('contact.contact_success');
});

Route::get('/contact_success_m', function () {
    return view('mobile.contact_success_m');
});

Route::get('/privacy_policy', function () {
    return view('mobile.privacy_policy');
});

Route::get('/privacypolicy', function () {
    return view('privacypolicy.index');
});

Route::get('/terms', function () {
    return view('terms.index');
});


Route::get('/map_m', function () {
    return view('mobile.map_m');
});

Route::get('/rules', function () {
    return view('mobile.rules');
});



Route::get('/user_reps', 'NewsController@user_reps');
Route::get('friend_reps/{id}', 'NewsController@friend_reps');

Route::get('/news', 'NewsController@index');
Route::get('/news/{id}', 'NewsController@show');



Route::get('/about', function () {
    return view('about.index');
});

Route::get('/about/mobile', function () {
    return view('mobile.about_m');
});

Route::get('/live', function () {
    return view('live.index');
});



Route::auth();

Route::group(['middleware' => 'web'], function() {
Route::post('login', function()
{
    $credentials = Input::only('email', 'password');

    if ( ! Auth::attempt($credentials))
    {
        return Redirect::back()->withMessage('Invalid credentials');
    }

    if (Auth::user()->is_admin == 1)
    {
        return Redirect::to('/admin/dashboard');
    }else{

      if(Session::get('japanonline_redirect') == 1){
        Session::put('japanonline_redirect', 0);
        return redirect('/account');
      }else{
        return redirect('/');
      }

    }

    return Redirect::to('/');
});

});

Route::get('/home', 'HomeController@index');

Route::get('/email', function () {
    return view('mails.index');
});
Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');
Route::post('add_video_course', 'CourseController@add_video_course');



    Route::group(['middleware' => 'admin'], function() {

      Route::post('add_video_course_example', 'CourseController@add_video_course_example');
      Route::get('admin/set_video', 'SetVideoController@index');
      Route::get('admin/search_list_video', 'SetVideoController@search_list_video');
      Route::post('admin/fea_video', 'SetVideoController@fea_video');
      Route::post('admin/free_video', 'SetVideoController@free_video');
      Route::post('admin/add_qty2_photo', 'SetVideoController@add_qty2_photo');



      Route::post('add_file_course', 'CourseController@add_file_course');
      Route::get('admin/get_file_course/{id}', 'CourseController@get_file_course');
      Route::post('admin/del_file_course/{id}', 'CourseController@del_file_course');

      Route::post('admin/update_order_package/', 'OrederPackageController@update_order_package');
      Route::get('admin/order_package/{id}/edit', 'OrederPackageController@order_package_edit');
      Route::post('admin/order_package_del/{id}', 'OrederPackageController@order_package_del');
      Route::get('admin/order_package', 'OrederPackageController@index');
      Route::get('admin/message_chat/{id}', 'CourseController@message_chat');
      Route::resource('admin/coupon', 'CouponController');

      Route::post('admin/post_status', 'CourseController@post_status');

      Route::get('video_course_edit/{id}', 'CourseController@video_course_edit');
      Route::get('video_course_edit2/{id}', 'CourseController@video_course_edit2');
      Route::post('post_edit_video_course', 'CourseController@post_edit_video_course');
      Route::post('post_edit_video_course2', 'CourseController@post_edit_video_course2');



        Route::resource('admin/free_course', 'Free_courseController');
        Route::resource('admin/wallet', 'Wallet_submitController');
        Route::resource('admin/dashboard', 'DashboardController');
        Route::resource('admin/user', 'UserController');
        Route::resource('admin/blog', 'BlogController');
        Route::post('api/api_blog_status', 'BlogController@api_blog_status');
        Route::resource('admin/teacher', 'TeacherController');
        Route::resource('admin/student', 'StudentController');
        Route::resource('admin/package_product', 'PackagePorController');
        Route::get('admin/package_product/{id}/del', 'PackagePorController@package_product_del');

        Route::get('admin/search_student', 'StudentController@search_student');

        Route::resource('admin/course', 'CourseController');
        Route::resource('admin/play_student', 'Course_studentController');
        Route::get('admin/play_student/{id}/print', 'Course_studentController@print');
        Route::resource('admin/department', 'DepartmentController');
        Route::resource('admin/slide', 'SlideController');
        Route::post('api/api_slide_status', 'SlideController@api_slide_status');


        Route::post('admin/del_video/{id}', 'QuestionController@del_video');
        Route::post('admin/del_video2/{id}', 'QuestionController@del_video2');

        Route::post('admin/updatesort_video/{id}', 'QuestionController@updatesort_video');

        Route::post('admin/updatesort/{id}', 'QuestionController@updatesort');
        Route::get('admin/examination/{id}/edit', 'CourseController@examination');
        Route::post('admin/store2', 'QuestionController@store2');
        Route::post('admin/deleteq/{id}', 'QuestionController@deleteq');
        Route::resource('admin/category', 'CategoryController');

        Route::resource('admin/example', 'ExampleController');
        Route::resource('admin/example_admin', 'Example_adminController');
        Route::resource('admin/card_money', 'Card_moneyController');


        Route::resource('admin/typecourse', 'TypecourseController');

        Route::post('admin/file/posts', 'UploadFileController@imagess');

        Route::resource('admin/bank', 'BankController');
        Route::resource('admin/order_shop', 'OrderController');

        Route::group(['prefix' => 'file'],  function(){
        Route::post('post', 'UploadFileController@image');
        });

        Route::get('local/.env');

        Route::resource('admin/ans', 'AnsController');
        Route::get('admin/inbox', 'MassageController@index_admin');

        Route::get('admin/inbox_chat/{id}', 'MassageController@inbox_chat');

        Route::post('admin/admin_message_sender', 'MassageController@admin_message_sender');
        Route::get('admin/logsys', 'LogController@logsys');

    });




Route::get('/japanonline', 'PackagController@all_package');


  Route::post('/search', 'PackagController@search');

Route::get('/japanonline/login', 'PackagController@login');
Route::get('/japanonline/register', 'PackagController@register');
Route::get('/blog', 'PackagController@blog');
Route::get('/blog_detail/{id}', 'PackagController@blog_detail');
Route::get('/download_file_course/{id}', 'PackagController@download_file_course');

Route::group(['middleware' => 'auth'], function () {

  Route::post('/check_course_online', 'PackagController@check_course_online');
  Route::get('/link_noti/{id}', 'PackagController@link_noti');
  Route::post('/get_noti', 'PackagController@get_noti');
  Route::get('/my_example', 'PackagController@my_example');
  Route::get('/single_channel/{id}', 'PackagController@single_channel');
  Route::get('/playlist_channel/{id}', 'PackagController@playlist_channel');
  Route::get('/course_detail/{id}', 'PackagController@course_detail');
  Route::get('/e_testing/{id}', 'PackagController@e_testing');
  Route::get('/success_ans_package/{id}', 'PackagController@success_ans_package');
  Route::get('/success_ans_package2/{id}', 'PackagController@success_ans_package2');
  Route::post('/post_ans_course','PackagController@post_ans_course');
  Route::post('/post_ans_course2','PackagController@post_ans_course2');
  Route::post('/post_comment_user','PackagController@post_comment_user');
  Route::post('/edit_comment_user','PackagController@edit_comment_user');


  Route::get('/del_comment/{id}', 'PackagController@del_comment');

  Route::get('/start_test/{id}', 'PackagController@start_test');
  Route::get('/start_test2/{id}', 'PackagController@start_test2');

  Route::get('/package', 'PackagController@home');

  Route::get('/channels', 'PackagController@channels');
  Route::get('/new_video', 'PackagController@new_video');
  Route::get('/play_video/{id}', 'PackagController@play_video');
  Route::get('/history_video', 'PackagController@history_video');
  Route::get('/my_history', 'PackagController@my_history');




  Route::get('/single_course', 'PackagController@single_course');
  Route::get('/course_detail', 'PackagController@course_detail');

  Route::get('/all_e_testing', 'PackagController@all_e_testing');


  Route::post('/submit_free_package','PackagController@submit_free_package');

  Route::get('/profile_user_package','PackagController@profile_user');
  Route::get('/account','PackagController@my_package');
  Route::post('/update_user_package','PackagController@update_user_package');


  Route::get('/success_free_package/{id}', 'PackagController@success_free_package');
  Route::get('/get_free_package/{id}', 'PackagController@get_free_package');
  Route::get('/info_package/{id}', 'PackagController@info_package');
  Route::get('/get_info_package/{id}','PackagController@get_info_package');
  Route::get('/success_payment/{id}','PackagController@success_payment');

  Route::post('/submit_info_package','PackagController@submit_info_package');
  Route::post('/submit_payment_package','PackagController@submit_payment_package');


  Route::post('/post_coupon','HomeController@post_coupon');

  Route::put('/bil_course/{id}', 'CourseinfoController@bil_course');
  Route::get('/live_stream/{id}', 'StreamController@live_stream');
  Route::post('user_ans/message_sender1', 'StreamController@message_sender');
  Route::post('chat_room_get_user', 'StreamController@chat_room_get_user');


  Route::resource('comment', 'CommentController');

  Route::resource('profile_user', 'UserprofileController');
  Route::get('profile', 'UserprofileController@profile');
  Route::resource('user_course', 'MycourseController');

  Route::get('user_course_detail/{id}', 'MycourseController@show');
  Route::get('ans_detail-{Eid}-{sub_id}', 'MycourseController@ans_detail');

  Route::get('my_state', 'MycourseController@my_state');

  Route::post('ans_detail_post', 'MycourseController@ans_detail_post');
  //Route::resource('e-testing', 'MyansController');
  Route::resource('user_confirm', 'UserconfirmController');

  Route::get('/pay_course', 'CourseinfoController@submit_course');
  Route::get('/confirm_course/{id}', 'CourseinfoController@confirm_course');
  Route::get('/checkmycourse/{id}', 'CourseinfoController@checkmycourse');


  Route::post('/submit_course/{id}', 'CourseinfoController@submit_course');

  Route::get('/get_wallet/{id}', 'Wallet_submitController@buy_wallet');
  Route::post('/post_wallet', 'Wallet_submitController@post_wallet');

  Route::post('/submit_course_free/{id}', 'CourseinfoController@submit_course_free');

  Route::get('success_ans/{id}', 'MycourseController@success_ans');
  Route::get('user_rep', 'MycourseController@user_rep');
  Route::get('store_transactions', 'MycourseController@store_transactions');

  Route::get('user_ans', 'MassageController@index');
  Route::post('user_ans/message_sender', 'MassageController@message_sender');
});




Route::group(['middleware' => ['api'],'prefix' => 'api'], function () {


    Route::post('play_video/', 'APIController@play_video');
    Route::get('japanonline', 'APIController@api_japanonline');
    Route::post('/account','APIController@my_package');
    Route::post('/my_history', 'APIController@my_history');
    Route::get('channels', 'APIController@channels');
    Route::post('course_channel', 'APIController@course_channel');
    Route::post('playlist_channel', 'APIController@playlist_channel');
    Route::post('example_channel', 'APIController@example_channel');
    Route::post('/check_course_online', 'APIController@check_course_online');

    Route::post('course_detail', 'APIController@course_detail');
    Route::post('download_file_course', 'APIController@download_file_course');
    Route::get('new_video', 'APIController@new_video');
    Route::get('all_e_testing', 'APIController@all_e_testing');



    Route::post('check_coupon', 'APIController@check_coupon');

    Route::get('get_my_radar/{id}', 'APIController@get_my_radar');
    Route::post('register', 'APIController@register');
    Route::post('login', 'APIController@login');
    Route::get('get_new', 'APIController@get_new');

  //  Route::get('get_course_static/{id}', 'APIController@get_course_static');  0954609497
  //  Route::get('get_course_online/{id}', 'APIController@get_course_online');
    Route::post('get_course_info/{id}', 'APIController@get_course_info');
    Route::post('check_fb', 'APIController@check_fb');
    Route::post('contact', 'APIController@contact');
    Route::get('get_department', 'APIController@get_department');
    Route::get('get_bank', 'APIController@get_bank');
    Route::get('get_course/{id}/{type_courses_id}', 'APIController@get_course');
    Route::get('user_rep', 'APIController@user_rep');
    Route::get('wallet', 'APIController@wallet');



    Route::group(['middleware' => 'jwt-auth'], function () {

      Route::post('submiy_course_free', 'APIController@submiy_course_free');

      Route::post('get_course_token/{id}/{type_courses_id}', 'APIController@get_course_token');
      Route::post('get_my_message', 'APIController@get_my_message');
      Route::post('get_look_course/{id}', 'APIController@get_look_course');
    	Route::post('get_user_details', 'APIController@get_user_details');
      Route::post('update_user_details', 'APIController@update_user_details');
      Route::post('update_onesignal_info', 'APIController@update_onesignal_info');
      Route::post('confirm_course/{id}', 'APIController@confirm_course');
      Route::post('get_data_confirm_course/{id}', 'APIController@get_data_confirm_course');
      Route::post('bil_course', 'APIController@bil_course');
      Route::post('get_mycourse', 'APIController@get_mycourse');
      Route::post('user_course_detail/{id}', 'APIController@user_course_detail');
      Route::post('ans_detail_post', 'APIController@ans_detail_post');
      Route::post('ans_detail', 'APIController@ans_detail');
      Route::post('success_ans', 'APIController@success_ans');
      Route::post('display_ans_success', 'APIController@display_ans_success');
      Route::post('get_course_state', 'APIController@get_course_state');
      Route::post('del_point', 'APIController@del_point');
      Route::post('get_myhistory', 'APIController@get_myhistory');


    });

});
