<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\course;
use App\typecourses;
use App\Http\Requests;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Excel;
use File;
use App\users;
use App\submitcourse;
use App\bank;
use Mail;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;
use App\qrcode;
use App\answer;
use App\setpoint;
use App\User;

class MycourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $objs = DB::table('users')
          ->select(
          'users.*',
          'levels.*',
          'levels.id as level_user'
          )
          ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
          ->where('users.id', Auth::user()->id)
          ->first();
        //  dd($objs);
    //  $data['objs'] = $objs;


      $coursess = DB::table('submitcourses')
        ->select(
           'submitcourses.*',
           'submitcourses.user_id as Uid',
           'submitcourses.id as Oid',
           'users.*',
           'courses.*'
           )
        ->where('submitcourses.user_id', Auth::user()->id)
        ->where('submitcourses.status', 1)
        ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
        ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
        ->get();



        $coursefin = DB::table('submitcourses')
          ->select(
             'submitcourses.*',
             'submitcourses.user_id as Uid',
             'submitcourses.id as Oid',
             'users.*',
             'courses.*',
             'courses.id as Cid'
             )
          ->where('submitcourses.user_id', Auth::user()->id)
          ->where('submitcourses.status', 2)
          ->where('courses.type_course', '!=', 3)
          //->orwhere('submitcourses.status', 3)
          ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
          ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
          ->get();



          $course_free = DB::table('submitcourses')
            ->select(
               'submitcourses.*',
               'submitcourses.user_id as Uid',
               'submitcourses.id as Oid',
               'users.*',
               'courses.*',
               'courses.id as Cid'
               )
            ->where('submitcourses.user_id', Auth::user()->id)
            ->where('submitcourses.status', 2)
            ->where('courses.type_course', 3)
            //->orwhere('submitcourses.status', 3)
            ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
            ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
            ->get();

      return view('mycourse.index')->with([
           'courseinfos' =>$coursess,
           'courseinfosfin' =>$coursefin,
           'course_free' =>$course_free,
           'objs' => $objs
         ]);
    }


    public function store_transactions(){

      $coursess_suc = DB::table('history_pays')
        ->select(
           'history_pays.*'
           )
        ->where('user_id', Auth::user()->id)
        ->paginate(10);


      return view('profile.store_transactions')->with([
           'coursess_suc' => $coursess_suc
         ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $objs = DB::table('users')
          ->select(
          'users.*',
          'levels.*',
          'levels.id as level_user'
          )
          ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
          ->where('users.id', Auth::user()->id)
          ->first();


          $course_chart1 = DB::table('answers')->select(
            DB::raw(' max(answers.id_option) as id_optionss'),
            'answers.*',
            'examples.*',
            'categories.*'
            )
            ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
            ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
            ->where('answers.user_id', Auth::user()->id)
            ->where('examples.course_id', $id)
            ->where('categories.id', 1)
            ->orderBy('answers.id_option', 'desc')
            ->groupBy('answers.id_option')
            ->sum('ans_status');






            $course_chart2 = DB::table('answers')->select(
              DB::raw(' max(answers.id_option) as id_optionss'),
              'answers.*',
              'examples.*',
              'categories.*'
              )
              ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
              ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
              ->where('answers.user_id', Auth::user()->id)
              ->where('examples.course_id', $id)
              ->where('categories.id', 2)
              ->orderBy('answers.id_option', 'desc')
              ->groupBy('answers.id_option')
              ->sum('ans_status');



              $course_chart3 = DB::table('answers')->select(
                DB::raw(' max(answers.id_option) as id_optionss'),
                'answers.*',
                'examples.*',
                'categories.*'
                )
                ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                ->where('answers.user_id', Auth::user()->id)
                ->where('examples.course_id', $id)
                ->where('categories.id', 3)
                ->orderBy('answers.id_option', 'desc')
                ->groupBy('answers.id_option')
                ->sum('ans_status');



                $course_chart4 = DB::table('answers')->select(
                  DB::raw(' max(answers.id_option) as id_optionss'),
                  'answers.*',
                  'examples.*',
                  'categories.*'
                  )
                  ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                  ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                  ->where('answers.user_id', Auth::user()->id)
                  ->where('examples.course_id', $id)
                  ->where('categories.id', 4)
                  ->orderBy('answers.id_option', 'desc')
                  ->groupBy('answers.id_option')
                  ->sum('ans_status');

                  $course_chart5 = DB::table('answers')->select(
                    DB::raw(' max(answers.id_option) as id_optionss'),
                    'answers.*',
                    'examples.*',
                    'categories.*'
                    )
                    ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                    ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                    ->where('answers.user_id', Auth::user()->id)
                    ->where('examples.course_id', $id)
                    ->where('categories.id', 5)
                    ->orderBy('answers.id_option', 'desc')
                    ->groupBy('answers.id_option')
                    ->sum('ans_status');



                    $course_chart6 = DB::table('answers')->select(
                      DB::raw(' max(answers.id_option) as id_optionss'),
                      'answers.*',
                      'examples.*',
                      'categories.*'
                      )
                      ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                      ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                      ->where('answers.user_id', Auth::user()->id)
                      ->where('examples.course_id', $id)
                      ->where('categories.id', 6)
                      ->orderBy('answers.id_option', 'desc')
                      ->groupBy('answers.id_option')
                      ->sum('ans_status');

                    //  dd($course_chart6);

                      $course_chart7 = DB::table('answers')->select(
                        DB::raw(' max(answers.id_option) as id_optionss'),
                        'answers.*',
                        'examples.*',
                        'categories.*'
                        )
                        ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                        ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                        ->where('answers.user_id', Auth::user()->id)
                        ->where('examples.course_id', $id)
                        ->where('categories.id', 7)
                        ->orderBy('answers.id_option', 'desc')
                        ->groupBy('answers.id_option')
                        ->sum('ans_status');



                        $course_chart8 = DB::table('answers')->select(
                          DB::raw(' max(answers.id_option) as id_optionss'),
                          'answers.*',
                          'examples.*',
                          'categories.*'
                          )
                          ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
                          ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
                          ->where('answers.user_id', Auth::user()->id)
                          ->where('examples.course_id', $id)
                          ->where('categories.id', 8)
                          ->orderBy('answers.id_option', 'desc')
                          ->groupBy('answers.id_option')
                          ->sum('ans_status');


                          $coursesfin_check_1 = DB::table('submitcourses')
                            ->select(
                               'submitcourses.*',
                               'submitcourses.user_id as Uid',
                               'submitcourses.id as Oid',
                               'courses.*',
                               'courses.id as Cid'
                               )
                            ->where('submitcourses.user_id', Auth::user()->id)
                            ->where('submitcourses.course_id', $id)
                            ->where('submitcourses.status', 2)
                            ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
                            ->count();


                            $coursesfin_check_2 = DB::table('submitcourses')
                              ->select(
                                 'submitcourses.*',
                                 'submitcourses.user_id as Uid',
                                 'submitcourses.id as Oid',
                                 'courses.*',
                                 'courses.id as Cid'
                                 )
                              ->where('submitcourses.user_id', Auth::user()->id)
                              ->where('submitcourses.course_id', $id)
                              ->where('submitcourses.status', 3)
                              ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
                              ->count();

                            if($coursesfin_check_1 == 0){

                              $coursesfin = DB::table('submitcourses')
                                ->select(
                                   'submitcourses.*',
                                   'submitcourses.user_id as Uid',
                                   'submitcourses.id as Oid',
                                   'courses.*',
                                   'courses.id as Cid'
                                   )
                                ->where('submitcourses.user_id', Auth::user()->id)
                                ->where('submitcourses.course_id', $id)
                                ->where('submitcourses.status', 3)
                                ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
                                ->first();

                            }else{

                              $coursesfin = DB::table('submitcourses')
                                ->select(
                                   'submitcourses.*',
                                   'submitcourses.user_id as Uid',
                                   'submitcourses.id as Oid',
                                   'courses.*',
                                   'courses.id as Cid'
                                   )
                                ->where('submitcourses.user_id', Auth::user()->id)
                                ->where('submitcourses.course_id', $id)
                                ->where('submitcourses.status', 2)
                                ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
                                ->first();

                            }






        $courses_check = DB::table('submitcourses')
          ->select(
             'submitcourses.*',
             'submitcourses.user_id as Uid',
             'submitcourses.id as Oid',
             'courses.*',
             'courses.id as Cid'
             )
          ->where('submitcourses.user_id', Auth::user()->id)
          ->where('submitcourses.course_id', $id)
          ->where('submitcourses.status', '!=', 1)
          ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
          ->count();

        //  dd($courses_check);

          if($courses_check != 0){


            $course_tech = DB::table('examples')->select(
              'examples.*',
              'examples.id as Eid',
              'categories.*',
              'categories.id as Cid'
              )
              ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
              ->where('course_id',$id)
              ->get();

              $s = 1;
              foreach ($course_tech as $obj) {
                  $optionsRes = [];
                  $options = DB::table('questions')->select(
                    'questions.*'
                    )
                    ->where('questions.category_id', $obj->Eid)
                    ->count();

                       $optionsRes['count'] = $options;

                  $obj->options = $options;


                  if($obj->Cid == 1){
                    if($course_chart1 == 0 || $course_chart1 == null){
                      $course_chart1 = 0;
                    }else{
                      $course_chart1_sum = $course_chart1;


                      $course_chart1 = ($course_chart1/$options*100);
                      if($course_chart1 == 100){
                          $course_chart1 = 10;
                      }else{
                          $course_chart1 = substr((($course_chart1)), 0, 1);

                      }
                      $course_chart1 = ($course_chart1/2);

                    }
                  }


                  if($obj->Cid == 2){
                    if($course_chart2 == 0 || $course_chart2 == null){
                      $course_chart2 = 0;
                    }else{
                      $course_chart2_sum = $course_chart2;

                      $course_chart2 = ($course_chart2/$options*100);
                      if($course_chart2 == 100){
                          $course_chart2 = 10;
                      }else{
                          $course_chart2 = substr((($course_chart2)), 0, 1);

                      }
                      $course_chart2 = ($course_chart2/2);

                    }
                  }


                  if($obj->Cid == 3){
                    if($course_chart3 == 0 || $course_chart3 == null){
                      $course_chart3 = 0;
                    }else{
                      $course_chart3_sum = $course_chart3;

                      $course_chart3 = ($course_chart3/$options*100);
                      if($course_chart3 == 100){
                          $course_chart3 = 10;
                      }else{
                          $course_chart3 = substr((($course_chart3)), 0, 1);

                      }
                      $course_chart3 = ($course_chart3/2);

                    }
                  }

                  if($obj->Cid == 4){
                    if($course_chart4 == 0 || $course_chart4 == null){
                      $course_chart4 = 0;
                    }else{
                      $course_chart4_sum = $course_chart4;

                      $course_chart4 = ($course_chart4/$options*100);
                      if($course_chart4 == 100){
                          $course_chart4 = 10;
                      }else{
                          $course_chart4 = substr((($course_chart4)), 0, 1);

                      }
                      $course_chart4 = ($course_chart4/2);

                    }
                  }

                  if($obj->Cid == 5){
                    if($course_chart5 == 0 || $course_chart5 == null){
                      $course_chart5 = 0;
                    }else{
                      $course_chart5_sum = $course_chart5;

                      $course_chart5 = ($course_chart5/$options*100);
                      if($course_chart5 == 100){
                          $course_chart5 = 10;
                      }else{
                          $course_chart5 = substr((($course_chart5)), 0, 1);

                      }
                      $course_chart5 = ($course_chart5/2);

                    }
                  }

                  if($obj->Cid == 6){
                    if($course_chart6 == 0 || $course_chart6 == null){
                      $course_chart6 = 0;
                    }else{
                      $course_chart6_sum = $course_chart6;

                      $course_chart6 = ($course_chart6/$options*100);
                      if($course_chart6 == 100){
                          $course_chart6 = 10;
                      }else{
                          $course_chart6 = substr((($course_chart6)), 0, 1);

                      }
                      $course_chart6 = ($course_chart6/2);

                    }
                  }


                  if($obj->Cid == 7){
                    if($course_chart7 == 0 || $course_chart7 == null){
                      $course_chart7 = 0;
                    }else{
                      $course_chart7_sum = $course_chart7;

                      $course_chart7 = ($course_chart7/$options*100);
                      if($course_chart7 == 100){
                          $course_chart7 = 10;
                      }else{
                          $course_chart7 = substr((($course_chart7)), 0, 1);

                      }
                      $course_chart7 = ($course_chart7/2);

                    }
                  }

                  if($obj->Cid == 8){
                    if($course_chart8 == 0 || $course_chart8 == null){
                      $course_chart8 = 0;
                    }else{
                      $course_chart8_sum = $course_chart8;

                      $course_chart8 = ($course_chart8/$options*100);
                      if($course_chart8 == 100){
                          $course_chart8 = 10;
                      }else{
                          $course_chart8 = substr((($course_chart8)), 0, 1);

                      }
                      $course_chart8 = ($course_chart8/2);
                    }
                  }





                  $s++;

              }


              foreach ($course_tech as $obj) {
                  $answersRes = [];
                  $answers = DB::table('answers')->select(
                    'answers.id_option'
                    )
                    ->where('answers.examples_id', $obj->Eid)
                    ->where('answers.user_id', Auth::user()->id)
                    ->orderBy('id_option', 'desc')
                    ->first();

                  if(isset($answers)){
                    $obj->answers = $answers->id_option;
                  }



              }

            //  dd($course_tech);

    //   dd($coursefin);


    if($course_chart1 == 0 || $course_chart1 == null){
      $course_chart1 = 0;
      $course_chart1_sum = $course_chart1;
    }
    if($course_chart2 == 0 || $course_chart2 == null){
      $course_chart2 = 0;
      $course_chart2_sum = $course_chart2;
    }
    if($course_chart3 == 0 || $course_chart3 == null){
      $course_chart3 = 0;
      $course_chart3_sum = $course_chart3;
    }
    if($course_chart4 == 0 || $course_chart4 == null){
      $course_chart4 = 0;
      $course_chart4_sum = $course_chart4;
    }
    if($course_chart5 == 0 || $course_chart5 == null){
      $course_chart5 = 0;
      $course_chart5_sum = $course_chart5;
    }
    if($course_chart6 == 0 || $course_chart6 == null){
      $course_chart6 = 0;
      $course_chart6_sum = $course_chart6;
    }
    if($course_chart7 == 0 || $course_chart7 == null){
      $course_chart7 = 0;
      $course_chart7_sum = $course_chart7;
    }
    if($course_chart8 == 0 || $course_chart8 == null){
      $course_chart8 = 0;
      $course_chart8_sum = $course_chart8;
    }



    $video_list = DB::table('video_lists')
     ->select(
     DB::raw('video_lists.*')
     )
     ->where('course_id', $id)
     ->orderBy('order_sort', 'asc')
     ->get();



    return view('mycourse.my_ans')->with([
         'coursesfin' =>$coursesfin,
         'course_tech' =>$course_tech,
         'objs' => $objs,
         'video_list' => $video_list,
         'course_chart1_sum' => $course_chart1_sum,
         'course_chart2_sum' => $course_chart2_sum,
         'course_chart3_sum' => $course_chart3_sum,
         'course_chart4_sum' => $course_chart4_sum,
         'course_chart5_sum' => $course_chart5_sum,
         'course_chart6_sum' => $course_chart6_sum,
         'course_chart7_sum' => $course_chart7_sum,
         'course_chart8_sum' => $course_chart8_sum,
         'course_chart1' => $course_chart1,
         'course_chart2' => $course_chart2,
         'course_chart3' => $course_chart3,
         'course_chart4' => $course_chart4,
         'course_chart5' => $course_chart5,
         'course_chart6' => $course_chart6,
         'course_chart7' => $course_chart7,
         'course_chart8' => $course_chart8
       ]);

          }else{



            return view('mycourse.my_ans_detail_null')->with([
                 'objs' => $objs
               ]);

          }






    }





    public function ans_detail($Eid = 0, $sub_id = 0)
    {

      $objs = DB::table('users')
          ->select(
          'users.*',
          'levels.*',
          'levels.id as level_user'
          )
          ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
          ->where('users.id', Auth::user()->id)
          ->first();

          $check_sub = DB::table('submitcourses')->select(
            'submitcourses.*',
            'examples.*'
            )
            ->leftjoin('examples', 'examples.course_id', '=', 'submitcourses.course_id')
            ->where('examples.id',$Eid)
            ->where('submitcourses.course_id',$sub_id)
            ->where('submitcourses.user_id', Auth::user()->id)
            ->count();

          //  dd($check_sub);

      if($check_sub == 1){




        $course_detail = DB::table('examples')->select(
          'examples.*',
          'examples.created_at as created_at_date',
          'examples.id as Eid',
          'categories.*',
          'categories.id as cat_id'
          )
          ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
          ->where('examples.id',$Eid)
          ->first();



        $course_tech = DB::table('questions')->select(
          'questions.*'
          )
          ->where('questions.category_id',$Eid)
          ->get();

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

        //  dd($course_tech);
        $s =0;
        $list = 1;

          return view('mycourse.my_ans_detail')->with([
               'course_tech' =>$course_tech,
               'course_detail' => $course_detail,
               'objs' => $objs,
               'sum' => $sum,
               's' => $s,
               'list' => $list
             ]);



      }else{

        return view('mycourse.my_ans_detail_null')->with([
             'objs' => $objs
           ]);

      }







    }





    public function ans_detail_post(Request $request)
    {

      $examples_id = $request['examples_id'];
      $examples_type = $request['examples_type'];
      $cat_id = $request['cat_id'];

      $course_tech = DB::table('questions')->select(
        'questions.*'
        )
        ->where('questions.category_id',$examples_id)
        ->get();


        $set_count = DB::table('answers')->select(
          'answers.*'
          )
          ->where('answers.user_id', Auth::user()->id)
          ->orwhere('answers.examples_id', $examples_id)
          ->orderBy('answers.id_option', 'desc')
          ->first();
      //  $input = $request->all();

        //  dd($set_count);
      $s = 0;
    /*  if($set_count == NULL){
        $id_option_num = 1;
      }else{
        $id_option_num = $set_count->id_option+1;

      } */

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





    //  $num = $id_option_num;

      if($examples_type == 1){
        $set = new setpoint();
        $set->examples_id_p  = $examples_id;
        $set->id_option_p = $num;
        $set->user_id = Auth::user()->id;
        $set->save();
      }

    if($course_tech){
    foreach($course_tech as $payment){

      $value = $request['value_'.$payment->id_questions];
      $id_questions = $payment->id_questions;



        if($payment->status == $value && $examples_type == 2){
          $payment = new answer();
          $payment->examples_id  = $examples_id;
          $payment->user_id = Auth::user()->id;
          $payment->question_id = $id_questions;
          $payment->id_option = $num;
          $payment->answers = $value;
          $payment->ans_status = 1;
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
          $payment->save();

          $the_id = $payment->id_option;
        }

        //echo 'value_'.$payment->id_questions;
        //dd('value_'.$payment->id_questions);
        //dd($payment);
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

      return redirect(url('success_ans/'.$the_id))->with('success','ยินดีด้วย');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function success_ans($id)
    {
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

        //  dd($course_detail);



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




            //dd($course_tech);
        return view('mycourse.success_ans')->with([
             'course_detail' =>$course_detail,
             'course_tech' =>$course_tech,
             'objs' => $objs,
             's' => $s,
             'sum' => $sum,
             'course_tech_count' => $course_tech_count,
             'course_tech_count_all' => $course_tech_count_all,
             'total' => $total
           ]);





    }

    public function my_state(){

      $objs = DB::table('users')
          ->select(
          'users.*',
          'levels.*',
          'levels.id as level_user'
          )
          ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
          ->where('users.id', Auth::user()->id)
          ->first();

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
            ->where('answers.user_id', Auth::user()->id)
            ->orderBy('answers.id_option', 'desc')
            ->groupBy('answers.id_option')
            ->paginate(15);

            foreach ($course_chart as $obj) {
                $optionsRes = [];
                $options = DB::table('answers')->select(
                  'answers.*'
                  )
                  ->where('answers.user_id', Auth::user()->id)
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





      //dd($course_chart);

      return view('mycourse.my_state')->with([
        'course_chart' => $course_chart,
           'objs' => $objs
         ]);



    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function user_rep(){

      $objs = DB::table('users')
          ->select(
          'users.*',
          'levels.*',
          'levels.id as level_user'
          )
          ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
          ->where('users.id', Auth::user()->id)
          ->first();


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






          //  dd($ranking);
      $s = 0;

      return view('profile.user_rep')->with([
        'header' => 'อันดับนักเรียนยอดเยี่ยม',
        'ranking' => $ranking,
        's1' => $s,
        'objs' => $objs
         ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
