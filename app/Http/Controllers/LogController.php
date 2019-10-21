<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Auth;

class LogController extends Controller
{
    public function logsys(){


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
        //




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




      $coursess = DB::table('logsys')
        ->select(
           'logsys.*',
           'logsys.id as lid',
           'logsys.created_at as created_ats',
           'users.*',
           'users.name as name_user',
           'users.id as Ustudent',
           'courses.*',
           'courses.id as Ucourse'
           )
        ->leftjoin('users', 'users.id', '=', 'logsys.user_id')
        ->leftjoin('courses', 'courses.id', '=', 'logsys.course_id')
        ->orderBy('logsys.id', 'desc')
        ->get();

      $data['objs'] = $coursess;
      $data['datahead'] = "Log Sysytem";
      return view('admin.logs.index', $data);

    }
}
