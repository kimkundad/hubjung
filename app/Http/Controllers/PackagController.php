<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Requests;
use App\Users;
use App\package_his;
use App\course;
use App\submit_package;
use App\filecourse;
use App\example_video;
use App\noti_package;
use Auth;
use Mail;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;
use App\answer;
use App\setpoint;
use App\User;
use App\comment_blog;
use Redirect;
use Response;
use Session;

class PackagController extends Controller
{
    //
    public function home(){

      $pack = DB::table('package_products')
       ->where('package_status', 1)
       ->orderBy('package_sort', 'asc')
       ->get();

      $data['pack'] = $pack;

      return view('packag.home', $data);
    }

    public function link_noti($id){

      $get_noti = DB::table('noti_packages')
       ->where('id', $id)
       ->first();

       $obj = noti_package::find($id);
       $obj->noti_read = 1;
       $obj->save();

       return redirect(url($get_noti->url_noti));

    }

    public function check_course_online(Request $request){

      $count_package = DB::table('submit_packages')
       ->where('user_id', Auth::user()->id)
       ->where('sp_status', 1)
       ->count();

       $count_expire = 0;

       if($count_package > 0){

         $get_package = DB::table('submit_packages')
          ->where('user_id', Auth::user()->id)
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

       return response()->json([
       'data' => [
         'html' => $count_expire
       ]
     ]);

    }

    public function search(Request $request){

      $search = $request['search'];

      $get_course = DB::table('courses')
      ->select(
      'courses.*',
      'courses.set_type_c',
      'departments.name_department'
      )
       ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
       ->where('courses.set_type_c', 1)
       ->Where('courses.title_course','LIKE','%'.$search.'%')
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

       return view('packag.search', compact(['get_course']))
             ->with('search', $search);
    }

    public function get_noti(Request $request){

      $count_noti = DB::table('noti_packages')
       ->where('user_id', Auth::user()->id)
       ->where('noti_read', 0)
       ->count();

       $count_noti_new = DB::table('noti_packages')
        ->where('new_status', 1)
        ->where('noti_read', 0)
        ->count();

        $count_noti += $count_noti_new;

       $get_noti = DB::table('noti_packages')
        ->where('user_id', Auth::user()->id)
        ->where('noti_read', 0)
        ->orderBy('id', 'desc')
        ->limit(8)
        ->get();

        $get_noti_new = DB::table('noti_packages')
         ->where('new_status', 1)
         ->where('noti_read', 0)
         ->orderBy('id', 'desc')
         ->limit(8)
         ->get();

      //  dd($get_noti);
      $tag_html = '';

        if(isset($get_noti)){
              foreach($get_noti as $u){
                $tag_html .= "<a class='dropdown-item' href='".url("link_noti/".$u->id)."'> ".$u->name_noti."</a>";
              }
            }else{
              $tag_html = "";
            }


            if(isset($get_noti_new)){
                  foreach($get_noti_new as $u){
                    $tag_html .= "<a class='dropdown-item' href='".url("link_noti/".$u->id)."'> ".$u->name_noti."</a>";
                  }
                }else{
                  $tag_html = "";
                }


      //Auth::user()->id;
      //$tag_html = "<a class='dropdown-item' href='#'> Another action</a>";

      return response()->json([
      'data' => [
        'html' => $tag_html,
        'count_noti' => $count_noti
      ]
    ]);
    }

    public function login(){
      Session::put('japanonline_redirect', 1);
      return view('packag.login');
    }

    public function register(){
      Session::put('japanonline_redirect', 1);
      return view('packag.register');
    }




    public function download_file_course($id){

      $obj = filecourse::find($id);
      $file = public_path().'/assets/file_courses/'.$obj->file_of_course;
       return Response::download($file);

    }


    public function success_ans_package2($id){

      $course_tech = DB::table('questions')->select(
        'questions.*',
        'answers.question_id',
        'answers.answers',
        'answers.ans_status'
        )
        ->leftjoin('answers', 'questions.id_questions', '=', 'answers.question_id')
        ->where('answers.id_option',$id)
        ->get();


        $course_tech_get = DB::table('questions')->select(
          'questions.*',
          'answers.question_id',
          'answers.answers',
          'answers.time_ans',
          'answers.ans_status'
          )
          ->leftjoin('answers', 'questions.id_questions', '=', 'answers.question_id')
          ->where('answers.id_option',$id)
          ->first();




          $total = DB::table('questions')->select(
            'questions.*',
            'answers.question_id',
            'answers.answers',
            'answers.ans_status'
            )
            ->leftjoin('answers', 'questions.id_questions', '=', 'answers.question_id')
            ->where('answers.id_option',$id)
            ->sum('questions.point');

        //    dd($total);

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


          $depart = DB::table('courses')
            ->where('id', $course_detail->course_id)
            ->first();





          $course_tech_count = DB::table('answers')->select(
            'answers.*'
            )
            ->where('answers.user_id', Auth::user()->id)
            ->where('answers.examples_id', $course_tech_get->category_id)
            ->where('answers.ans_status', 1)
            ->where('answers.id_option',$id)
            ->count();


            $course_tech_count_all = DB::table('answers')->select(
              'answers.*'
              )
              ->where('answers.user_id', Auth::user()->id)
              ->where('answers.examples_id', $course_tech_get->category_id)
              ->where('answers.id_option',$id)
              ->count();

              $sum = 0;

        foreach ($course_tech as $obj) {
            $optionsRes = [];
            $options = DB::table('options')->select(
              'options.*'
              )
              ->where('options.question_id', $obj->id_questions)
              ->get();
              $sum++;
            $obj->options = $options;

        }


        $objs = DB::table('users')
            ->select(
            'users.*',
            'levels.*',
            'levels.id as level_user'
            )
            ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
            ->where('users.id', Auth::user()->id)
            ->first();
            $s =0;


            return view('packag.success_ans_package2')->with([
                 'course_detail' =>$course_detail,
                 'course_tech' =>$course_tech,
                 'course_tech_get' =>$course_tech_get,
                 'objs' => $objs,
                 's' => $s,
                 'depart' => $depart,
                 'sum' => $sum,
                 'course_tech_count' => $course_tech_count,
                 'course_tech_count_all' => $course_tech_count_all,
                 'total' => $total
               ]);

    }


    public function success_ans_package($id){

      $course_tech = DB::table('questions')->select(
        'questions.*',
        'answers.question_id',
        'answers.answers',
        'answers.ans_status'
        )
        ->leftjoin('answers', 'questions.id_questions', '=', 'answers.question_id')
        ->where('answers.id_option',$id)
        ->get();


        $course_tech_get = DB::table('questions')->select(
          'questions.*',
          'answers.question_id',
          'answers.answers',
          'answers.time_ans',
          'answers.ans_status'
          )
          ->leftjoin('answers', 'questions.id_questions', '=', 'answers.question_id')
          ->where('answers.id_option',$id)
          ->first();




          $total = DB::table('questions')->select(
            'questions.*',
            'answers.question_id',
            'answers.answers',
            'answers.ans_status'
            )
            ->leftjoin('answers', 'questions.id_questions', '=', 'answers.question_id')
            ->where('answers.id_option',$id)
            ->sum('questions.point');

        //    dd($total);

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


          $depart = DB::table('courses')
            ->where('id', $course_detail->course_id)
            ->first();





          $course_tech_count = DB::table('answers')->select(
            'answers.*'
            )
            ->where('answers.user_id', Auth::user()->id)
            ->where('answers.examples_id', $course_tech_get->category_id)
            ->where('answers.ans_status', 1)
            ->where('answers.id_option',$id)
            ->count();


            $course_tech_count_all = DB::table('answers')->select(
              'answers.*'
              )
              ->where('answers.user_id', Auth::user()->id)
              ->where('answers.examples_id', $course_tech_get->category_id)
              ->where('answers.id_option',$id)
              ->count();

              $sum = 0;

        foreach ($course_tech as $obj) {
            $optionsRes = [];
            $options = DB::table('options')->select(
              'options.*'
              )
              ->where('options.question_id', $obj->id_questions)
              ->get();
              $sum++;
            $obj->options = $options;

        }


        $objs = DB::table('users')
            ->select(
            'users.*',
            'levels.*',
            'levels.id as level_user'
            )
            ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
            ->where('users.id', Auth::user()->id)
            ->first();
            $s =0;


            return view('packag.success_ans_package')->with([
                 'course_detail' =>$course_detail,
                 'course_tech' =>$course_tech,
                 'course_tech_get' =>$course_tech_get,
                 'objs' => $objs,
                 's' => $s,
                 'depart' => $depart,
                 'sum' => $sum,
                 'course_tech_count' => $course_tech_count,
                 'course_tech_count_all' => $course_tech_count_all,
                 'total' => $total
               ]);

    }

    public function info_package($id){

      //check never submit

      $pack = DB::table('package_products')
       ->where('package_status', 1)
       ->where('id', $id)
       ->first();

      $data['pack'] = $pack;

      return view('packag.info_package', $data);
    }

    public function my_example(){

      $course_chart = DB::table('answers')->select(
        'answers.*',
        'answers.id as id_a',
        'answers.created_at as created_ats',
        'examples.*',
        'examples.id as id_e',
        'courses.title_course',
        'categories.*'
        )
        ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
        ->leftjoin('courses', 'courses.id', '=', 'examples.course_id')
        ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
        ->where('answers.user_id', Auth::user()->id)
        ->orderBy('answers.id', 'desc')
        ->groupBy('answers.id_option')
        ->get();

        if(isset($course_chart)){
          foreach($course_chart as $u){

            $options = DB::table('questions')->where('category_id',$u->id_e)->count();
            $u->options = $options;

            $sum_ans = DB::table('answers')
              ->where('id_option', $u->id_option)
              ->sum('ans_status');
              $u->sum_ans = $sum_ans;
          }
        }

      //  dd($course_chart);

      $data['pack'] = $course_chart;
      return view('packag.my_example', $data);
    }


    public function my_package(){



      $s = 0;

      $course_chart = DB::table('answers')->select(
        'answers.*'
        )
        ->where('answers.user_id', Auth::user()->id)
        ->orderBy('answers.id_option', 'desc')
        ->groupBy('answers.id_option')
        ->get();

      // dd($course_chart);


      foreach($course_chart as $u){
        $s++;
      }
        $data['ex_count'] = $s;

      //  dd($ex_count);

      $id = Auth::user()->id;
      $user = Users::find($id);

      $package_count = DB::table('submit_packages')
        ->where('user_id', $id)
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
        ->where('submit_packages.user_id', $id)
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
          ->where('package_his.user_id', $id)
          ->where('package_his.his_status', 0)
          ->where('package_his.his_type', 0)
          ->get();





      //  dd($package);

      $count_his = DB::table('package_his')
        ->where('package_his.user_id', $id)
        ->count();

      $pack = DB::table('package_products')
       ->where('package_status', 1)
       ->orderBy('package_sort', 'asc')
       ->get();

       $data['count_his'] = $count_his;
      $data['pack'] = $pack;
      $data['order'] = $order;
      $data['package'] = $package;
      $data['package_count'] = $package_count;

      //dd($user);
      $data['user'] = $user;

      return view('packag.account', $data);
    }

    public function my_history(){

      $id = Auth::user()->id;

      $pack = DB::table('package_his')
        ->select(
           'package_his.*',
           'package_his.user_id as Uid',
           'package_his.id as Oid',
           'package_his.created_at as Dcre',
           'users.*',
           'users.id as Ustudent',
           'banks.*',
           'package_products.*',
           'package_products.id as id_cource'
           )
        ->leftjoin('users', 'users.id', '=', 'package_his.user_id')
        ->leftjoin('package_products', 'package_products.id', '=', 'package_his.packeage_id')
        ->leftjoin('banks', 'banks.id', '=', 'package_his.bank_id')
        ->where('package_his.user_id', $id)
        ->get();




      $user = Users::find($id);
    //  dd($pack);
      $data['user'] = $user;
      $data['pack'] = $pack;

      return view('packag.my_history', $data);
    }

    public function profile_user(){
    //  Auth::user()->id
    $id = Auth::user()->id;
    $user = Users::find($id);
    //dd($user);
    $data['user'] = $user;

    return view('packag.profile_users', $data);
    }



    public function update_user_package(Request $request){

      $this->validate($request, [
           'nickname' => 'required',
           'hbd' => 'required',
           'address' => 'required',
           'phone' => 'required'
       ]);

      $image = $request->file('image');
      $id = Auth::user()->id;



     if($image == NULL){



        $package = users::find($id);
        $package->name = $request['nickname'];
        $package->hbd = $request['hbd'];
        $package->phone = $request['phone'];
        $package->address = $request['address'];
        $package->line_id = $request['line_id'];
        $package->save();



      }else{



         $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

          $destinationPath = asset('assets/images/avatar');
          $img = Image::make($image->getRealPath());
          $img->resize(300, null, function ($constraint) {
          $constraint->aspectRatio();
        })->save('assets/images/avatar/'.$input['imagename'], 50);

         $package = users::find($id);
         $package->avatar = $input['imagename'];
         $package->name = $request['nickname'];
         $package->hbd = $request['hbd'];
         $package->phone = $request['phone'];
         $package->address = $request['address'];
         $package->line_id = $request['line_id'];
         $package->save();

      }

      return redirect(url('profile_user_package/'))->with('success','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');



    }

    public function all_package(){

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


       //dd($get_course);
       $data['get_course'] = $get_course;

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

      // dd($depart);
       $data['depart'] = $depart;


      $data['video'] = $video;

      $pack = DB::table('package_products')
       ->where('package_status', 1)
       ->orderBy('package_sort', 'asc')
       ->get();

      $data['pack'] = $pack;

      return view('packag.home', $data);
    }


    public function post_ans_course2(Request $request){


      $examples_id = $request['examples_id'];



      $examples_type = $request['examples_type'];
      $cat_id = $request['cat_id'];

      $course_tech = DB::table('questions')->select(
        'questions.*'
        )
        ->where('questions.category_id',$examples_id)
        ->get();

        $course_tech_count = DB::table('questions')->select(
          'questions.*'
          )
          ->where('questions.category_id',$examples_id)
          ->count();

        //  dd($course_tech_count);

        $s_data = 1;


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
      $num = 'learnsbuy-'.$ranId;


      if($course_tech){
      foreach($course_tech as $payment){

        $value = $request['value_'.$s_data];
        $id_questions = $payment->id_questions;



          if($payment->status == $value && $examples_type == 2){
            $payment = new answer();
            $payment->examples_id  = $examples_id;
            $payment->user_id = Auth::user()->id;
            $payment->question_id = $id_questions;
            $payment->id_option = $num;
            $payment->answers = $value;
            $payment->ans_status = 1;
            $payment->time_ans = $request['timmery_time'];
            $payment->save();

            $the_id = $payment->id_option;
          }else{
            $payment = new answer();
            $payment->examples_id  = $examples_id;
            $payment->user_id = Auth::user()->id;
            $payment->question_id = $id_questions;
            $payment->id_option = $num;
            $payment->answers = $value;
            $payment->ans_status = 0;
            $payment->time_ans = $request['timmery_time'];
            $payment->save();

            $the_id = $payment->id_option;
          }

          //echo 'value_'.$payment->id_questions;
          //dd('value_'.$payment->id_questions);
          //dd($payment);
          $s_data++;
            }
        }


        $course_chart7 = DB::table('answers')->select(
          DB::raw(' max(answers.id_option) as id_optionss'),
          'answers.*',
          'examples.*',
          'categories.*'
          )
          ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
          ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
          ->where('answers.user_id', Auth::user()->id)
          ->where('examples.id', $examples_id)
          ->where('categories.id', $cat_id)
          ->orderBy('answers.id_option', 'desc')
          ->groupBy('answers.id_option')
          ->sum('ans_status');

          $options = DB::table('questions')->select(
            'questions.*'
            )
            ->where('questions.category_id', $examples_id)
            ->count();


          if($course_chart7 == 0 || $course_chart7 == null){
            $course_chart7 = 0;
          }else{
            $course_chart7_sum = $course_chart7;

            $course_chart7 = ($course_chart7/$options*100);

            $course_chart7 = ($course_chart7/2);
          }

          $obj = User::find(Auth::user()->id);
          $obj->point_level += $course_chart7;
          $obj->save();



        $course_tech = DB::table('answers')->select(
          'answers.*'
          )
          ->where('answers.user_id', Auth::user()->id)
          ->where('answers.examples_id', $examples_id)
          ->where('answers.ans_status', 1)
          ->count();

        return redirect(url('success_ans_package2/'.$the_id))->with('success','ยินดีด้วย');

    }


    public function post_ans_course(Request $request){


      $examples_id = $request['examples_id'];



      $examples_type = $request['examples_type'];
      $cat_id = $request['cat_id'];

      $course_tech = DB::table('questions')->select(
        'questions.*'
        )
        ->where('questions.category_id',$examples_id)
        ->get();

        $course_tech_count = DB::table('questions')->select(
          'questions.*'
          )
          ->where('questions.category_id',$examples_id)
          ->count();

        //  dd($course_tech_count);

        $s_data = 1;


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
      $num = 'learnsbuy-'.$ranId;


      if($course_tech){
      foreach($course_tech as $payment){

        $value = $request['value_'.$s_data];
        $id_questions = $payment->id_questions;



          if($payment->status == $value && $examples_type == 2){
            $payment = new answer();
            $payment->examples_id  = $examples_id;
            $payment->user_id = Auth::user()->id;
            $payment->question_id = $id_questions;
            $payment->id_option = $num;
            $payment->answers = $value;
            $payment->ans_status = 1;
            $payment->time_ans = $request['timmery_time'];
            $payment->save();

            $the_id = $payment->id_option;
          }else{
            $payment = new answer();
            $payment->examples_id  = $examples_id;
            $payment->user_id = Auth::user()->id;
            $payment->question_id = $id_questions;
            $payment->id_option = $num;
            $payment->answers = $value;
            $payment->ans_status = 0;
            $payment->time_ans = $request['timmery_time'];
            $payment->save();

            $the_id = $payment->id_option;
          }

          //echo 'value_'.$payment->id_questions;
          //dd('value_'.$payment->id_questions);
          //dd($payment);
          $s_data++;
            }
        }


        $course_chart7 = DB::table('answers')->select(
          DB::raw(' max(answers.id_option) as id_optionss'),
          'answers.*',
          'examples.*',
          'categories.*'
          )
          ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
          ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
          ->where('answers.user_id', Auth::user()->id)
          ->where('examples.id', $examples_id)
          ->where('categories.id', $cat_id)
          ->orderBy('answers.id_option', 'desc')
          ->groupBy('answers.id_option')
          ->sum('ans_status');

          $options = DB::table('questions')->select(
            'questions.*'
            )
            ->where('questions.category_id', $examples_id)
            ->count();


          if($course_chart7 == 0 || $course_chart7 == null){
            $course_chart7 = 0;
          }else{
            $course_chart7_sum = $course_chart7;

            $course_chart7 = ($course_chart7/$options*100);

            $course_chart7 = ($course_chart7/2);
          }

          $obj = User::find(Auth::user()->id);
          $obj->point_level += $course_chart7;
          $obj->save();



        $course_tech = DB::table('answers')->select(
          'answers.*'
          )
          ->where('answers.user_id', Auth::user()->id)
          ->where('answers.examples_id', $examples_id)
          ->where('answers.ans_status', 1)
          ->count();

        return redirect(url('success_ans_package/'.$the_id))->with('success','ยินดีด้วย');

    }

    public function submit_payment_package(Request $request){

      $this->validate($request, [
       'bankname' => 'required',
       'totalmoney' => 'required',
       'day' => 'required',
       'packag_id' => 'required'
      ]);

      $packag_id = $request->get('packag_id');

      $pack = DB::table('package_products')
       ->where('package_status', 1)
       ->where('id', $packag_id)
       ->first();

      $image = $request->file('image');

      if($image == NULL){

        $package = new package_his();
        $package->user_id = Auth::user()->id;
        $package->packeage_id = $packag_id;
        $package->department_id = $pack->department_id;
        $package->bank_id = $request['bankname'];
        $package->money_tran = $request['totalmoney'];
        $package->date_tran = $request['day'];
        $package->time_tran = $request['timer'];
        $package->save();

      }else{

        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

         $img = Image::make($image->getRealPath());
         $img->resize(240, 240, function ($constraint) {
         $constraint->aspectRatio();
       })->save('assets/bill/'.$input['imagename']);

       $package = new package_his();
       $package->user_id = Auth::user()->id;
       $package->packeage_id = $packag_id;
       $package->department_id = $pack->department_id;
       $package->bank_id = $request['bankname'];
       $package->money_tran = $request['totalmoney'];
       $package->date_tran = $request['day'];
       $package->time_tran = $request['timer'];
       $package->slip_img = $input['imagename'];
       $package->save();

      }



      $the_id = $package->id;


      $coursess = DB::table('package_his')
        ->select(
           'package_his.*',
           'package_his.user_id as Uid',
           'package_his.id as Oid',
           'users.*',
           'banks.*',
           'package_products.*',
           'package_products.id as id_cource'
           )
        ->where('package_his.user_id', Auth::user()->id)
        ->where('package_his.id', $the_id)
        ->leftjoin('users', 'users.id', '=', 'package_his.user_id')
        ->leftjoin('package_products', 'package_products.id', '=', 'package_his.packeage_id')
        ->leftjoin('banks', 'banks.id', '=', 'package_his.bank_id')
        ->first();


        $package = new noti_package();
        $package->user_id = Auth::user()->id;
        $package->name_noti = "ได้ทำการสมัคร Package : ".$coursess->package_name;
        $package->url_noti = "account";
        $package->save();



      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



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

                    Mail::send('mails.index3', $data_toview, function($message) use ($data)
                    {
                        $message->from($data['sender'], 'Learnsbuy');
                        $message->to($data['sender'])
                        ->replyTo($data['sender'], 'Learnsbuy.')
                        ->subject('ใบเสร็จสำหรับการสั่งซื้อคอร์สเรียน Learnsbuy ');

                        //echo 'Confirmation email after registration is completed.';
                    });


                    Mail::send('mails.index3', $data_toview, function($message) use ($data)
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




         $message = Auth::user()->name." ได้สั่งซื้อคอร์ส : ".$coursess->package_name.", ธนาคาร :".$coursess->bank_name.", ยอดโอน : ".$coursess->money_tran;
         if($image == NULL){

           $message_data = array(
           'message' => $message
           );

         }else{

           $image_thumbnail_url = url('assets/bill/'.$coursess->slip_img);  // max size 240x240px JPEG
           $image_fullsize_url = url('assets/bill/'.$coursess->slip_img); //max size 1024x1024px JPEG
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

         //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


      return redirect(url('success_payment/'.$the_id))->with('hbd','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');


    }

    public function success_payment($id){

      $his = package_his::find($id);

      $user = DB::table('users')
       ->where('id', $his->user_id)
       ->first();


       $banks = DB::table('banks')
        ->where('id', $his->bank_id)
        ->first();

    //  dd($his);

      $pack = DB::table('package_products')
       ->where('package_status', 1)
       ->where('id', $his->packeage_id)
       ->first();



       $depart = DB::table('departments')
        ->where('id', $his->department_id)
        ->first();

        $data['banks'] = $banks;
        $data['user'] = $user;
        $data['pack'] = $pack;
        $data['depart'] = $depart;
        $data['his'] = $his;

          return view('packag.success_pay_package', $data);

    //  dd($his);
    }

    public function submit_info_package(Request $request){

      $packag_id = $request->get('packag_id');
      $package_type = $request->get('package_type');
      $hbd = $request->get('hbd');
      if($hbd == '0000-00-00'){
          return redirect(url('info_package/'.$packag_id))->with('hbd','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');
      }

      $this->validate($request, [
       'name' => 'required',
       'phone' => 'required',
       'address' => 'required',
       'email' => 'required',
       'hbd' => 'required',
      ]);


        $package = Users::find(Auth::user()->id);
        $package->name = $request['name'];
        $package->email = $request['email'];
        $package->hbd = $request['hbd'];
        $package->phone = $request['phone'];
        $package->line_id = $request['line'];
        $package->address = $request['address'];
        $package->save();


        if($package_type == 0){
          return redirect(url('get_info_package/'.$packag_id))->with('hbd','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');
        }else{
          return redirect(url('get_free_package/'.$packag_id))->with('hbd','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');
        }

    }

    public function get_free_package($id){

      $pack = DB::table('package_products')
       ->where('package_status', 1)
       ->where('id', $id)
       ->first();


    //   dd($pack);

      if(isset($pack)){
        $check = DB::table('package_his')
         ->where('user_id', Auth::user()->id)
         ->where('department_id', $pack->department_id)
         ->count();
      }else{
        return abort(404);
      }



       $pack_check = DB::table('package_products')
        ->where('package_status', 1)
        ->where('package_type', 1)
        ->where('id', $id)
        ->count();

      // dd($pack_check);


      $data['pack_check'] = $pack_check;
      $data['pack'] = $pack;
      $data['check'] = $check;
      return view('packag.get_free_package', $data);
    }

    public function submit_free_package(Request $request){

      $this->validate($request, [
       'conditions' => 'required'
      ]);

      $packag_id = $request->get('packag_id');
      $conditions = $request->get('conditions');

      $check = DB::table('package_his')
       ->where('user_id', Auth::user()->id)
       ->where('his_type', 1)
       ->count();



        $pack = DB::table('package_products')
         ->where('package_status', 1)
         ->where('id', $packag_id)
         ->first();

         $check_submit = DB::table('submit_packages')
          ->where('user_id', Auth::user()->id)
          ->where('department_id', $pack->department_id)
          ->count();

    //      dd($check_submit);


      if($conditions == null){
        return redirect(url('get_free_package/'.$packag_id))->with('error_po','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');
      }else{




      /*   if($check == 0){ */



            $start=date("Y-m-d",time());
            $startdatec=strtotime($start);
            $tod=$pack->package_day*86400;
            $ndate=$startdatec+$tod; // นับบวกไปอีกตามจำนวนวันที่รับมา
            $df=date("Y-m-d",$ndate);

            $package = new package_his();
            $package->user_id = Auth::user()->id;
            $package->packeage_id = $packag_id;
            $package->department_id = $pack->department_id;
            $package->start = $start;
            $package->end_date = $df;
            $package->his_type = 1;
            $package->save();

            $the_id = $package->id;

            if($check_submit == 0){

              $pac = new submit_package();
              $pac->user_id = Auth::user()->id;
              $pac->packeage_id = $packag_id;
              $pac->department_id = $pack->department_id;
              $pac->total_day = $pack->package_day;
              $pac->start = $start;
              $pac->end_date = $df;
              $pac->sp_status = 1;
              $pac->save();

            }else{

              return redirect(url('get_free_package/'.$packag_id))->with('error_po','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');

            /*  DB::table('submit_packages')
              ->where('user_id', Auth::user()->id)
              ->where('department_id', $pack->department_id)
              ->update([
                'packeage_id' => $packag_id,
                'department_id' => $pack->department_id,
                'total_day' => $pack->package_day,
                'start' => $start,
                'end_date' => $df,
              ]); */

            }

            return redirect(url('success_free_package/'.$the_id))->with('success_free','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');


      /*   }else{

           return redirect(url('get_free_package/'.$packag_id))->with('error_po','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');

         } */




      }


    }

    public function success_free_package($id){

      $check = DB::table('package_his')
       ->where('user_id', Auth::user()->id)
       ->where('id', $id)
       ->first();

      $pack = DB::table('package_products')
       ->where('id', $check->packeage_id)
       ->first();
       $data['check'] = $check;
       $data['pack'] = $pack;
       return view('packag.success_free_package', $data);

    }

    public function get_info_package($id){

      $pack = DB::table('package_products')
       ->where('package_status', 1)
       ->where('id', $id)
       ->first();

      $data['pack'] = $pack;

      $bank = DB::table('banks')
        ->get();
      $data['bank'] = $bank;

      return view('packag.payment_packag', $data);
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

    //   dd($depart);
       $data['depart'] = $depart;


         return view('packag.channels', $data);

    }

    public function single_channel($id){

      $depart = DB::table('departments')
      ->where('id', $id)
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

      return view('packag.single_course', $data);
    }



    public function course_detail($id){


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


          $path1 = explode(",", $get_tags->tags);
          $exp = array_merge($exp, $path1);


        $data['get_tags'] = $exp;

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


      return view('packag.course_detail', $data);
    }


    public function playlist_channel($id){


      $depart = DB::table('departments')
      ->where('id', $id)
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
      $data['get_video'] = $get_video;
      $data['pack'] = $pack;
      $data['depart'] = $depart;

      return view('packag.single_channel', $data);


    }

    public function e_testing($id){

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
          ->where('courses.department_id', $id)
          ->where('courses.set_type_c', 1)
          ->get();

          foreach ($objs as $obj) {

              $options = DB::table('questions')->where('category_id',$obj->e_id)->count();
              $obj->options = $options;
          }

        //  dd($objs);

      $depart = DB::table('departments')
      ->where('id', $id)
      ->first();

      $pack = DB::table('courses')
       ->where('department_id', $depart->id)
       ->where('set_type_c', 1)
       ->get();

      $data['objs'] = $objs;
      $data['depart'] = $depart;

      return view('packag.e_testing', $data);
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

        //  dd($objs);




      $data['objs'] = $objs;


    //  dd($objs);

      return view('packag.all_e_testing', $data);
    }


    public function start_test($id){


      $course_detail = DB::table('examples')->select(
        'examples.*',
        'examples.created_at as created_at_date',
        'examples.id as Eid',
        'categories.*',
        'categories.id as cat_id'
        )
        ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
        ->where('examples.id', $id)
        ->first();

        $course_tech = DB::table('questions')->select(
          'questions.*'
          )
          ->where('questions.category_id',$id)
          ->get();

          $sum = 1;

          foreach ($course_tech as $obj) {
              $optionsRes = [];
              $options = DB::table('options')->select(
                'options.*'
                )
                ->where('options.question_id', $obj->id_questions)
                ->get();
                $sum++;
              $obj->options = $options;

          }

        //  dd($course_tech);

        $s = 1;
        $set = 1;
        $data['course_detail'] = $course_detail;
        $data['course_tech'] = $course_tech;
        $data['s'] = $s;
        $data['set'] = $set;
        $data['sum'] = $sum;

      return view('packag.start_test', $data);
    }


    public function start_test2($id){


      $course_detail = DB::table('examples')->select(
        'examples.*',
        'examples.created_at as created_at_date',
        'examples.id as Eid',
        'categories.*',
        'categories.id as cat_id'
        )
        ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
        ->where('examples.id', $id)
        ->first();

        $course_tech = DB::table('questions')->select(
          'questions.*'
          )
          ->where('questions.category_id',$id)
          ->get();

          $sum = 1;

          foreach ($course_tech as $obj) {
              $optionsRes = [];
              $options = DB::table('options')->select(
                'options.*'
                )
                ->where('options.question_id', $obj->id_questions)
                ->get();
                $sum++;
              $obj->options = $options;

          }

        //  dd($course_tech);

        $s = 1;
        $set = 1;
        $data['course_detail'] = $course_detail;
        $data['course_tech'] = $course_tech;
        $data['s'] = $s;
        $data['set'] = $set;
        $data['sum'] = $sum;

      return view('packag.start_test2', $data);
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


       $data['video'] = $video;


      return view('packag.new_video', $data);
    }

    public function play_video($id){

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

      return view('packag.play_video', $data);
    }

    public function history_video(){
      return view('packag.history_video');
    }


    public function blog(){

      $get_tags = DB::table('blogs')->select(
        'blogs.tags'
        )
        ->get();


        $exp = array();
        foreach($get_tags as $u){

          $path1 = explode(",", $u->tags);
          $exp = array_merge($exp, $path1);
        }



      //  dd($exp);

        $data['get_tags'] = $exp;

      $course_tech = DB::table('blogs')
        ->paginate(8);

        if(isset($course_tech)){
          foreach($course_tech as $u){

            $count_blog = DB::table('comment_blogs')
              ->where('blog_id', $u->id)
              ->count();

              $u->count_comment = $count_blog;

          }
        }




      //  dd($course_tech);

        $data['blog'] = $course_tech;

      return view('packag.blog', $data);
    }

    public function blog_detail($id){

      $get_tags = DB::table('blogs')->select(
        'blogs.tags'
        )
        ->get();

        $exp = array();
        foreach($get_tags as $u){

          $path1 = explode(",", $u->tags);
          $exp = array_merge($exp, $path1);
        }

        $data['get_tags'] = $exp;


        $get_tags_s = DB::table('blogs')->select(
          'blogs.tags'
          )
          ->where('id', $id)
          ->first();

          $exp1 = array();

            $path2 = explode(",", $get_tags_s->tags);
            $exp1 = array_merge($exp1, $path2);

          $data['get_tags_s'] = $exp1;


      $count_blog = DB::table('comment_blogs')
        ->where('blog_id', $id)
        ->count();

        $get_comment = DB::table('comment_blogs')
          ->select(
          'comment_blogs.*',
          'comment_blogs.id as id_com',
          'comment_blogs.created_at as created_ats',
          'users.*',
          'users.id as u_id'
          )
          ->leftjoin('users', 'users.id', '=', 'comment_blogs.user_id')
          ->where('comment_blogs.blog_id', $id)
          ->get();

      $course_tech = DB::table('blogs')
        ->where('id', $id)
        ->first();


      //  dd($course_tech);
        $data['get_comment'] = $get_comment;
        $data['count_blog'] = $count_blog;
        $data['blog'] = $course_tech;

      return view('packag.blog_detail', $data);
    }


    public function post_comment_user(Request $request){

      $this->validate($request, [
           'comment' => 'required'
       ]);

       $package = new comment_blog;
       $package->user_id = Auth::user()->id;
       $package->blog_id = $request['blog_id'];
       $package->comment = $request['comment'];
       $package->save();

       return redirect(url('blog_detail/'.$request['blog_id']))->with('success','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');

    }

    public function del_comment($id){

      $obj = comment_blog::find($id);
      $obj->delete();
      return Redirect::back();

    }

    public function edit_comment_user(Request $request){

      $this->validate($request, [
           'comment' => 'required'
       ]);

       $id = $request['comment_id'];

    //   dd($id);

       $package = comment_blog::find($id);
       $package->comment = $request['comment'];
       $package->save();


       return redirect(url('blog_detail/'.$request['blog_id']))->with('success','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');

    }






}
