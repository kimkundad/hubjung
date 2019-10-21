<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\blog;
use App\Http\Requests;

class NewsController extends Controller
{
  public function index()
  {


    //  $objs = blog::paginate(15);


      $objs = DB::table('blogs')
        ->select(
           'blogs.*'
           )
        ->where('b_status', 1)
        ->orderBy('id', 'desc')
        ->paginate(15);

      $data['objs'] = $objs;

      $popu = DB::table('blogs')
        ->select(
           'blogs.*',
           'blogs.image'
           )
        ->where('b_status', 1)
        ->orderBy('view', 'desc')
        ->limit(6)
        ->get();
        $data['popu'] = $popu;
      //dd($objs);
      return view('news.index',$data);
  }

  public function friend_reps($id){

    $objs = DB::table('users')
        ->select(
        'users.*',
        'levels.*',
        'levels.id as level_user'
        )
        ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
        ->where('users.id', $id)
        ->where('users.id', '!=', 1)
        ->first();




        $course_chart = DB::table('answers')->select(
          'answers.*',
          'answers.created_at as date_ans',
          'examples.*',
          'categories.*',
          'courses.*',
          'courses.id as course_id'
          )
          ->leftjoin('examples', 'examples.id', '=', 'answers.examples_id')
          ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
          ->leftjoin('courses', 'courses.id', '=', 'examples.course_id')
          ->where('answers.user_id', $id)
          ->orderBy('answers.id_option', 'desc')
          ->groupBy('answers.id_option')
          ->paginate(15);

          foreach ($course_chart as $obj) {
              $optionsRes = [];
              $options = DB::table('answers')->select(
                'answers.*'
                )
                ->where('answers.user_id', $id)
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


        return view('ranking.friend')->with([
          'course_chart' => $course_chart,
          'objs' => $objs
           ]);

  }


  public function user_reps(){

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

        $s = 0;

        return view('ranking.index')->with([
          'ranking' => $ranking,
          's1' => $s
           ]);

  }


  public function show($id)
  {
    $course_message = DB::table('submitcourses')
      ->select(
         'submitcourses.*',
         'submitcourses.user_id as Uid',
         'submitcourses.id as Oid',
         'submitcourses.created_at as Dcre',
         'users.*',
         'users.id as Ustudent',
         'courses.*',
         'banks.*',
         'courses.id as Ucourse'
         )
      ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
      ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
      ->leftjoin('banks', 'banks.id', '=', 'submitcourses.bank_id')
      ->where('submitcourses.status', '=', 1)
      ->count();

    $data['course_message'] = $course_message;

    $message_user = DB::table('messages')
    ->select(
    DB::raw('messages.*, max(messages.id) as id'),
    'users.*'
    )
    ->leftjoin('users', 'users.id', '=', 'messages.chat_user_id')
    ->where('messages.chat_user_id', '>', 1)
    ->where('messages.seen', 0)
    ->groupBy('messages.chat_user_id')
    ->get();
    $data['message_user'] = $message_user;


    $message = DB::table('messages')
     ->select(
     DB::raw('messages.*')
     )
     ->where('chat_user_id', '>', 1)
     ->where('seen', 0)
     ->groupBy('chat_user_id')
     ->get();

     $s = 0;
     foreach ($message as $obj) {
        $s++;

         $obj->options = $s;
     }
   $data['count_message'] = $s;



    $package = blog::find($id);
    $package->view += 1;
    $package->save();

    $orderBy = blog::limit(6);
    $data['orderBy'] = $orderBy;

    $popu = DB::table('blogs')
      ->select(
         'blogs.*',
         'blogs.image'
         )
      ->orderBy('view', 'desc')
      ->limit(6)
      ->get();
      $data['popu'] = $popu;
    //dd($popu);

    $objs = blog::find($id);
    $data['objs'] = $objs;
    return view('news.detail',$data);
  }
}
