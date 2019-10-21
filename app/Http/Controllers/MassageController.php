<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\message;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class MassageController extends Controller
{
    public function index(){

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

      $message = DB::table('messages')
      ->select(
      'messages.*',
      'messages.id as id_ms',
      'messages.created_at as timer',
      'users.*'
      )
      ->leftjoin('users', 'users.id', '=', 'messages.chat_user_id')
      ->where('messages.chat_user_id', Auth::user()->id)
      ->orwhere('messages.agent_id', Auth::user()->id)
      ->orderBy('messages.id', 'asc')
      ->get();

      //dd($message);

      $objs = DB::table('users')
          ->select(
          'users.*',
          'levels.*',
          'levels.id as level_user'
          )
          ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
          ->where('users.id', Auth::user()->id)
          ->first();

          return view('message.index')->with([
               'objs' => $objs,
               'message' => $message
             ]);
    }
    public function index_admin(){

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




    $data['message'] = $message;
    $data['datahead'] = "Inbox";
    return view('admin.message.index', $data);
    }

    public function inbox_chat($id){
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

      $del_objs = DB::table('messages')
            ->where('chat_user_id', $id)
            ->update(['seen' => 1]);

      $objs = DB::table('users')
          ->select(
          'users.*'
          )
          ->where('users.id', $id)
          ->first();



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

        //  dd($message_user);

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
        // dd($objs);

        $message_history = DB::table('messages')
        ->select(
        'messages.*',
        'messages.created_at as timer',
        'users.*'
        )
        ->leftjoin('users', 'users.id', '=', 'messages.chat_user_id')
        ->whereIn('messages.chat_user_id', [Auth::user()->id, $id])
        ->whereIn('messages.agent_id', [Auth::user()->id, $id])
      //  ->where('messages.agent_id', Auth::user()->id)
        ->get();
        //dd($message_history);

        $data['message_user'] = $message_user;
        $data['message_history'] = $message_history;
        $data['count_message'] = $s;
        $data['message'] = $message;
      $data['student_data'] = $objs;
      return view('admin.message.inbox_chat', $data);
    }

    public function message_sender(Request $request){

      $message_2 = DB::table('messages')
       ->select(
       DB::raw('messages.*')
       )
       ->where('chat_user_id', '>', 1)
       ->where('seen', 0)
       ->groupBy('chat_user_id')
       ->get();
       $check_noti = 0;
       foreach ($message_2 as $obj) {

          if($obj->chat_user_id == Auth::user()->id){
            $check_noti = 1;
          }

       }


      $payment = new message();
      $payment->agent_id  = 1;
      $payment->chat_user_id = Auth::user()->id;
      $payment->message = $request['message_in'];
      $payment->save();


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


      $get_data = DB::table('messages')
                    ->select(
                    'messages.*',
                    'messages.created_at as timer',
                    'users.*'
                    )
                    ->leftjoin('users', 'users.id', '=', 'messages.chat_user_id')
                    ->where('messages.chat_user_id', Auth::user()->id)
                    ->orderBy('messages.id', 'desc')
                    ->first();

                    $playerid = DB::table('users')
                                  ->select(
                                  'users.playerid'
                                  )
                                  ->where('users.id', Auth::user()->id)
                                  ->first();

      $arr['timer'] = $get_data->timer;
      $arr['name'] = $get_data->name;
      $arr['avatar'] = $get_data->avatar;
      $arr['provider'] = $get_data->provider;
      $arr['check_noti'] = $check_noti;
      $arr['new_count_message'] = $s;
      $arr['agent_id'] = $get_data->agent_id;
      $arr['chat_user_id'] = $get_data->chat_user_id;
      $arr['message_in'] = $get_data->message;
      $arr['playerid'] = $playerid->playerid;
      $arr['success'] = true;
      return json_encode($arr);
    }




    public function admin_message_sender(Request $request){


      $student_id = $request['studen_user'];

      $payment = new message();
      $payment->agent_id  = $request['studen_user'];
      $payment->chat_user_id = Auth::user()->id;
      $payment->message = $request['message_in'];;
      $payment->save();


      $del_objs = DB::table('messages')
            ->where('chat_user_id', $student_id)
            ->update(['seen' => 1]);


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


       }

       $get_data = DB::table('messages')
                     ->select(
                     'messages.*',
                     'messages.created_at as timer',
                     'users.*'
                     )
                     ->leftjoin('users', 'users.id', '=', 'messages.chat_user_id')
                     ->where('messages.chat_user_id', Auth::user()->id)
                     ->orderBy('messages.id', 'desc')
                     ->first();


                     $playerid = DB::table('users')
                                   ->select(
                                   'users.playerid'
                                   )
                                   ->where('users.id', $get_data->agent_id)
                                   ->first();

                                   //dd($get_data->chat_user_id);

       $arr['timer'] = $get_data->timer;
       $arr['name'] = $get_data->name;
       $arr['avatar'] = $get_data->avatar;
       $arr['provider'] = $get_data->provider;
       $arr['playerid'] = $playerid->playerid;
       $arr['new_count_message'] = $s;
       $arr['agent_id'] = $get_data->agent_id;
       $arr['chat_user_id'] = $get_data->chat_user_id;
       $arr['message_in'] = $get_data->message;
       $arr['success'] = true;
       return json_encode($arr);


    }




}
