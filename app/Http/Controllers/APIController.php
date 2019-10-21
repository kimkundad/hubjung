<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use JWTAuth;
use App\blog;
use App\course;
use App\submitcourse;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\bank;
use Mail;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;
use Validator;
use App\coupon_user;
use Input;
use App\Users;
use App\department;
use App\contact;
use App\answer;
use App\setpoint;
use App\video_list;
use App\logsys;
use App\filecourse;
use App\example_video;
use Response;

class APIController extends Controller
{


    public function api_japanonline(){

      $video = DB::table('video_lists')
       ->select(
       'video_lists.*',
       'video_lists.id as id_v',
       'video_lists.created_at as created_ats',
       'courses.title_course',
       'courses.set_type_c',
       'departments.name_department'
       )
       ->leftjoin('courses', 'courses.id', '=', 'video_lists.course_id')
       ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
       ->where('courses.set_type_c', 1)
       ->where('video_lists.fea_video', 1)
       ->orderBy('video_lists.order_sort', 'asc')
       ->limit(8)
       ->get();


       $get_course = DB::table('courses')
       ->select(
       'courses.*',
       'courses.set_type_c',
       'departments.name_department'
       )
        ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
        ->where('courses.set_type_c', 1)
        ->inRandomOrder()
        ->limit(8)
        ->get();

        if(isset($get_course)){

          foreach ($get_course as $j) {


            $count_video = DB::table('video_lists')
             ->where('course_id', $j->id)
             ->count();


             $j->count_video  = $count_video;
            // code...
          }



        }

        $depart = DB::table('departments')
         ->get();

         if(isset($depart)){
           foreach($depart as $u){

             $count_videos = array();

             $pack = DB::table('courses')
              ->where('department_id', $u->id)
              ->where('set_type_c', 1)
              ->get();

              if(isset($pack)){

                foreach ($pack as $j) {


                  $count_video = DB::table('video_lists')
                   ->where('course_id', $j->id)
                   ->count();

                   $count_videos = $count_video;
                  // code...
                }

                $u->get_count_video = $count_videos;

              }

           }
         }

         $pack = DB::table('package_products')
          ->where('package_status', 1)
          ->orderBy('package_sort', 'asc')
          ->get();


      return response()->json(['status'=>200, 'message' => 'success', 'data' => ['video' => $video, 'get_course' => $get_course, 'get_department' => $depart, 'get_package' => $pack] ]);

    }

    public function play_video(Request $request){

      $id = $request['id'];

      $package = example_video::find($id);
      $package->view_video += 1;
      $package->save();

      $get_video = DB::table('example_videos')->select(
        'example_videos.*'
        )
        ->where('id',$id)
        ->first();

        $get_data = DB::table('courses')
         ->select(
         'courses.*',
         'courses.set_type_c',
         'departments.name_department'
         )
         ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
         ->where('courses.id', $get_video->course_id)
         ->first();


         $get_tags = DB::table('courses')->select(
           'courses.tags'
           )
           ->where('id', $get_video->course_id)
           ->first();

           $exp = array();


             $path1 = explode(",", $get_tags->tags);
             $exp = array_merge($exp, $path1);


           $data['get_tags'] = $exp;




        $all_video = DB::table('example_videos')->select(
          'example_videos.*'
          )
          ->where('course_id',$get_video->course_id)
          ->get();

        $data['get_data'] = $get_data;
        $data['get_video'] = $get_video;
        $data['all_video'] = $all_video;

        return response()->json(['status'=>200, 'message' => 'success', 'data' => ['get_data' => $get_data, 'get_video' => $get_video, 'all_video' => $all_video] ]);

    }

    public function course_channel(Request $request){

      $depart = DB::table('departments')
      ->where('id', $request['id'])
      ->first();


      $pack = DB::table('courses')
       ->where('department_id', $depart->id)
       ->where('set_type_c', 1)
       ->paginate(16);

       foreach ($pack as $j) {


         $count_video = DB::table('video_lists')
          ->where('course_id', $j->id)
          ->count();

          $j->count_video = $count_video;
         // code...
       }

      $data['pack'] = $pack;
      $data['depart'] = $depart;


      return response()->json(['status'=>200, 'message' => 'success', 'data' => ['channels_data' => $depart, 'course_data' => $pack] ]);
    }

    public function playlist_channel(Request $request){

      $depart = DB::table('departments')
      ->where('id', $request['id'])
      ->first();


      $pack = DB::table('courses')
       ->where('department_id', $depart->id)
       ->where('set_type_c', 1)
       ->get();

       $get_id_first = [];

       foreach ($pack as $j) {

          $get_id_first[] = $j->id;
         // code...
       }

       $get_video = DB::table('video_lists')
                  ->whereIn('course_id', $get_id_first)
                  ->orderBy('created_at', 'desc')
                  ->paginate(16);

              //    dd($get_video);


      return response()->json(['status'=>200, 'message' => 'success', 'data' => ['channels_data' => $depart, 'get_video' => $get_video] ]);

    }

    public function course_detail(Request $request){

      $id = $request['id'];

      $filecourses = DB::table('filecourses')
       ->where('course_id', $id)
       ->get();


       $data['file'] = $filecourses;


      $ex_video = DB::table('example_videos')
       ->where('course_id', $id)
       ->get();


       $data['ex_video'] = $ex_video;

      // dd($ex_video);

      $get_tags = DB::table('courses')->select(
        'courses.tags'
        )
        ->where('id', $id)
        ->first();

        $exp = array();

        if(isset($get_tags->tags)){
          $path1 = explode(",", $get_tags->tags);
          $exp = array_merge($exp, $path1);
        }else{
          $exp = null;
        }


      $package = course::find($id);
      $package->view_course += 1;
      $package->save();

      $pack = DB::table('courses')
       ->where('id', $id)
       ->where('set_type_c', 1)
       ->first();

       $depart = DB::table('departments')
       ->where('id', $pack->department_id)
       ->first();


         $count_video = DB::table('video_lists')
          ->where('course_id', $pack->id)
          ->orderBy('order_sort', 'asc')
          ->get();

          $data['depart'] = $depart;
          $data['pack'] = $pack;
          $data['count_video'] = $count_video;

          return response()->json(['status'=>200, 'message' => 'success', 'data' => ['file_download' => $filecourses, 'example_videos' => $ex_video, 'get_tags' => $exp, 'channels_data' => $depart, 'coursr_data' => $pack , 'count_video' => $count_video] ]);
    }

    public function download_file_course(Request $request){

      $obj = filecourse::find($request['id']);
      $file = public_path().'/assets/file_courses/'.$obj->file_of_course;
    //  return Response::download($file);
      return response()->json(['status'=>200, 'message' => 'success', 'data' => ['download_file_course' => $file] ]);
    }



    public function example_channel(Request $request){

      $objs = DB::table('examples')
          ->select(
          'examples.*',
          'courses.title_course',
          'examples.id as e_id',
          'courses.id as c_id',
          'courses.id as ca_id',
          'categories.*'
          )
          ->leftjoin('courses', 'courses.id', '=', 'examples.course_id')
          ->leftjoin('categories', 'examples.category_id', '=', 'categories.id')
          ->where('courses.department_id', $request['id'])
          ->where('courses.set_type_c', 1)
          ->get();

          foreach ($objs as $obj) {

              $options = DB::table('questions')->where('category_id',$obj->e_id)->count();
              $obj->options = $options;
          }

        //  dd($objs);

      $depart = DB::table('departments')
      ->where('id', $request['id'])
      ->first();

      $pack = DB::table('courses')
       ->where('department_id', $depart->id)
       ->where('set_type_c', 1)
       ->get();




      return response()->json(['status'=>200, 'message' => 'success', 'data' => ['channels_data' => $depart, 'get_example' => $objs] ]);
    }

    public function new_video(){
      $video = DB::table('video_lists')
       ->select(
       'video_lists.*',
       'video_lists.id as id_v',
       'video_lists.created_at as created_ats',
       'courses.title_course',
       'courses.set_type_c',
       'departments.name_department'
       )
       ->leftjoin('courses', 'courses.id', '=', 'video_lists.course_id')
       ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
       ->where('courses.set_type_c', 1)
       ->where('video_lists.fea_video', 1)
       ->orderBy('video_lists.order_sort', 'asc')
       ->paginate(16);


       return response()->json(['status'=>200, 'message' => 'success', 'data' => ['get_video' => $video] ]);
    }

    public function all_e_testing(){
      $objs = DB::table('examples')
          ->select(
          'examples.*',
          'courses.title_course',
          'examples.id as e_id',
          'courses.id as c_id',
          'courses.id as ca_id',
          'categories.*'
          )
          ->leftjoin('courses', 'courses.id', '=', 'examples.course_id')
          ->leftjoin('categories', 'examples.category_id', '=', 'categories.id')
          ->where('courses.set_type_c', 1)
          ->get();

          foreach ($objs as $obj) {

              $options = DB::table('questions')->where('category_id',$obj->e_id)->count();
              $obj->options = $options;
          }


      return response()->json(['status'=>200, 'message' => 'success', 'data' => ['get_data' => $objs] ]);
    }


    public function channels(){

      $depart = DB::table('departments')
       ->get();

       if(isset($depart)){
         foreach($depart as $u){

           $count_videos = array();

           $pack = DB::table('courses')
            ->where('department_id', $u->id)
            ->where('set_type_c', 1)
            ->get();

            if(isset($pack)){

              foreach ($pack as $j) {


                $count_video = DB::table('video_lists')
                 ->where('course_id', $j->id)
                 ->count();

                 $count_videos = $count_video;
                // code...
              }

              $u->get_count_video = $count_videos;

            }

         }
       }

      return response()->json(['status'=>200, 'message' => 'success', 'data' => ['channels' => $depart] ]);
    }

    public function check_course_online(Request $request){

      $user = JWTAuth::toUser($request['token']);

      $count_package = DB::table('submit_packages')
       ->where('user_id', $user->id)
       ->where('sp_status', 1)
       ->count();

       $count_expire = 0;

       if($count_package > 0){

         $get_package = DB::table('submit_packages')
          ->where('user_id', $user->id)
          ->where('sp_status', 1)
          ->get();



          foreach($get_package as $u){

            if($u->end_date >= date("Y-m-d")){
              $count_expire++;

            }else{
              DB::table('submit_packages')
              ->where('id', $u->id)
              ->delete();
            }

          }

       }else{

       }

       return response()->json(['status'=>200, 'message' => 'success', 'data' => ['get_data' => $count_expire] ]);

    }

    public function my_package(Request $request){

      $user = JWTAuth::toUser($request['token']);

      $count_example = 0;
      $course_chart = DB::table('answers')->select(
        'answers.*'
        )
        ->where('answers.user_id', $user->id)
        ->orderBy('answers.id_option', 'desc')
        ->groupBy('answers.id_option')
        ->get();

      foreach($course_chart as $u){
        $count_example++;
      }

      $package_count = DB::table('submit_packages')
        ->where('user_id', $user->id)
        ->count();

        $count_his = DB::table('package_his')
          ->where('package_his.user_id', $user->id)
          ->count();

          $package = DB::table('submit_packages')
            ->select(
               'submit_packages.*',
               'submit_packages.user_id as Uid',
               'submit_packages.id as Oid',
               'submit_packages.created_at as Dcre',
               'users.*',
               'users.id as Ustudent',
               'package_products.*',
               'package_products.id as id_cource'
               )
            ->leftjoin('users', 'users.id', '=', 'submit_packages.user_id')
            ->leftjoin('package_products', 'package_products.id', '=', 'submit_packages.packeage_id')
            ->where('submit_packages.user_id', $user->id)
            ->get();

            if(isset($package)){
              foreach($package as $u){


                $str_start = strtotime($u->start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
                $str_end = strtotime($u->end_date); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
                $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
                $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที

                $total_day = $ndays;

                $u->total_day = $total_day;

              }
            }


            $order = DB::table('package_his')
              ->select(
                 'package_his.*',
                 'package_his.user_id as Uid',
                 'package_his.id as Oid',
                 'package_his.created_at as Dcre',
                 'users.*',
                 'users.id as Ustudent',
                 'package_products.*',
                 'package_products.id as id_cource'
                 )
              ->leftjoin('users', 'users.id', '=', 'package_his.user_id')
              ->leftjoin('package_products', 'package_products.id', '=', 'package_his.packeage_id')
              ->where('package_his.user_id', $user->id)
              ->where('package_his.his_status', 0)
              ->where('package_his.his_type', 0)
              ->get();

      return response()->json(['status'=>200, 'message' => 'success', 'data' => ['count_example' => $count_example, 'count_package' => $package_count, 'his_pay' => $count_his, 'my_package' => $package, 'my_order' => $order] ]);

    }


    public function my_history(Request $request){

      $user = JWTAuth::toUser($request['token']);

      $pack = DB::table('package_his')
        ->select(
           'package_his.*',
           'package_his.user_id as Uid',
           'package_his.id as Oid',
           'package_his.created_at as Dcre',
           'users.id as Ustudent',
           'banks.*',
           'package_products.package_name',
           'package_products.package_type',
           'package_products.package_price',
           'package_products.id as id_cource'
           )
        ->leftjoin('users', 'users.id', '=', 'package_his.user_id')
        ->leftjoin('package_products', 'package_products.id', '=', 'package_his.packeage_id')
        ->leftjoin('banks', 'banks.id', '=', 'package_his.bank_id')
        ->where('package_his.user_id', $user->id)
        ->get();

        return response()->json(['status'=>200, 'message' => 'success', 'data' => ['my_history' => $pack] ]);

    }

    public function register(Request $request)
    {

   $credentials = Input::only('email', 'password','name');
   $credentials['password'] = Hash::make($credentials['password']);

   $countobj = DB::table('users')
     ->select(
        'users.*'
        )
     ->where('users.email', $credentials['email'])
     ->count();

   if($countobj > 0){
     return response()->json(['status'=>100, 'message' => 'register false duplicate email system', 'data' => NULL]);
   }else{
     $user = User::create($credentials);

     $objs = DB::table('users')
         ->select(
         'users.*'
         )
         ->where('id', $user->id)
         ->first();

     if ($token = JWTAuth::fromUser($user)) {
           return response()->json(['status'=>200, 'message' => 'register success', 'data' => ['token' => $token, 'profile' => $objs]]);
       }

   }

  /* try {
       $user = User::create($credentials);
       return response()->json(['status'=>200, 'message' => 'register success', 'data' => true]);
   } catch (Exception $e) {
       return Response::json(['error' => 'User already exists.'], Illuminate\Http\Response::HTTP_CONFLICT);
   } */



    	/*$input = $request->all();
    	$input['password'] = Hash::make($input['password']); */




      //return response()->json(['status'=>100, 'message' => 'register false duplicate email system', 'data' => NULL]);

      //  User::create($input);




    }

    public function login(Request $request)
    {
    	$input = $request->all();
    	if (!$token = JWTAuth::attempt($input)) {
            return response()->json(['status'=>100, 'message' => 'wrong email or password.', 'data' => NULL]);
        }

        if(!$user = JWTAuth::toUser($token)){
          return response()->json(['status'=>100, 'message' => 'wrong data token.', 'data' => NULL]);
        }else{
          return response()->json(['status'=>200, 'message' => 'login success', 'data' => ['token' => $token, 'profile' => $user]]);
        }

    }


    public function check_fb(Request $request)
    {
    	$input = $request->all();

      if(Input::get('fb_id') == NULL && Input::get('name') == NULL){
        return response()->json(['status'=>100, 'message' => 'Data facebook id and name Null', 'data' => NULL]);
      }
      if(Input::get('fb_id') == NULL){
        return response()->json(['status'=>100, 'message' => 'Data facebook fb_id Null', 'data' => NULL]);
      }
      if(Input::get('name') == NULL){
        return response()->json(['status'=>100, 'message' => 'Data facebook name Null', 'data' => NULL]);
      }

      if(Input::get('email') != NULL){
      $objs = DB::table('users')
          ->select(
          'users.*',
          'social_accounts.*'
          )
          ->leftjoin('social_accounts', 'social_accounts.user_id', '=', 'users.id')
          ->where('users.email', Input::get('email'))
          ->where('social_accounts.provider_user_id', Input::get('fb_id'))
          ->count();
      }else{

        $objs = DB::table('users')
            ->select(
            'users.*',
            'social_accounts.*'
            )
            ->leftjoin('social_accounts', 'social_accounts.user_id', '=', 'users.id')
            ->where('social_accounts.provider_user_id', Input::get('fb_id'))
            ->count();

      }

     if($objs == 1){




       if(Input::get('email') != NULL){

         $objs = DB::table('users')
             ->select(
             'users.*',
             'social_accounts.*'
             )
             ->leftjoin('social_accounts', 'social_accounts.user_id', '=', 'users.id')
             ->where('users.email', Input::get('email'))
             ->where('social_accounts.provider_user_id', Input::get('fb_id'))
             ->first();

       }else{

         $objs = DB::table('users')
             ->select(
             'users.*',
             'social_accounts.*'
             )
             ->leftjoin('social_accounts', 'social_accounts.user_id', '=', 'users.id')
             ->where('social_accounts.provider_user_id', Input::get('fb_id'))
             ->first();

       }


     }else{




       if(Input::get('email') != NULL){


         $id = DB::table('users')->insertGetId(
            [
              'email' => Input::get('email'),
              'name' => Input::get('name'),
              'position' => 'student',
              'avatar' => 'graph.facebook.com/'.Input::get('fb_id').'/picture?width=300&height=300',
              'provider' => 'facebook'
            ]
          );

          DB::table('social_accounts')->insert(
              ['user_id' => $id, 'provider_user_id' => Input::get('fb_id'), 'provider' => 'facebook']
          );


          if(Input::get('email') != NULL){

            $objs = DB::table('users')
                ->select(
                'users.*',
                'social_accounts.*'
                )
                ->leftjoin('social_accounts', 'social_accounts.user_id', '=', 'users.id')
                ->where('users.email', Input::get('email'))
                ->where('social_accounts.provider_user_id', Input::get('fb_id'))
                ->first();

          }else{

            $objs = DB::table('users')
                ->select(
                'users.*',
                'social_accounts.*'
                )
                ->leftjoin('social_accounts', 'social_accounts.user_id', '=', 'users.id')
                ->where('social_accounts.provider_user_id', Input::get('fb_id'))
                ->first();

          }



       }else{


         $id = DB::table('users')->insertGetId(
            [
              'email' => Input::get('fb_id'),
              'name' => Input::get('name'),
              'position' => 'student',
              'avatar' => 'graph.facebook.com/'.Input::get('fb_id').'/picture?width=300&height=300',
              'provider' => 'facebook'
            ]
          );

          DB::table('social_accounts')->insert(
              ['user_id' => $id, 'provider_user_id' => Input::get('fb_id'), 'provider' => 'facebook']
          );


          if(Input::get('email') != NULL){

            $objs = DB::table('users')
                ->select(
                'users.*',
                'social_accounts.*'
                )
                ->leftjoin('social_accounts', 'social_accounts.user_id', '=', 'users.id')
                ->where('users.email', Input::get('email'))
                ->where('social_accounts.provider_user_id', Input::get('fb_id'))
                ->first();

          }else{

            $objs = DB::table('users')
                ->select(
                'users.*',
                'social_accounts.*'
                )
                ->leftjoin('social_accounts', 'social_accounts.user_id', '=', 'users.id')
                ->where('social_accounts.provider_user_id', Input::get('fb_id'))
                ->first();

          }



   }




     }



      //then use
      if (!$token = JWTAuth::fromUser($objs)) {
            return response()->json(['status'=>100, 'message' => 'wrong email or password.', 'data' => NULL]);
        }

      if ($token = JWTAuth::fromUser($objs)) {
            return response()->json(['status'=>200, 'message' => 'login success', 'data' => ['token' => $token, 'profile' => $objs]]);
        }






    }

    public function get_user_details(Request $request)
    {
    	$input = $request->all();

      if(!$user = JWTAuth::toUser($input['token'])){
        return response()->json(['status'=>100, 'message' => 'wrong data token.', 'data' => NULL]);
      }else{
        return response()->json(['status'=>200, 'message' => 'success user profile.', 'data' => $user]);
      }

    }

    public function user_rep(){

      $ranking = DB::table('users')
          ->select(
          'users.*'
          )
          ->where('users.point_level', '>=', 0)
          ->where('users.id', '!=', 1)
          ->orderBy('users.point_level', 'desc')
          ->paginate(15);

          foreach ($ranking as $obj) {
            $optionsRes = [];
              $options = DB::table('levels')->select(
              DB::raw('levels.*, max(levels.id) as id')
              )->where('points','<=', $obj->point_level)->get();
              $obj->options = $options;
          }



      return response()->json(['status'=>200, 'message' => 'success', 'data' => $ranking]);

    }

    public function get_new(){

      $objs = DB::table('blogs')
          ->orderBy('created_at', 'desc')
          ->paginate(10);

    //  $objs = blog::paginate(10);
      return response()->json(['status'=>200, 'message' => 'success', 'data' => $objs]);
    }

    public function get_department(){

      $objs = DB::table('departments')
          ->select(
          'departments.*'
          )
          ->get();

      return response()->json(['status'=>200, 'message' => 'success', 'data' => $objs]);
    }







    public function get_course_token(Request $request, $id = 0, $type_courses_id = 0){
      if($id == NULL && $type_courses_id == NULL){
        $id == 0;
        $type_courses_id == 0;
      }

      $input = $request->all();
      if($input != null){
      //  $user = JWTAuth::toUser($input['token']);


        if($type_courses_id == 0){

//$user = JWTAuth::toUser($request['token']); ->orderBy('sort_corse', 'asc')
          if(!$user = JWTAuth::toUser($request['token'])){
            return response()->json(['status'=>100, 'message' => 'wrong data token.', 'data' => NULL]);
          }else{


            $course = DB::table('courses')
                ->select(
                'courses.*',
                'courses.id as course_number_id',
                'courses.department_id as department_id',
                'typecourses.id as type_courses_id',
                'typecourses.*'
                )
                ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
                ->where('courses.department_id', $id)
                ->where('courses.ch_status', 1)
                ->where('courses.set_type_c', 0)
                ->orderBy('courses.sort_corse', 'asc')
                ->paginate(10);

                foreach ($course as $obj) {
                    $optionsRes = [];
                    $options = DB::table('submitcourses')->select(
                      'submitcourses.*'
                      )
                      ->where('submitcourses.course_id', $obj->course_number_id)
                      ->where('submitcourses.user_id', $user->id)
                      ->first();


                      date_default_timezone_set("Asia/Bangkok");
                      $data_toview['datatime'] = date("Y-m-d");

                          if($options != null){

                            if($options->end_day >= $data_toview['datatime']){
                              $obj->expirestatus = 0;
                            }else{
                              $obj->expirestatus = 1;
                            }

                            $obj->end_day  = $options->end_day;

                          }




                    if($options != null){
                      $obj->options = $options->status;
                      if($options->status == 3 || $options->status == 2){
                        $obj->status = 2;
                      }else{
                        $obj->status = 1;
                      }
                    }else{
                      $obj->options = 0;
                      $obj->status = 3;
                    }


                    if($obj->type_course == 3){
                      $obj->expirestatus = 0;
                    }



                }


                foreach ($course as $obj) {
                    $optionsRes = [];
                    $options = DB::table('video_lists')->select(
                      'video_lists.*'
                      )
                      ->where('video_lists.course_id', $obj->course_number_id)
                      ->orderBy('video_lists.order_sort', 'asc')
                      ->get();

                      //$obj->options = 2;
                      if($options != null){
                        $obj->video_lists = $options;
                      }else{
                        $obj->video_lists = null;
                      }

                      $urlpath = 'assets/excel/'.$obj->url_course;
                    //  $urlpath = file_get_contents($urlpath);
               // header('Content-Type: text/html; charset=utf-8');
                 $urlpath =  utf8_encode($urlpath);
               $urlpath = iconv("TIS-620", "utf-8", $urlpath);

              //$urlpath = trim($urlpath);
              $html_code = "<div></div>";
              $s = 0;
              $completeflag = false;
                 $f = fopen($urlpath, "r");

                 $tmpString = "";

                 while (($line = fgetcsv($f)) !== false) {
                         foreach ($line as $cell) {

                          //  $optionsRes[$s] = "<tr><td>" . htmlspecialchars($cell) . "</td></tr>";
                          if($s%2 == 0){
                            $tmpString = $tmpString . "<tr><td style='text-align:left;'><font size='2' color='gray'>" . htmlspecialchars($cell)."</font></td>";
                            $completeflag = false;
                          }else{
                            $tmpString = $tmpString ."<td style='text-align:right;'><font size='2' color='gray'>". htmlspecialchars($cell) . "</font></td></tr>";
                            $completeflag = true;
                          }
                                $s++;
                         }
                    //final string
                    if($completeflag == true){
                        $html_code = "<div><table border=1 width='100%'>" . $tmpString . '</table></div>';
                    }else{
                      //save loss column
                        $html_code = "<div><table border=1 width='100%'>" . $tmpString . '<td></td></tr></table></div>';
                    }
                 }
                 fclose($f);
                 $obj->coursedetails_htmlcode = $html_code;

                }





          }




        }else{


          if(!$user = JWTAuth::toUser($input['token'])){
            return response()->json(['status'=>100, 'message' => 'wrong data token.', 'data' => NULL]);
          }else{

            $course_count = DB::table('courses')
                ->select(
                'courses.*',
                'courses.id as course_number_id',
                'courses.department_id as department_id',
                'typecourses.id as type_courses_id',
                'typecourses.*'
                )
                ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
                ->where('courses.type_course', $type_courses_id)
                ->where('courses.department_id', $id)
                ->where('courses.set_type_c', 0)
                ->orderBy('courses.sort_corse', 'asc')
                ->count();


          $course = DB::table('courses')
              ->select(
              'courses.*',
              'courses.id as course_number_id',
              'courses.department_id as department_id',
              'typecourses.id as type_courses_id',
              'typecourses.*'
              )
              ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
              ->where('courses.type_course', $type_courses_id)
              ->where('courses.department_id', $id)
              ->where('courses.set_type_c', 0)
              ->orderBy('courses.sort_corse', 'asc')
              ->paginate(10);

              if($course_count > 0){


                foreach ($course as $obj) {
                    $optionsRes = [];
                    $options = DB::table('video_lists')->select(
                      'video_lists.*'
                      )
                      ->where('video_lists.course_id', $obj->course_number_id)
                      ->orderBy('video_lists.order_sort', 'asc')
                      ->get();

                      //$obj->options = 2;
                      if($options != null){
                        $obj->video_lists = $options;
                      }else{
                        $obj->video_lists = null;
                      }

                      $urlpath = 'assets/excel/'.$obj->url_course;
                    //  $urlpath = file_get_contents($urlpath);
               // header('Content-Type: text/html; charset=utf-8');
                 $urlpath =  utf8_encode($urlpath);
               $urlpath = iconv("TIS-620", "utf-8", $urlpath);

              //$urlpath = trim($urlpath);
              $html_code = "<div></div>";
              $s = 0;
              $completeflag = false;
                 $f = fopen($urlpath, "r");

                 $tmpString = "";

                 while (($line = fgetcsv($f)) !== false) {
                         foreach ($line as $cell) {

                          //  $optionsRes[$s] = "<tr><td>" . htmlspecialchars($cell) . "</td></tr>";
                          if($s%2 == 0){
                            $tmpString = $tmpString . "<tr><td style='text-align:left;'><font size='2' color='gray'>" . htmlspecialchars($cell)."</font></td>";
                            $completeflag = false;
                          }else{
                            $tmpString = $tmpString ."<td style='text-align:right;'><font size='2' color='gray'>". htmlspecialchars($cell) . "</font></td></tr>";
                            $completeflag = true;
                          }
                                $s++;
                         }
                    //final string
                    if($completeflag == true){
                        $html_code = "<div><table border=1 width='100%'>" . $tmpString . '</table></div>';
                    }else{
                      //save loss column
                        $html_code = "<div><table border=1 width='100%'>" . $tmpString . '<td></td></tr></table></div>';
                    }
                 }
                 fclose($f);
                 $obj->coursedetails_htmlcode = $html_code;

                }



              foreach ($course as $obj) {

                $options_count = DB::table('submitcourses')->select(
                  'submitcourses.*'
                  )
                  ->where('submitcourses.course_id', $obj->course_number_id)
                  ->where('submitcourses.user_id', $user->id)
                  ->count();


                  $options = DB::table('submitcourses')->select(
                    'submitcourses.*'
                    )
                    ->where('submitcourses.course_id', $obj->course_number_id)
                    ->where('submitcourses.user_id', $user->id)
                    ->first();


                    date_default_timezone_set("Asia/Bangkok");
                    $data_toview['datatime'] = date("Y-m-d");

                    if($options_count > 0){


                      if($options->end_day >= $data_toview['datatime']){
                        $obj->expirestatus = 0;
                      }else{
                        $obj->expirestatus = 1;
                      }


                      $obj->end_day  = $options->end_day;


                  if($options != null){
                    $obj->options = $options->status;
                  }else{
                    $obj->options = 0;
                  }

                    }else{

                      $obj->options = 0;

                    }


                    if($obj->type_course == 3){
                      $obj->expirestatus = 0;
                    }






              }
            }



            }

        }


      }else{




        if($type_courses_id == 0){

          $course = DB::table('courses')
              ->select(
              'courses.*',
              'courses.id as course_number_id',
              'courses.department_id as department_id',
              'typecourses.id as type_courses_id',
              'typecourses.*'
              )
              ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
              ->where('courses.department_id', $id)
              ->where('courses.set_type_c', 0)
              ->orderBy('courses.sort_corse', 'asc')
              ->paginate(10);




        }else{


          $course = DB::table('courses')
              ->select(
              'courses.*',
              'courses.id as course_number_id',
              'courses.department_id as department_id',
              'typecourses.id as type_courses_id',
              'typecourses.*'
              )
              ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
              ->where('courses.type_course', $type_courses_id)
              ->where('courses.department_id', $id)
              ->where('courses.set_type_c', 0)
              ->orderBy('courses.sort_corse', 'asc')
              ->paginate(10);



        }




      }



      return response()->json(['status'=>200, 'message' => 'success', 'data' => ['course' => $course, 'video_root_path' => 'http://150.107.31.28:10000/stream/'] ]);

    }









    public function get_course($id = 0, $type_courses_id = 0){
      if($id == NULL && $type_courses_id == NULL){
        $id == 0;
        $type_courses_id == 0;
      }

      //  $user = JWTAuth::toUser($input['token']);


        if($type_courses_id == 0){




            $course = DB::table('courses')
                ->select(
                'courses.*',
                'courses.id as course_number_id',
                'courses.department_id as department_id',
                'typecourses.id as type_courses_id',
                'typecourses.*'
                )
                ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
                ->where('courses.department_id', $id)
                ->where('courses.ch_status', 1)
                ->where('courses.set_type_c', 0)
                ->orderBy('courses.sort_corse', 'asc')
                ->paginate(10);

                foreach ($course as $obj) {

                  date_default_timezone_set("Asia/Bangkok");
                  $data_toview['datatime'] = date("Y-m-d");




                    $optionsRes = [];
                    $options = DB::table('submitcourses')->select(
                      'submitcourses.*'
                      )
                      ->where('submitcourses.course_id', $obj->course_number_id)
                      ->first();






                    if($options != null){
                      //$obj->options = $options->status;
                      $obj->options = 0;
                    }else{
                      $obj->options = 0;
                    }


                }



                foreach ($course as $obj) {
                    $optionsRes = [];
                    $options = DB::table('video_lists')->select(
                      'video_lists.*'
                      )
                      ->where('video_lists.course_id', $obj->course_number_id)
                      ->orderBy('video_lists.order_sort', 'asc')
                      ->get();

                      $obj->options = 0;
                      if($options != null){
                        $obj->video_lists = $options;
                      }else{
                        $obj->video_lists = null;
                      }

                      $urlpath = 'assets/excel/'.$obj->url_course;
                    //  $urlpath = file_get_contents($urlpath);
               // header('Content-Type: text/html; charset=utf-8');
                 $urlpath =  utf8_encode($urlpath);
               $urlpath = iconv("TIS-620", "utf-8", $urlpath);

              //$urlpath = trim($urlpath);
              $html_code = "<div></div>";
              $s = 0;
              $completeflag = false;
                 $f = fopen($urlpath, "r");

                 $tmpString = "";

                 while (($line = fgetcsv($f)) !== false) {
                         foreach ($line as $cell) {

                          //  $optionsRes[$s] = "<tr><td>" . htmlspecialchars($cell) . "</td></tr>";
                          if($s%2 == 0){
                            $tmpString = $tmpString . "<tr><td style='text-align:left;'><font size='2' color='gray'>" . htmlspecialchars($cell)."</font></td>";
                            $completeflag = false;
                          }else{
                            $tmpString = $tmpString ."<td style='text-align:right;'><font size='2' color='gray'>". htmlspecialchars($cell) . "</font></td></tr>";
                            $completeflag = true;
                          }
                                $s++;
                         }
                    //final string
                    if($completeflag == true){
                        $html_code = "<div><table border=1 width='100%'>" . $tmpString . '</table></div>';
                    }else{
                      //save loss column
                        $html_code = "<div><table border=1 width='100%'>" . $tmpString . '<td></td></tr></table></div>';
                    }
                 }
                 fclose($f);
                 $obj->coursedetails_htmlcode = $html_code;

                }







        }else{





          $course = DB::table('courses')
              ->select(
              'courses.*',
              'courses.id as course_number_id',
              'courses.department_id as department_id',
              'typecourses.id as type_courses_id',
              'typecourses.*'
              )
              ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
              ->where('courses.type_course', $type_courses_id)
              ->where('courses.department_id', $id)
              ->where('courses.set_type_c', 0)
              ->orderBy('courses.sort_corse', 'asc')
              ->paginate(10);

              foreach ($course as $obj) {
                  $optionsRes = [];
                  $options = DB::table('submitcourses')->select(
                    'submitcourses.*'
                    )
                    ->where('submitcourses.course_id', $obj->course_number_id)
                    ->first();


                    if($options != null){
                      //$obj->options = $options->status;
                      $obj->options = 0;
                    }else{
                      $obj->options = 0;
                    }

              }


              foreach ($course as $obj) {
                  $optionsRes = [];
                  $options = DB::table('video_lists')->select(
                    'video_lists.*'
                    )
                    ->where('video_lists.course_id', $obj->course_number_id)
                    ->orderBy('video_lists.order_sort', 'asc')
                    ->get();

                    $obj->options = 0;
                    if($options != null){
                      $obj->video_lists = $options;
                    }else{
                      $obj->video_lists = null;
                    }

                    $urlpath = 'assets/excel/'.$obj->url_course;
                  //  $urlpath = file_get_contents($urlpath);
             // header('Content-Type: text/html; charset=utf-8');
               $urlpath =  utf8_encode($urlpath);
             $urlpath = iconv("TIS-620", "utf-8", $urlpath);

            //$urlpath = trim($urlpath);
            $html_code = "<div></div>";
            $s = 0;
            $completeflag = false;
               $f = fopen($urlpath, "r");

               $tmpString = "";

               while (($line = fgetcsv($f)) !== false) {
                       foreach ($line as $cell) {

                        //  $optionsRes[$s] = "<tr><td>" . htmlspecialchars($cell) . "</td></tr>";
                        if($s%2 == 0){
                          $tmpString = $tmpString . "<tr><td style='text-align:left;'><font size='2' color='gray'>" . htmlspecialchars($cell)."</font></td>";
                          $completeflag = false;
                        }else{
                          $tmpString = $tmpString ."<td style='text-align:right;'><font size='2' color='gray'>". htmlspecialchars($cell) . "</font></td></tr>";
                          $completeflag = true;
                        }
                              $s++;
                       }
                  //final string
                  if($completeflag == true){
                      $html_code = "<div><table border=1 width='100%'>" . $tmpString . '</table></div>';
                  }else{
                    //save loss column
                      $html_code = "<div><table border=1 width='100%'>" . $tmpString . '<td></td></tr></table></div>';
                  }
               }
               fclose($f);
               $obj->coursedetails_htmlcode = $html_code;

              }





        }





      return response()->json(['status'=>200, 'message' => 'success', 'data' => ['course' => $course, 'video_root_path' => 'http://150.107.31.28:10000/stream/'] ]);

    }


    public function _static($id){
      $objs = DB::table('courses')
          ->select(
          'courses.*',
          'courses.id as course_number_id',
          'typecourses.*'
          )
          ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
          ->where('typecourses.id', 1)
          ->where('courses.department_id', $id)
          ->where('courses.set_type_c', 0)
          ->orderBy('courses.sort_corse', 'asc')
          ->paginate(12);

      return response()->json(['status'=>200, 'message' => 'success', 'data' => $objs]);
    }


    public function get_course_online($id){
      $objs = DB::table('courses')
          ->select(
          'courses.*',
          'courses.id as course_number_id',
          'typecourses.*'
          )
          ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
          ->where('typecourses.id', 2)
          ->where('courses.department_id', $id)
          ->where('courses.ch_status', 1)
          ->where('courses.set_type_c', 0)
          ->orderBy('courses.sort_corse', 'asc')
          ->paginate(12);

      return response()->json(['status'=>200, 'message' => 'success', 'data' => $objs]);
    }


    public function get_course_info(Request $request, $id)
    {

      if(empty($request['token'])){

        $courseinfo = course::find($id);
        $count_course = DB::table('submitcourses')
          ->select(
             'submitcourses.*'
             )
          ->where('submitcourses.course_id', $id)
          ->count();

          $comment_course = DB::table('comments')
            ->select(
               'comments.*',
               'comments.id as c_id',
               'comments.created_at as created_att',
               'users.*',
               'users.id as u_id'
               )
            ->leftjoin('users', 'users.id', '=', 'comments.user_id')
            ->where('comments.course_id', $id)
            ->get();

          return response()->json(['status'=>200, 'message' => 'success', 'data' => ['get_course_info' => $courseinfo, 'count_course' => $count_course, 'comment_course' => $comment_course, 'status_course' => 0] ]);

      }else{

        $user = JWTAuth::toUser($request['token']);
        $courseinfo = course::find($id);

        $count_course = DB::table('submitcourses')
          ->select(
             'submitcourses.*'
             )
          ->where('submitcourses.course_id', $id)
          ->count();

          $check_my_course = DB::table('submitcourses')
            ->select(
               'submitcourses.*'
               )
            ->where('submitcourses.course_id', $id)
            ->where('submitcourses.user_id', $user->id)
            ->count();
          if($check_my_course == 1){
            $count_my_course = DB::table('submitcourses')
              ->select(
                 'submitcourses.*'
                 )
              ->where('submitcourses.course_id', $id)
              ->where('submitcourses.user_id', $user->id)
              ->first();
              $count_my_course = $count_my_course->status;
          }else{
              $count_my_course = 0;
          }



          $comment_course = DB::table('comments')
            ->select(
               'comments.*',
               'comments.id as c_id',
               'comments.created_at as created_att',
               'users.*',
               'users.id as u_id'
               )
            ->leftjoin('users', 'users.id', '=', 'comments.user_id')
            ->where('comments.course_id', $id)
            ->get();

          return response()->json(['status'=>200, 'message' => 'success', 'data' => ['get_course_info' => $courseinfo, 'count_course' => $count_course, 'comment_course' => $comment_course, 'status_course' => $count_my_course ] ]);





      }




      }

    public function check_coupon(Request $request){

      $user = JWTAuth::toUser($request->token);
      $coupon = $request->coupon;
      $course_id = $request->course_id;


      $get_coupon_count = DB::table('coupons')
          ->select(
          'coupons.*'
          )
          ->where('c_code', $request->coupon)
          ->count();

          $get_coupon = DB::table('coupons')
              ->select(
              'coupons.*'
              )
              ->where('c_code', $request->coupon)
              ->first();


              $get_cource = DB::table('courses')
                  ->select(
                  'courses.price_course',
                  'courses.id'
                  )
                  ->where('id', $course_id)
                  ->first();

            //  max_price = course

          if($get_coupon_count > 0){






            $check_limit = DB::table('coupon_users')
                ->select(
                'coupon_users.*'
                )
                ->where('c_id', $get_coupon->id)
                ->where('coupon_status', 1)
                ->count();


                if($check_limit >= $get_coupon->c_max){

                  return response()->json(['status'=>100, 'message' => 'เสียใจด้วย Coupon ได้ถูกใช้ไปหมดแล้ว', 'data' => NULL]);

                }else{






                  if($course_id == $get_coupon->c_price_product){


                    $obj = new coupon_user();
                    $obj->user_id = $user->id;
                    $obj->c_id = $get_coupon->id;
                    $obj->save();


                    if($get_coupon->c_type == 1){

                      $obj->coupon_type_base = "percent";

                      $obj->coupon_price = (($get_cource->price_course*$get_coupon->c_price)/100);

                    }else{
                      $obj->coupon_type_base = "baht";
                      $obj->coupon_price = $get_coupon->c_price;
                    }










                    return response()->json(['status'=>200, 'message' => 'คุณสามารถใช้ Coupon นี้ได้', 'data' => $obj]);

                  }else{




                    if($get_coupon->c_price_product == 0){





                      $get_coupons = DB::table('coupons')
                          ->select(
                          'coupons.*'
                          )
                          ->where('c_code', $request->coupon)
                          ->first();

                          $sum_price_type = 0;


                          //  $sum_price_type = (($get_cource->price_course*$get_coupon->c_price)/100);

                          //  Session::put('coupon', ['code' => $get_coupon->c_code, 'id' => $get_coupon->id, 'price' => $sum_price_type, 'course' => $get_coupon->c_price_product, 'type' => 1]);
                            $obj = new coupon_user();
                            $obj->user_id = $user->id;
                            $obj->c_id = $get_coupon->id;
                          //  $obj->order_id = $request->order_id;
                            $obj->save();


                          if($get_coupon->c_type == 1){
                            $obj->coupon_type_base = "percent";
                            $sum_price_type = (($get_cource->price_course*$get_coupon->c_price)/100);

                          }else{
                            $obj->coupon_type_base = "baht";
                            $sum_price_type = $get_coupon->c_price;
                          }





                          $obj->coupon_price = $sum_price_type;

                      return response()->json(['status'=>200, 'message' => 'คุณสามารถใช้ Coupon นี้ได้', 'data' => $obj]);

                    }else{


                      return response()->json(['status'=>100, 'message' => 'คุณไม่สามารถใช้ Coupon นี้ได้ Coupon กับ Course ไม่ตรงกับที่ระบุไว้', 'data' => NULL]);

                    }









                  }








                }





          }else{

            return response()->json(['status'=>100, 'message' => 'คุณไม่สามารถใช้ Coupon นี้ได้', 'data' => NULL]);

          }


    }

    public function update_user_details(Request $request){

      $name = $request['nickname'];
      $email = $request['email'];
      $image = $request->file('image');


    	$user = JWTAuth::toUser($request['token']);

      if($name == NULL || $email == NULL){
        return response()->json(['status'=>100, 'message' => 'nickname AND email NULL', 'data' => NULL]);
      }

      if($image == NULL){

      $id = $request['id'];
      $package = User::find($user->id);
      $package->name = $request['nickname'];
      $package->email = $request['email'];
      $package->hbd = $request['hbd'];
      $package->phone = $request['phone'];
      $package->address = $request['address'];
      $package->line_id = $request['line_id'];
      $package->bio = $request['bio'];

    }else{

      $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

       $destinationPath = asset('assets/images/avatar');
       $img = Image::make($image->getRealPath());
       $img->resize(300, null, function ($constraint) {
       $constraint->aspectRatio();
     })->save('assets/images/avatar/'.$input['imagename'], 50);

      $package = users::find($user->id);
      $package->avatar = $input['imagename'];
      $package->name = $request['nickname'];
      $package->email = $request['email'];
      $package->hbd = $request['hbd'];
      $package->phone = $request['phone'];
      $package->address = $request['address'];
      $package->line_id = $request['line_id'];
      $package->bio = $request['bio'];

    }

      if($package->save()){

        $get_data_user = DB::table('users')
          ->select(
             'users.*'
             )
          ->where('users.id', $user->id)
          ->first();

        return response()->json(['status'=>200, 'message' => 'success', 'data' => $get_data_user]);
      }else{
        return response()->json(['status'=>100, 'message' => 'wrong data', 'data' => NULL]);
      }
    }



    public function update_onesignal_info(Request $request){

      $playerid = $request['playerid'];




    	$user = JWTAuth::toUser($request['token']);

      if($playerid == NULL){
        return response()->json(['status'=>100, 'message' => 'Playerid NULL', 'data' => NULL]);
      }



      $id = $request['id'];
      $package = User::find($user->id);
      $package->playerid = $request['playerid'];


      if($package->save()){

        $get_data_user = DB::table('users')
          ->select(
             'users.*'
             )
          ->where('users.id', $user->id)
          ->first();

        return response()->json(['status'=>200, 'message' => 'success', 'data' => $get_data_user]);
      }else{
        return response()->json(['status'=>100, 'message' => 'wrong data', 'data' => NULL]);
      }
    }


    public function get_data_confirm_course(Request $request, $id)
    {
    	$input = $request->all();
    	$user = JWTAuth::toUser($input['token']);

      $bank = DB::table('banks')
        ->get();

      $count_course = DB::table('submitcourses')
        ->select(
           'submitcourses.*',
           'submitcourses.id as sub_id'
           )
        ->where('submitcourses.user_id', $user->id)
        ->where('submitcourses.course_id', $id)
        ->first();


        if(isset($count_course)){

          if($count_course->status == 1){

            return response()->json(['status' => 100, 'message' => 'Waiting for inspection', 'data' => $count_course]);

          }else if($count_course->status == 2){

            return response()->json(['status' => 101, 'message' => 'This course is in your system.', 'data' => $count_course]);

          }else{
            return response()->json(['status' => 200, 'message' => 'success', 'data' => [ 'bank' => $bank, 'course_info' => $count_course ] ]);
          }

        }else{

          return response()->json(['status' => 1004, 'message' => 'error data', 'data' => NULL]);

        }


    }



    public function confirm_course(Request $request, $id)
    {
      $hbd = $request->get('hbd');
      if($hbd == '0000-00-00'){
          return response()->json(['status'=>100, 'message' => 'Please insert your birthday!', 'data' => NULL]);
      }
      if($hbd == NULL){
          return response()->json(['status'=>100, 'message' => 'Please insert your birthday!', 'data' => NULL]);
      }
      $phone = $request->get('phone');
      if($phone == NULL){
        return response()->json(['status'=>100, 'message' => 'Please insert your phone!', 'data' => NULL]);

      }
      $line = $request->get('line');
      if($line == NULL){
        return response()->json(['status'=>100, 'message' => 'Please insert your LineID!', 'data' => NULL]);

      }
      $user_id = $request['user_id'];

      $package = User::find($user_id);
      $package->hbd = $hbd;
      $package->phone = $phone;
      $package->line_id = $line;
      $package->save();


       $countobj = DB::table('submitcourses')
         ->select(
            'submitcourses.*'
            )
         ->where('submitcourses.user_id', $user_id)
         ->where('submitcourses.course_id', $id)
         ->count();



     if($countobj > 0){

        $getc = DB::table('submitcourses')
          ->select(
             'submitcourses.*'
             )
          ->where('submitcourses.user_id', $user_id)
          ->where('submitcourses.course_id', $id)
          ->first();

        //  dd($getc->Oid);

        $coursess = DB::table('submitcourses')
          ->select(
             'submitcourses.*',
             'submitcourses.user_id as Uid',
             'submitcourses.id as Oid',
             'users.*',
             'courses.*'
             )
          ->where('submitcourses.user_id', $user_id)
          ->where('submitcourses.id', $getc->id)
          ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
          ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
          ->first();

      //  dd($data);

      return response()->json(['status'=>100, 'message' => 'This course has already been used.', 'data' => $coursess]);

      } else{

        $package = new submitcourse();
        $package->user_id = $user_id;
        $package->course_id = $id;
        $package->save();

        $the_id = $package->id;


        $coursess = DB::table('submitcourses')
          ->select(
             'submitcourses.*',
             'submitcourses.user_id as Uid',
             'submitcourses.id as Oid',
             'users.*',
             'courses.*'
             )
          ->where('submitcourses.user_id', $user_id)
          ->where('submitcourses.id', $the_id)
          ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
          ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
          ->first();


          return response()->json(['status'=>200, 'message' => 'success', 'data' => $coursess]);


      }




    }

    public function submiy_course_free(Request $request){

      $input = $request->all();
      $course_id = $request->get('course_id');
    	$user = JWTAuth::toUser($input['token']);

      $countobj = DB::table('submitcourses')
        ->select(
           'submitcourses.*',
           'submitcourses.id as sub_id)'
           )
        ->where('submitcourses.user_id', $user->id)
        ->where('submitcourses.course_id', $course_id)
        ->count();

        if($countobj > 0){
            return response()->json(['status'=>100, 'message' => 'This course has already been used.', 'data' =>NULL]);
        }else{

          $package = new submitcourse();
          $package->user_id = $user->id;
          $package->course_id = $course_id;
          $package->status = 2;
          $package->save();


          $the_id = $package->id;


            $coursess = DB::table('submitcourses')
              ->select(
                 'submitcourses.*',
                 'submitcourses.user_id as Uid',
                 'submitcourses.id as Oid',
                 'users.*',
                 'courses.*'
                 )
              ->where('submitcourses.user_id', $user->id)
              ->where('submitcourses.id', $the_id)
              ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
              ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
              ->first();

          return response()->json(['status' => 200, 'message' => 'Submit course free success.', 'data' => $coursess]);

        }

    }



    public function bil_course(Request $request){

      $coupon_id = $request->get('coupon_id');

    //  dd($coupon_id);

      $bankname = $request->get('bankname');
      if($bankname == NULL){
          return response()->json(['status'=>100, 'message' => 'Please insert your bankname!', 'data' =>NULL]);

      }
      $totalmoney = $request->get('totalmoney');
      if($totalmoney == NULL){
          return response()->json(['status' => 101, 'message' => 'Please insert your totalmoney!', 'data' =>NULL]);
      }

      $day = $request->get('day');
      if($day == NULL){
          return response()->json(['status' => 102, 'message' => 'Please insert your Day transfer!', 'data' =>NULL]);
      }
      $timer = $request->get('timer');
      if($timer == NULL){
          return response()->json(['status' => 103, 'message' => 'Please insert your Timer transfer!', 'data' =>NULL]);
      }



      $input = $request->all();
      $course_id = $request->get('course_id');
    	$user = JWTAuth::toUser($input['token']);

      $countobj = DB::table('submitcourses')
        ->select(
           'submitcourses.*',
           'submitcourses.id as sub_id)'
           )
        ->where('submitcourses.user_id', $user->id)
        ->where('submitcourses.course_id', $course_id)
        ->count();




        if($countobj > 0){
            return response()->json(['status'=>100, 'message' => 'This course has already been used.', 'data' =>NULL]);
        }else{

          $image = $request->file('image');


         if($image == NULL){

          $package = new submitcourse();
          $package->user_id = $user->id;
          $package->course_id = $course_id;
          $package->bank_id = $request['bankname'];
          $package->money_tran = $request['totalmoney'];
          $package->date_tran = $request['day'];
          $package->time_tran = $request['timer'];
          $package->status = 1;
          $package->save();

            if($coupon_id == null || $coupon_id == 0){

            }else{


              $id = $coupon_id;
              $obj = coupon_user::find($id);
              $obj->order_id = $package->id;
              $obj->save();

            }




        }else{

          $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

           $img = Image::make($image->getRealPath());
           $img->resize(500, 500, function ($constraint) {
           $constraint->aspectRatio();
         })->save('assets/bill/'.$input['imagename']);



         $input['imagename_small'] = time().'_small.'.$image->getClientOriginalExtension();

          $img = Image::make($image->getRealPath());
          $img->resize(240, 240, function ($constraint) {
          $constraint->aspectRatio();
        })->save('assets/bill/'.$input['imagename_small']);



         $package = new submitcourse();
         $package->user_id = $user->id;
         $package->course_id = $course_id;
         $package->bank_id = $request['bankname'];
         $package->money_tran = $request['totalmoney'];
         $package->date_tran = $request['day'];
         $package->time_tran = $request['timer'];
         $package->status = 1;
         $package->bill_image = $input['imagename'];
         $package->bill_image_small = $input['imagename_small'];
         $package->save();


         if($coupon_id == null || $coupon_id == 0){

         }else{


           $id = $coupon_id;
           $obj = coupon_user::find($id);
           $obj->order_id = $package->id;
           $obj->save();

         }


        }

        $the_id = $package->id;


          $coursess = DB::table('submitcourses')
            ->select(
               'submitcourses.*',
               'submitcourses.user_id as Uid',
               'submitcourses.id as Oid',
               'users.*',
               'banks.*',
               'courses.*',
               'courses.id as id_cource'
               )
            ->where('submitcourses.user_id', $user->id)
            ->where('submitcourses.id', $the_id)
            ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
            ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
            ->leftjoin('banks', 'banks.id', '=', 'submitcourses.bank_id')
            ->first();


            $check_coupon = DB::table('coupon_users')
                ->select(
                'coupon_users.*'
                )
                ->where('order_id', $coursess->Oid)
                ->count();

                $get_cource = DB::table('courses')
                    ->select(
                    'courses.price_course',
                    'courses.id'
                    )
                    ->where('id', $coursess->id_cource)
                    ->first();

                if($check_coupon > 0){



                  $get_coupon = DB::table('coupon_users')
                      ->select(
                      'coupon_users.*'
                      )
                      ->where('order_id', $coursess->Oid)
                      ->first();

 //discount_price

                      $get_coupon_master = DB::table('coupons')
                          ->select(
                          'coupons.*'
                          )
                          ->where('id', $get_coupon->c_id)
                          ->first();


                          if($get_coupon_master->c_type == 1){

                            $send_price = (($get_cource->price_course*$get_coupon_master->c_price)/100);

                            $coursess->discount_price = $send_price;

                          }else{


                            $send_price = $get_coupon_master->c_price;

                           $coursess->discount_price = $send_price;

                          }


                }else{

                  $coursess->discount_price = 0;

                }





            // send email
              $data_toview = array();
            //  $data_toview['pathToImage'] = "assets/image/email-head.jpg";
              date_default_timezone_set("Asia/Bangkok");
              $data_toview['data'] = $coursess;
              $data_toview['datatime'] = date("d-m-Y H:i:s");

              $email_sender   = 'learnsbuy@gmail.com';
              $email_pass     = 'Ayumusiam168';

          /*    $email_sender   = 'info@acmeinvestor.com';
              $email_pass     = 'Iaminfoacmeinvestor';  */
              $email_to       =  $coursess->email;
              //echo $admins[$idx]['email'];
              // Backup your default mailer
              $backup = \Mail::getSwiftMailer();

              try{

                          //https://accounts.google.com/DisplayUnlockCaptcha
                          // Setup your gmail mailer
                          $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'SSL');
                          $transport->setUsername($email_sender);
                          $transport->setPassword($email_pass);

                          // Any other mailer configuration stuff needed...
                          $gmail = new Swift_Mailer($transport);

                          // Set the mailer as gmail
                          \Mail::setSwiftMailer($gmail);

                          $data['emailto'] = $email_sender;
                          $data['sender'] = $email_to;
                          //Sender dan Reply harus sama

                          Mail::send('mails.index', $data_toview, function($message) use ($data)
                          {
                              $message->from($data['sender'], 'Learnsbuy');
                              $message->to($data['sender'])
                              ->replyTo($data['sender'], 'Learnsbuy.')
                              ->subject('ใบเสร็จสำหรับการสั่งซื้อคอร์สเรียน Learnsbuy ');

                              //echo 'Confirmation email after registration is completed.';
                          });



                          Mail::send('mails.index', $data_toview, function($message) use ($data)
                          {
                              $message->from($data['sender'], 'Learnsbuy');
                              $message->to($data['emailto'])
                              ->replyTo($data['sender'], 'Learnsbuy.')
                              ->subject('ใบเสร็จสำหรับการสั่งซื้อคอร์สเรียน Learnsbuy ');

                              //echo 'Confirmation email after registration is completed.';
                          });

              }catch(\Swift_TransportException $e){
                  $response = $e->getMessage() ;
                  echo $response;

              }


              // Restore your original mailer
              Mail::setSwiftMailer($backup);
              // send email



              $message = $user->name." ได้สั่งซื้อคอร์ส : ".$coursess->title_course.", ธนาคาร :".$coursess->bank_name.", ยอดโอน : ".$coursess->money_tran.", ส่วนลด : ".$coursess->discount_price;

              if($image == NULL){

                $message_data = array(
                'message' => $message
                );

              }else{

                $image_thumbnail_url = url('assets/bill/'.$coursess->bill_image_small);  // max size 240x240px JPEG
                $image_fullsize_url = url('assets/bill/'.$coursess->bill_image); //max size 1024x1024px JPEG
                $imageFile = 'copy/240.jpg';
                $sticker_package_id = '';  // Package ID sticker
                $sticker_id = '';    // ID sticker

                $message_data = array(
                'imageThumbnail' => $image_thumbnail_url,
                'imageFullsize' => $image_fullsize_url,
                'message' => $message,
                'imageFile' => $imageFile,
                'stickerPackageId' => $sticker_package_id,
                'stickerId' => $sticker_id
                );

              }


              $lineapi = '0V5h0cJwrMQ0haSxFbmAiCTCVXMxwaRcHX8BoFffR12';
              $headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer '.$lineapi );
              $mms =  trim($message);
              $chOne = curl_init();
              curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
              curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
              curl_setopt($chOne, CURLOPT_POST, 1);
              curl_setopt($chOne, CURLOPT_POSTFIELDS, $message_data);
              curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
              curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
              curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
              $result = curl_exec($chOne);
              if(curl_error($chOne)){
              echo 'error:' . curl_error($chOne);
              }else{
              $result_ = json_decode($result, true);
              echo "status : ".$result_['status'];
              echo "message : ". $result_['message'];
              }
              curl_close($chOne);


              return response()->json(['status' => 200, 'message' => 'success.', 'data' => $coursess]);

        }











    }





    public function get_mycourse(Request $request){
      $input = $request->all();
    	$user = JWTAuth::toUser($input['token']);

    //  dd($user->id);

      $course_confirm = DB::table('submitcourses')
        ->select(
           'submitcourses.*',
           'submitcourses.user_id as Uid',
           'submitcourses.id as Oid',
           'users.*',
           'courses.*',
           'departments.*',
           'typecourses.*'
           )
        ->where('submitcourses.user_id', $user->id)
        ->where('submitcourses.status', 1)
        ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
        ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
        ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
        ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
        ->get();




        $course_finish = DB::table('submitcourses')
          ->select(
             'submitcourses.*',
             'submitcourses.user_id as Uid',
             'submitcourses.id as Oid',
             'users.*',
             'courses.*',
             'departments.*',
             'typecourses.*'
             )
          ->where('submitcourses.user_id', $user->id)
          ->where('submitcourses.status', 2)
          ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
          ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
          ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
          ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
          ->get();



          $course_free = DB::table('submitcourses')
            ->select(
               'submitcourses.*',
               'submitcourses.user_id as Uid',
               'submitcourses.id as Oid',
               'users.*',
               'courses.*',
               'departments.*',
               'typecourses.*'
               )
            ->where('submitcourses.user_id', $user->id)
            ->where('submitcourses.status', 3)
            ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
            ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
            ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
            ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
            ->get();





          foreach ($course_confirm as $obj_con) {
              $obj_con->options = 1;


              $optionsRes = [];
              $options = DB::table('video_lists')->select(
                'video_lists.*'
                )
                ->where('video_lists.course_id', $obj_con->course_id)
                ->orderBy('video_lists.order_sort', 'asc')
                ->get();


                if($options != null){
                  $obj_con->video_lists = $options;
                }else{
                  $obj_con->video_lists = null;
                }

                $urlpath = 'assets/excel/'.$obj_con->url_course;
              //  $urlpath = file_get_contents($urlpath);
         // header('Content-Type: text/html; charset=utf-8');
           $urlpath =  utf8_encode($urlpath);
         $urlpath = iconv("TIS-620", "utf-8", $urlpath);

        //$urlpath = trim($urlpath);
        $html_code = "<div></div>";
        $s = 0;
        $completeflag = false;
           $f = fopen($urlpath, "r");

           $tmpString = "";

           while (($line = fgetcsv($f)) !== false) {
                   foreach ($line as $cell) {

                    //  $optionsRes[$s] = "<tr><td>" . htmlspecialchars($cell) . "</td></tr>";
                    if($s%2 == 0){
                      $tmpString = $tmpString . "<tr><td style='text-align:left;'><font size='2' color='gray'>" . htmlspecialchars($cell)."</font></td>";
                      $completeflag = false;
                    }else{
                      $tmpString = $tmpString ."<td style='text-align:right;'><font size='2' color='gray'>". htmlspecialchars($cell) . "</font></td></tr>";
                      $completeflag = true;
                    }
                          $s++;
                   }
              //final string
              if($completeflag == true){
                  $html_code = "<div><table border=1 width='100%'>" . $tmpString . '</table></div>';
              }else{
                //save loss column
                  $html_code = "<div><table border=1 width='100%'>" . $tmpString . '<td></td></tr></table></div>';
              }
           }
           fclose($f);
           $obj_con->coursedetails_htmlcode = $html_code;

           $obj_con->status = 1;

          }



          foreach ($course_free as $obj) {
              $optionsRes = [];
              $options = DB::table('video_lists')->select(
                'video_lists.*'
                )
                ->where('video_lists.course_id', $obj->course_id)
                ->orderBy('video_lists.order_sort', 'asc')
                ->get();

                $obj->options = 2;
                if($options != null){
                  $obj->video_lists = $options;
                }else{
                  $obj->video_lists = null;
                }


                $urlpath = 'assets/excel/'.$obj->url_course;
              //  $urlpath = file_get_contents($urlpath);
         // header('Content-Type: text/html; charset=utf-8');
           $urlpath =  utf8_encode($urlpath);
         $urlpath = iconv("TIS-620", "utf-8", $urlpath);

        //$urlpath = trim($urlpath);
        $html_code = "<div></div>";
        $s = 0;
        $completeflag = false;
           $f = fopen($urlpath, "r");

           $tmpString = "";

           while (($line = fgetcsv($f)) !== false) {
                   foreach ($line as $cell) {

                    //  $optionsRes[$s] = "<tr><td>" . htmlspecialchars($cell) . "</td></tr>";
                    if($s%2 == 0){
                      $tmpString = $tmpString . "<tr><td style='padding: 8px; text-align:left; border-bottom: 1px solid #ddd;'><font size='2' color='gray'>" . htmlspecialchars($cell)."</font></td>";
                      $completeflag = false;
                    }else{
                      $tmpString = $tmpString ."<td style='padding: 8px; text-align:left; border-bottom: 1px solid #ddd;'><font size='2' color='gray'>". htmlspecialchars($cell) . "</font></td></tr>";
                      $completeflag = true;
                    }
                          $s++;
                   }
              //final string
              if($completeflag == true){
                  $html_code = "<div><table style='border-collapse: collapse;' width='100%'>" . $tmpString . '</table></div>';
              }else{
                //save loss column
                  $html_code = "<div><table style='border-collapse: collapse;' width='100%'>" . $tmpString . '<td></td></tr></table></div>';
              }
           }
           fclose($f);
           $obj->coursedetails_htmlcode = $html_code;

           $obj->status = 2;
          }



          foreach ($course_finish as $obj) {

            date_default_timezone_set("Asia/Bangkok");
            $data_toview['datatime'] = date("Y-m-d");

              $optionsRes = [];
              $options = DB::table('video_lists')->select(
                'video_lists.*'
                )
                ->where('video_lists.course_id', $obj->course_id)
                ->orderBy('video_lists.order_sort', 'asc')
                ->get();

                if($obj->end_day >= $data_toview['datatime']){
                  $obj->expirestatus = 0;
                }else{
                  $obj->expirestatus = 1;
                }



                $obj->options = 2;
                if($options != null){
                  $obj->video_lists = $options;
                }else{
                  $obj->video_lists = null;
                }


                $urlpath = 'assets/excel/'.$obj->url_course;
              //  $urlpath = file_get_contents($urlpath);
         // header('Content-Type: text/html; charset=utf-8');
           $urlpath =  utf8_encode($urlpath);
         $urlpath = iconv("TIS-620", "utf-8", $urlpath);

        //$urlpath = trim($urlpath);
        $html_code = "<div></div>";
        $s = 0;
        $completeflag = false;
           $f = fopen($urlpath, "r");

           $tmpString = "";

           while (($line = fgetcsv($f)) !== false) {
                   foreach ($line as $cell) {

                    //  $optionsRes[$s] = "<tr><td>" . htmlspecialchars($cell) . "</td></tr>";
                    if($s%2 == 0){
                      $tmpString = $tmpString . "<tr><td style='padding: 8px; text-align:left; border-bottom: 1px solid #ddd;'><font size='2' color='gray'>" . htmlspecialchars($cell)."</font></td>";
                      $completeflag = false;
                    }else{
                      $tmpString = $tmpString ."<td style='text-align:right; border-bottom: 1px solid #ddd;'><font size='2' color='gray'>". htmlspecialchars($cell) . "</font></td></tr>";
                      $completeflag = true;
                    }
                          $s++;
                   }
              //final string
              if($completeflag == true){
                  $html_code = "<div><table style='border-collapse: collapse;' width='100%'>" . $tmpString . '</table></div>';
              }else{
                //save loss column
                  $html_code = "<div><table style='border-collapse: collapse;' width='100%'>" . $tmpString . '<td></td></tr></table></div>';
              }
           }
           fclose($f);
           $obj->coursedetails_htmlcode = $html_code;
           $obj->status = 2;
          }





          return response()->json(['status' => 200, 'message' => 'success.', 'data' => [ 'course_finish' => $course_finish, 'course_confirm' => $course_confirm, 'course_free' => $course_free, 'video_root_path' => 'http://150.107.31.28:10000/stream/' ]]);
    }




    public function get_my_radar($id){

      $objs = DB::table('users')
          ->select(
          'users.*'
          )
          ->where('users.id', Auth::user()->id)
          ->first();

      $course_detail = DB::table('examples')->select(
        'examples.*',
        'examples.id as Eid',
        'categories.*'
        )
        ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
        ->where('examples.course_id',$id)
        ->where('categories.id',1)
        ->first();


        return response()->json(['get_my_radar' => $course_detail]);

    }


    public function contact(Request $request){

      $name = $request['name'];
      $email = $request['email'];
      $detail = $request['detail'];
      $phone = $request['phone'];

      if($name == NULL){
          return response()->json(['status'=>100, 'message' => 'Please insert your name!', 'data' =>NULL]);
      }

      if($email == NULL){
          return response()->json(['status'=>100, 'message' => 'Please insert your email!', 'data' =>NULL]);
      }

      if($detail == NULL){
          return response()->json(['status'=>100, 'message' => 'Please insert your detail!', 'data' =>NULL]);
      }


      $package = new contact();
      $package->name = $name;
      $package->email = $email;
      $package->phone = $phone;
      $package->detail = $detail;
      $package->save();


      // send email
        $data_toview = array();
      //  $data_toview['pathToImage'] = "assets/image/email-head.jpg";
        date_default_timezone_set("Asia/Bangkok");
        $data_toview['name'] = $request['name'];
        $data_toview['email'] = $request['email'];
        $data_toview['phone'] = $request['phone'];
        $data_toview['detail'] = $request['detail'];
        $data_toview['datatime'] = date("d-m-Y H:i:s");

        $email_sender   = 'learnsbuy@gmail.com';
        $email_pass     = 'Ayumusiam168';

    /*    $email_sender   = 'info@acmeinvestor.com';
        $email_pass     = 'Iaminfoacmeinvestor';  */
        $email_to       =  $request['email'];
        //echo $admins[$idx]['email'];
        // Backup your default mailer
        $backup = \Mail::getSwiftMailer();

        try{

                    //https://accounts.google.com/DisplayUnlockCaptcha
                    // Setup your gmail mailer
                    $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'SSL');
                    $transport->setUsername($email_sender);
                    $transport->setPassword($email_pass);

                    // Any other mailer configuration stuff needed...
                    $gmail = new Swift_Mailer($transport);

                    // Set the mailer as gmail
                    \Mail::setSwiftMailer($gmail);

                    $data['emailto'] = $email_sender;
                    $data['sender'] = $email_to;
                    //Sender dan Reply harus sama

                    Mail::send('mails.contact', $data_toview, function($message) use ($data)
                    {
                        $message->from($data['sender'], 'มีข้อความจาก learnsabuy');
                        $message->to($data['emailto'])
                        ->replyTo($data['emailto'], 'มีข้อความจาก learnsabuy.')
                        ->subject('มีข้อความจาก learnsabuy.com เข้าสู่ะบบ');

                        //echo 'Confirmation email after registration is completed.';
                    });



        }catch(\Swift_TransportException $e){
            $response = $e->getMessage() ;
            echo $response;

        }


        // Restore your original mailer
        Mail::setSwiftMailer($backup);
        // send email

        return response()->json(['status' => 200, 'message' => 'Send meggage success.', 'data' => [ 'name' => $name, 'email' => $email, 'phone' => $phone, 'detail' => $detail ]]);


    }

    public function user_course_detail(Request $request, $id){

      $input = $request->all();
    	$user = JWTAuth::toUser($input['token']);


      $course_tech = DB::table('categories')->select(
        'categories.id',
        'categories.name_category'
        )
        ->get();


        foreach ($course_tech as $obj) {
            $optionsRes = [];

            $options = DB::table('examples')->select(
              'examples.examples_name',
              'examples.id as Eid'
              )
              ->where('examples.category_id', $obj->id)
              ->where('examples.course_id', $id)
              ->first();

            $optionsRes['examples_name'] = $options;


            if(isset($options)){

              $options_example = DB::table('questions')->select(
                'questions.*'
                )
                ->where('questions.category_id', $options->Eid)
                ->count();

              $optionsRes['count_examples_all'] = $options_example;

            }else{
              $optionsRes['count_examples_all'] = 0;
            }


            $course_chart2 = DB::table('answers')->select(
              'answers.*',
              'examples.*'
              )
              ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
              //->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
              ->where('answers.user_id', $user->id)
              ->where('answers.ans_status', 1)
              ->where('examples.course_id', $id)
              ->where('examples.category_id', $obj->id)
              ->orderBy('answers.id_option', 'desc')
              ->groupBy('answers.id_option')
              ->count();

              $optionsRes['count_ex'] = $course_chart2;

              if($course_chart2 == 0){
                $degree = 0;
              }else{
                $degree = substr((($course_chart2/$options_example*100)/2), 0, 1);
              }

              $optionsRes['degree'] = $degree;

              $obj->options = $optionsRes;

        }




        $course_tech_list = DB::table('examples')->select(
          'examples.*',
          'examples.id as Eid',
          'categories.*'
          )
          ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
          ->where('course_id',$id)
          ->get();


          foreach ($course_tech_list as $obj) {
              $options_item = [];
              $options = DB::table('questions')->select(
                'questions.*'
                )
                ->where('questions.category_id', $obj->Eid)
                ->count();

                   $options_item['count_course_show'] = $options;

              //$obj->options = $options;


              $answers = DB::table('answers')->select(
                'answers.id_option'
                )
                ->where('examples_id', $obj->Eid)
                ->where('user_id', $user->id)
                ->orderBy('id_option', 'desc')
                ->first();

              if(isset($answers)){

                $options_item['sum_point'] = $answers;
              //  $obj->answers = $answers->id_option;
              }else{
                $options_item['sum_point'] = 0;
              }




              $course_chart2 = DB::table('answers')->select(
                'answers.*',
                'examples.*'
                )
                ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                //->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                ->where('answers.user_id', $user->id)
                ->where('answers.ans_status', 1)
                ->where('examples.id', $obj->Eid)
                ->orderBy('answers.id_option', 'desc')
                ->groupBy('answers.id_option')
                ->count();



                $options_item['count_ex'] = $course_chart2;


              $obj->options = $options_item;

          }


          $course_finish = DB::table('submitcourses')
            ->select(
               'submitcourses.*',
               'submitcourses.user_id as Uid',
               'submitcourses.id as Oid',
               'courses.*'
               )
            ->where('submitcourses.user_id', $user->id)
            ->where('submitcourses.status', 2)
            ->where('courses.id', $id)
            ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
            ->first();

            date_default_timezone_set("Asia/Bangkok");
            $data_toview['datatime'] = date("Y-m-d");


                if($course_finish->end_day >= $data_toview['datatime']){
                  $course_finish->expirestatus = 0;
                }else{
                  $course_finish->expirestatus = 1;
                }



        return response()->json(['status' => 200, 'message' => 'success.', 'data' => [ 'graph' => $course_tech, 'example_list' => $course_tech_list, 'course_detail' => $course_finish ] ]);
    }


    public function ans_detail(Request $request){

      $id = $request['id'];
      $input = $request->all();
    	$user = JWTAuth::toUser($request['token']);

      $course_detail = DB::table('examples')->select(
        'examples.*',
        'examples.id as Eid',
        'categories.*'
        )
        ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
        ->where('examples.id',$id)
        ->first();

      $course_tech = DB::table('questions')->select(
        'questions.*',
        'questions.category_id as Example_id'
        )
        ->where('questions.category_id',$id)
        ->get();


        foreach ($course_tech as $obj) {
            $optionsRes = [];
            $options = DB::table('options')->select(
              'options.*'
              )
              ->where('options.question_id', $obj->id_questions)
              ->get();

            $obj->options = $options;

        }

        $set_count = DB::table('answers')->select(
          'answers.*'
          )
          ->where('answers.user_id', $user->id)
          ->orwhere('answers.examples_id', $course_detail->Eid)
          ->orderBy('answers.id_option', 'desc')
          ->first();

          $ranId = rand(100000,999999);
          while (true) {
            $dupId = answer::where('id_option', $ranId)->first();
            if (isset($dupId)) {
                $ranId = rand(100000,999999);
            }
            else {
              break;
            }
          }
          $id_option_num = 'learnsbuy-'.$ranId;


        /*  if($set_count == NULL){
            $id_option_num = 1;
          }else{
            $id_option_num = $set_count->id_option+1;

          } */


        return response()->json(['status' => 200, 'message' => 'success.', 'data' => [ 'examples_detail' => $course_detail, 'ans_detail' => $course_tech, 'setpoint' => $id_option_num ]]);

    }



    public function ans_detail_post(Request $request)
    {

      $input = $request->all();
    	$user = JWTAuth::toUser($input['token']);


      $examples_id = $request['examples_id'];
      $id_questions = $request['question_id'];
      $id_option_num = $request['setpoint'];
      $examples_type = $request['examples_type'];
      $value = $request['value'];



      $course_tech = DB::table('questions')->select(
        'questions.*'
        )
        ->where('questions.id_questions',$id_questions)
        ->first();

        //dd($course_tech);

        $set_count = DB::table('answers')->select(
          'answers.*'
          )
          ->where('answers.user_id', $user->id)
          ->orwhere('answers.examples_id', $examples_id)
          ->orderBy('answers.id_option', 'desc')
          ->first();
      //  $input = $request->all();

        //  dd($set_count);




      $num = $id_option_num;

      if($examples_type == 1){

        $setpoints = DB::table('setpoints')->select(
          'setpoints.*'
          )
          ->where('setpoints.id_option_p',$num)
          ->count();

          if($setpoints == 0 || $setpoints == NULL){

            $set = new setpoint();
            $set->examples_id_p  = $examples_id;
            $set->id_option_p = $num;
            $set->user_id = $user->id;
            $set->save();

          }

      }


    if($course_tech){


        if($course_tech->status == $value && $examples_type == 2){
          $payment = new answer();
          $payment->examples_id  = $examples_id;
          $payment->user_id = $user->id;
          $payment->question_id = $id_questions;
          $payment->id_option = $num;
          $payment->answers = $value;
          $payment->ans_status = 1;
          $payment->save();

          $the_id = $payment->id_option;
        }else{
          $payment = new answer();
          $payment->examples_id  = $examples_id;
          $payment->user_id = $user->id;
          $payment->question_id = $id_questions;
          $payment->id_option = $num;
          $payment->answers = $value;
          $payment->ans_status = 0;
          $payment->save();

          $the_id = $payment->id_option;
        }




      }

      $course_tech = DB::table('answers')->select(
        'answers.*'
        )
        ->where('answers.user_id', $user->id)
        ->where('answers.examples_id', $examples_id)
        ->where('answers.ans_status', 1)
        ->where('answers.id_option', $the_id)
        ->count();

        return response()->json(['status' => 200, 'message' => 'success.', 'data' => $course_tech]);

    }



    public function success_ans(Request $request)
    {

      $input = $request->all();
    	$user = JWTAuth::toUser($input['token']);

      $setpoint = $request['setpoint'];

      $course_tech_get = DB::table('questions')->select(
        'questions.*',
        'answers.question_id',
        'answers.answers',
        'answers.ans_status'
        )
        ->leftjoin('answers', 'questions.id_questions', '=', 'answers.question_id')
        ->where('answers.id_option',$setpoint)
        ->first();


        $course_detail = DB::table('examples')->select(
          'examples.*',
          'examples.id as Eid',
          'examples.created_at as created_at_date',
          'categories.id as Cid',
          'categories.*'
          )
          ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
          ->where('examples.id',$course_tech_get->category_id)
          ->first();


          $course_tech_count_all = DB::table('answers')->select(
            'answers.*'
            )
            ->where('answers.user_id', $user->id)
            ->where('answers.examples_id', $course_tech_get->category_id)
            ->where('answers.id_option',$setpoint)
            ->count();

            $course_tech_count = DB::table('answers')->select(
              'answers.*'
              )
              ->where('answers.user_id', $user->id)
              ->where('answers.examples_id', $course_tech_get->category_id)
              ->where('answers.ans_status', 1)
              ->where('answers.id_option',$setpoint)
              ->count();

        return response()->json(['status' => 200, 'message' => 'success.', 'data' => ['course_detail' => $course_detail, 'total_example' => $course_tech_count_all, 'sum_point' => $course_tech_count]]);

    }



    public function get_look_course(Request $request, $id)
    {
      $input = $request->all();
    	$user = JWTAuth::toUser($input['token']);

      $courseinfo = course::find($id);

      $count_course = DB::table('submitcourses')
        ->select(
           'submitcourses.*'
           )
        ->where('submitcourses.course_id', $id)
        ->where('submitcourses.user_id', $user->id)
        ->count();

        if($count_course == 1){
          return response()->json(['status'=>100, 'message' => 'คอร์สนี้มีการจองไว้', 'data' => 'คอร์สนี้มีการจองไว้' ]);
        }else{
          return response()->json(['status'=>200, 'message' => 'success', 'data' => ['user' => $user, 'courseinfo' => $courseinfo] ]);
        }

    }


    public function get_bank(){
      $bank = DB::table('banks')
        ->get();

        return response()->json(['status'=>200, 'message' => 'success', 'data' => $bank ]);
    }


    public function display_ans_success(Request $request)
    {
      $input = $request->all();
    	$user = JWTAuth::toUser($input['token']);

      $setpoint = $request['setpoint'];

      $course_tech = DB::table('questions')->select(
        'questions.*',
        'questions.status as correct_ans',
        'answers.question_id',
        'answers.answers as my_ans',
        'answers.ans_status'
        )
        ->leftjoin('answers', 'questions.id_questions', '=', 'answers.question_id')
        ->where('answers.id_option',$setpoint)
        ->where('answers.user_id', $user->id)
        ->get();

        foreach ($course_tech as $obj) {
            $optionsRes = [];
            $options = DB::table('options')->select(
              'options.*'
              )
              ->where('options.question_id', $obj->id_questions)
              ->get();

            $obj->options = $options;

        }

        return response()->json(['status'=>200, 'message' => 'success', 'data' => $course_tech ]);
    }


    public function get_my_message(Request $request)
    {

      $input = $request->all();
    	$user = JWTAuth::toUser($input['token']);

      $objs = DB::table('messages')
          ->select(
          'messages.*'
          )
          ->where('chat_user_id', $user->id)
          ->orwhere('agent_id', $user->id)
          ->orderBy('id', 'desc')
          ->paginate(12);


          foreach ($objs as $obj) {
              $optionsRes = [];
              $options = DB::table('users')->select(
                'users.*'
                )
                ->where('users.id', $obj->chat_user_id)
                ->first();

                if($obj->chat_user_id == $user->id){
                  $obj->my_chat = 1;
                }else{
                  $obj->my_chat = 0;
                }

              $obj->options = $options;

          }



          $optionsRes_admin = [];

            //  $optionsRes = [];
              $options_admin = DB::table('users')->select(
                'users.playerid'
                )
                ->where('users.is_admin', 1)
                ->get();

                foreach ($options_admin as $obj) {



                    $obj->admin['playerid'] = $obj->playerid;
                }

              //  $optionsRes[] = $options;




      return response()->json(['status'=>200, 'message' => 'success', 'data' => ['data' => $objs, 'playerid_list_admin' => [$options_admin]] ]);

    }


    public function get_course_state(Request $request)
    {
      $input = $request->all();
    	$user = JWTAuth::toUser($input['token']);

      $course_chart1 = DB::table('answers')->select(
        DB::raw(' max(answers.id_option) as id_optionss'),
        'answers.*',
        'examples.*',
        'categories.*'
        )
        ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
        ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
        ->where('answers.user_id', $user->id)
        ->where('examples.course_id', $input['course_id'])
        ->where('categories.id', 1)
        ->orderBy('answers.id_option', 'desc')
        ->groupBy('answers.id_option')
        ->sum('ans_status');

        if($course_chart1 != null){

          $obj_1 = DB::table('answers')->select(
            DB::raw(' max(answers.id_option) as id_optionss'),
            'answers.*',
            'examples.*',
            'categories.*'
            )
            ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
            ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
            ->where('answers.user_id', $user->id)
            ->where('examples.course_id', $input['course_id'])
            ->where('categories.id', 1)
            ->orderBy('answers.id_option', 'desc')
            ->groupBy('answers.id_option')
            ->first();


          $all_options_1 = DB::table('questions')->select(
            'questions.*'
            )
            ->where('questions.category_id', $obj_1->examples_id)
            ->count();

        }else{
          $all_options_1 =null;
        }





        $course_chart2 = DB::table('answers')->select(
          DB::raw(' max(answers.id_option) as id_optionss'),
          'answers.*',
          'examples.*',
          'categories.*'
          )
          ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
          ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
          ->where('answers.user_id', $user->id)
          ->where('examples.course_id', $input['course_id'])
          ->where('categories.id', 2)
          ->orderBy('answers.id_option', 'desc')
          ->groupBy('answers.id_option')
          ->sum('ans_status');

          if($course_chart2 != null){

            $obj_2 = DB::table('answers')->select(
              DB::raw(' max(answers.id_option) as id_optionss'),
              'answers.*',
              'examples.*',
              'categories.*'
              )
              ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
              ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
              ->where('answers.user_id', $user->id)
              ->where('examples.course_id', $input['course_id'])
              ->where('categories.id', 2)
              ->orderBy('answers.id_option', 'desc')
              ->groupBy('answers.id_option')
              ->first();


            $all_options_2 = DB::table('questions')->select(
              'questions.*'
              )
              ->where('questions.category_id', $obj_2->examples_id)
              ->count();

          }else{
            $all_options_2 =null;
          }




          $course_chart3 = DB::table('answers')->select(
            DB::raw(' max(answers.id_option) as id_optionss'),
            'answers.*',
            'examples.*',
            'categories.*'
            )
            ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
            ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
            ->where('answers.user_id', $user->id)
            ->where('examples.course_id', $input['course_id'])
            ->where('categories.id', 3)
            ->orderBy('answers.id_option', 'desc')
            ->groupBy('answers.id_option')
            ->sum('ans_status');

            if($course_chart3 != null){

              $obj_3 = DB::table('answers')->select(
                DB::raw(' max(answers.id_option) as id_optionss'),
                'answers.*',
                'examples.*',
                'categories.*'
                )
                ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                ->where('answers.user_id', $user->id)
                ->where('examples.course_id', $input['course_id'])
                ->where('categories.id', 3)
                ->orderBy('answers.id_option', 'desc')
                ->groupBy('answers.id_option')
                ->first();


              $all_options_3 = DB::table('questions')->select(
                'questions.*'
                )
                ->where('questions.category_id', $obj_3->examples_id)
                ->count();

            }else{
              $all_options_3 =null;
            }





            $course_chart4 = DB::table('answers')->select(
              DB::raw(' max(answers.id_option) as id_optionss'),
              'answers.*',
              'examples.*',
              'categories.*'
              )
              ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
              ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
              ->where('answers.user_id', $user->id)
              ->where('examples.course_id', $input['course_id'])
              ->where('categories.id', 4)
              ->orderBy('answers.id_option', 'desc')
              ->groupBy('answers.id_option')
              ->sum('ans_status');

              if($course_chart4 != null){

                $obj_4 = DB::table('answers')->select(
                  DB::raw(' max(answers.id_option) as id_optionss'),
                  'answers.*',
                  'examples.*',
                  'categories.*'
                  )
                  ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                  ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                  ->where('answers.user_id', $user->id)
                  ->where('examples.course_id', $input['course_id'])
                  ->where('categories.id', 4)
                  ->orderBy('answers.id_option', 'desc')
                  ->groupBy('answers.id_option')
                  ->first();


                $all_options_4 = DB::table('questions')->select(
                  'questions.*'
                  )
                  ->where('questions.category_id', $obj_4->examples_id)
                  ->count();

              }else{
                $all_options_4 =null;
              }





              $course_chart5 = DB::table('answers')->select(
                DB::raw(' max(answers.id_option) as id_optionss'),
                'answers.*',
                'examples.*',
                'categories.*'
                )
                ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                ->where('answers.user_id', $user->id)
                ->where('examples.course_id', $input['course_id'])
                ->where('categories.id', 5)
                ->orderBy('answers.id_option', 'desc')
                ->groupBy('answers.id_option')
                ->sum('ans_status');

                if($course_chart5 != null){

                  $obj_5 = DB::table('answers')->select(
                    DB::raw(' max(answers.id_option) as id_optionss'),
                    'answers.*',
                    'examples.*',
                    'categories.*'
                    )
                    ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                    ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                    ->where('answers.user_id', $user->id)
                    ->where('examples.course_id', $input['course_id'])
                    ->where('categories.id', 5)
                    ->orderBy('answers.id_option', 'desc')
                    ->groupBy('answers.id_option')
                    ->first();


                  $all_options_5 = DB::table('questions')->select(
                    'questions.*'
                    )
                    ->where('questions.category_id', $obj_5->examples_id)
                    ->count();

                }else{
                  $all_options_5 =null;
                }




                $course_chart6 = DB::table('answers')->select(
                  DB::raw(' max(answers.id_option) as id_optionss'),
                  'answers.*',
                  'examples.*',
                  'categories.*'
                  )
                  ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                  ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                  ->where('answers.user_id', $user->id)
                  ->where('examples.course_id', $input['course_id'])
                  ->where('categories.id', 6)
                  ->orderBy('answers.id_option', 'desc')
                  ->groupBy('answers.id_option')
                  ->sum('ans_status');

                  if($course_chart6 != null){

                    $obj_6 = DB::table('answers')->select(
                      DB::raw(' max(answers.id_option) as id_optionss'),
                      'answers.*',
                      'examples.*',
                      'categories.*'
                      )
                      ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                      ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                      ->where('answers.user_id', $user->id)
                      ->where('examples.course_id', $input['course_id'])
                      ->where('categories.id', 6)
                      ->orderBy('answers.id_option', 'desc')
                      ->groupBy('answers.id_option')
                      ->first();


                    $all_options_6 = DB::table('questions')->select(
                      'questions.*'
                      )
                      ->where('questions.category_id', $obj_6->examples_id)
                      ->count();

                  }else{
                    $all_options_6 =null;
                  }






                  $course_chart7 = DB::table('answers')->select(
                    DB::raw(' max(answers.id_option) as id_optionss'),
                    'answers.*',
                    'examples.*',
                    'categories.*'
                    )
                    ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                    ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                    ->where('answers.user_id', $user->id)
                    ->where('examples.course_id', $input['course_id'])
                    ->where('categories.id', 7)
                    ->orderBy('answers.id_option', 'desc')
                    ->groupBy('answers.id_option')
                    ->sum('ans_status');

                    if($course_chart7 != null){

                      $obj_7 = DB::table('answers')->select(
                        DB::raw(' max(answers.id_option) as id_optionss'),
                        'answers.*',
                        'examples.*',
                        'categories.*'
                        )
                        ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                        ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                        ->where('answers.user_id', $user->id)
                        ->where('examples.course_id', $input['course_id'])
                        ->where('categories.id', 7)
                        ->orderBy('answers.id_option', 'desc')
                        ->groupBy('answers.id_option')
                        ->first();


                      $all_options_7 = DB::table('questions')->select(
                        'questions.*'
                        )
                        ->where('questions.category_id', $obj_7->examples_id)
                        ->count();

                    }else{
                      $all_options_7 =null;
                    }




                    $course_chart8 = DB::table('answers')->select(
                      DB::raw(' max(answers.id_option) as id_optionss'),
                      'answers.*',
                      'examples.*',
                      'categories.*'
                      )
                      ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                      ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                      ->where('answers.user_id', $user->id)
                      ->where('examples.course_id', $input['course_id'])
                      ->where('categories.id', 8)
                      ->orderBy('answers.id_option', 'desc')
                      ->groupBy('answers.id_option')
                      ->sum('ans_status');


                      if($course_chart8 != null){

                        $obj_8 = DB::table('answers')->select(
                          DB::raw(' max(answers.id_option) as id_optionss'),
                          'answers.*',
                          'examples.*',
                          'categories.*'
                          )
                          ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                          ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                          ->where('answers.user_id', $user->id)
                          ->where('examples.course_id', $input['course_id'])
                          ->where('categories.id', 8)
                          ->orderBy('answers.id_option', 'desc')
                          ->groupBy('answers.id_option')
                          ->first();


                        $all_options_8 = DB::table('questions')->select(
                          'questions.*'
                          )
                          ->where('questions.category_id', $obj_8->examples_id)
                          ->count();

                      }else{
                        $all_options_8 =null;
                      }



      //  return response()->json(['status'=>200, 'message' => 'success', 'data' => $course_chart]);

      return response()->json(['status'=>200, 'message' => 'success', 'data' => [
        ['category' => 'ไวยากรณ์', 'sum_point' => $course_chart1, 'total_questions' => $all_options_1],
        ['category' => 'คำศัพท์', 'sum_point' => $course_chart2, 'total_questions' => $all_options_2],
        ['category' => 'คันจิ', 'sum_point' => $course_chart3, 'total_questions' => $all_options_3],
        ['category' => 'การสื่อสาร', 'sum_point' => $course_chart4, 'total_questions' => $all_options_4],
        ['category' => 'การอ่าน', 'sum_point' => $course_chart5, 'total_questions' => $all_options_5],
        ['category' => 'การเขียน', 'sum_point' => $course_chart6, 'total_questions' => $all_options_6],
        ['category' => 'การประยุกต์ใช้', 'sum_point' => $course_chart7, 'total_questions' => $all_options_7],
        ['category' => 'ญี่ปุ่นศึกษา', 'sum_point' => $course_chart8, 'total_questions' => $all_options_8]
        ] ]);
















    }


    public function del_point(Request $request)
    {
      $input = $request->all();
    	$user = JWTAuth::toUser($input['token']);

      $course_id = $request['course_id'];





      $count_course = DB::table('submitcourses')
        ->select(
           'submitcourses.*'
           )
        ->where('submitcourses.course_id', $course_id)
        ->where('submitcourses.user_id', $user->id)
        ->count();

        if($count_course == 1){

          $set_count = DB::table('users')->select(
            'users.*'
            )
            ->where('id', $user->id)
            ->first();

          $obj = User::find($user->id);
          $obj->user_coin = $set_count->user_coin - $request['user_coin'];
          $obj->save();

          $sum_point = $obj->user_coin;


          $package = new logsys();
          $package->user_id = $user->id;
          $package->course_id = $course_id;
          $package->coin_log = $request['user_coin'];
          $package->total_coin_log = $sum_point;
          $package->platform = $request['platform'];;
          $package->timer = $request['timer'];;
          $package->rate_video = $request['rate_video'];;
          $package->save();

          return response()->json(['status'=>200, 'message' => 'ทำการตัด point สำเร็จ', 'data' => $sum_point ]);

        }else{
          //return response()->json(['status'=>200, 'message' => 'success', 'data' => ['user' => $user, 'courseinfo' => $courseinfo] ]);
          return response()->json(['status'=>100, 'message' => 'ข้อมูลของคุณไม่ถูกต้อง', 'data' => null ]);
        }

    }





    public function wallet(){
      $cardmoneys = DB::table('cardmoneys')
        ->get();

        return response()->json(['status'=>200, 'message' => 'success', 'data' => $cardmoneys ]);
    }




    public function get_myhistory(Request $request)
    {
      $input = $request->all();
    	$user = JWTAuth::toUser($input['token']);
      $course_id = $request['course_id'];

      $course_chart = DB::table('answers')->select(
        'answers.*',
        'answers.created_at as date_ans',
        'examples.*',
        'categories.*',
        'courses.*'
        )
        ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
        ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
        ->leftjoin('courses', 'courses.id', '=', 'examples.course_id')
        ->where('answers.user_id', $user->id)
        ->where('courses.id', $course_id)
        ->orderBy('answers.id_option', 'desc')
        ->groupBy('answers.id_option')
        ->paginate(15);

        foreach ($course_chart as $obj) {
            $optionsRes = [];
            $options = DB::table('answers')->select(
              'answers.*'
              )
              ->where('answers.user_id', $user->id)
              ->where('answers.examples_id', $obj->examples_id)
              ->where('answers.id_option', $obj->id_option)
              ->where('answers.ans_status', 1)
              ->count();

                 $optionsRes['count'] = $options;

            $obj->options = $options;
        }

        foreach ($course_chart as $obj) {
            $all_optionsRes = [];
            $all_options = DB::table('questions')->select(
              'questions.*'
              )
              ->where('questions.category_id', $obj->examples_id)
              ->count();
                 $all_optionsRes['count'] = $all_options;
            $obj->all_options = $all_options;

        }


        return response()->json(['status'=>200, 'message' => 'success', 'data' => $course_chart ]);
    }










}
