<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Http\Requests;

class StreamController extends Controller
{
    //

    public function live_stream($id){

      $course = DB::table('courses')
       ->where('id', $id)
       ->first();

       $get_user_active = DB::table('users')
                 ->where('user_status', 1)
                 ->where('id', '!=', 1)
                 ->get();

       $data['get_user_active'] = $get_user_active;

      $data['course'] = $course;
      $data['count_user'] = 1;
      $data['channel'] = $id;
      $data['header'] = "Live Streamming";
      return view('live_stream', $data);

    }


    public function chat_room_get_user(Request $request){


    $get_data = DB::table('users')
              ->select(
              'users.*'
              )
              ->where('users.id', $request['user_id'])
              ->first();

              DB::table('users')
                  ->where('id', $request['user_id'])
                  ->update(array(
                    'user_status' => 1
                  ));


              $count_user = DB::table('users')
                        ->where('user_status', 1)
                        ->count();


      $arr['count_user'] = $count_user;
      $arr['name'] = $get_data->name;
      $arr['avatar'] = $get_data->avatar;
      $arr['provider'] = $get_data->provider;
      $arr['chat_user_id'] = $request['user_id'];
      $arr['message_in'] = "ยินดีต้อนรับเข้าสู่ห้อง";
      $arr['success'] = true;

      return json_encode($arr);
    }

    public function message_sender(Request $request){

      $get_data = DB::table('users')
                ->select(
                'users.*'
                )
                ->where('users.id', Auth::user()->id)
                ->first();


        $arr['name'] = $get_data->name;
        $arr['avatar'] = $get_data->avatar;
        $arr['provider'] = $get_data->provider;
        $arr['chat_user_id'] = Auth::user()->id;
        $arr['message_in'] = $request['message_in'];
        $arr['success'] = true;

        return json_encode($arr);

    }

}
