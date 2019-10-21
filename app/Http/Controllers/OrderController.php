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
use Mail;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;
use App\history_pay;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

      $coursess = DB::table('submitcourses')
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
        ->orderBy('submitcourses.id', 'desc')
        ->get();

      $data['objs'] = $coursess;
      $data['datahead'] = "รายการสั่งซื้อทั้งหมด";
      return view('admin.order.index', $data);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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


      $coursess = DB::table('submitcourses')
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
        ->where('submitcourses.id', $id)
        ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
        ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
        ->leftjoin('banks', 'banks.id', '=', 'submitcourses.bank_id')
        ->first();


        $coupon_count = DB::table('coupon_users')->select(
              'coupon_users.*'
              )
              ->where('user_id', $coursess->Uid)
              ->where('order_id', $coursess->Oid)
              ->count();

              if($coupon_count > 0){

                $coupon_get = DB::table('coupon_users')->select(
                      'coupon_users.*'
                      )
                      ->where('user_id', $coursess->Uid)
                      ->where('order_id', $coursess->Oid)
                      ->first();

                      $coupon = DB::table('coupons')->select(
                            'coupons.*'
                            )
                            ->where('id', $coupon_get->c_id)
                            ->first();

                            $data['get_coupon'] = $coupon;

              }else{
                $data['get_coupon'] = null;
              }


              $data['coupon_count'] = $coupon_count;


      //dd($coursess);
      $data['method'] = "put";
      $data['url'] = url('admin/order_shop/'.$id);
      $data['courseinfo'] = $coursess;
      $data['datahead'] = "จัดการคำสั่งซื้อทั้งหมด";
      return view('admin.order.edit', $data);
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
      $this->validate($request, [
   'end_day' => 'required',
   'status' => 'required',
   'hrcourse' => 'required',
   'course_tran' => 'required',
   'money_tran' => 'required'
    ]);

    $status_check = $request['status'];


    date_default_timezone_set("Asia/Bangkok");

               $data_date = date("Y-m-d H:i:s");


    $upobj = DB::table('submitcourses')
        ->select(
        'submitcourses.*'
        )
        ->where('id', $id)
        ->update(array(
          'end_day' => $request['end_day'],
          'status' => $request['status']
        ));


        if($status_check == 2){


          DB::table('coupon_users')
              ->select(
              'coupon_users.*'
              )
              ->where('order_id', $id)
              ->update(array(
                'coupon_status' => 1
              ));

        }


        $users_count = DB::table('history_pays')
                ->where('user_id', $request['user_id'])
                ->count();

        if($users_count > 0){


          $user = DB::table('users')
              ->select(
              'users.*'
              )
              ->where('users.id', $request['user_id'])
              ->first();

      /*    $users_coin_sum = DB::table('history_pays')
                  ->select(DB::raw('SUM(history_pays.total_coin) as total_sales'))
                  ->where('history_pays.type_pay', 1)
                  ->orwhere('history_pays.type_pay', 2)
                  ->get(); */

                  //dd($users_coin_sum);

                $obj = new history_pay();
                $obj->name = 'ซื้อคอร์สเรียน : '.$request['course_tran'];
                $obj->type_pay = 1;
                $obj->money = $request['money_tran'];
                $obj->total_coin = $request['hrcourse'];
                $obj->user_id = $request['user_id'];
                $obj->save();

                $coin_sum = $user->user_coin + $request['hrcourse'];

                  $user_coin = DB::table('users')
                      ->select(
                      'users.*'
                      )
                      ->where('id', $request['user_id'])
                      ->update(array(
                        'user_coin' => $coin_sum
                      ));





        }else{





                $obj = new history_pay();
                $obj->name = 'ซื้อคอร์สเรียน : '.$request['course_tran'];
                $obj->type_pay = 1;
                $obj->money = $request['money_tran'];
                $obj->total_coin = $request['hrcourse'];
                $obj->user_id = $request['user_id'];
                $obj->save();



                $user_coin = DB::table('users')
                    ->select(
                    'users.*'
                    )
                    ->where('id', $request['user_id'])
                    ->update(array(
                      'user_coin' => $request['hrcourse']
                    ));



        }










        $status_user = $request->get('status');


        if($status_user == 2){


          $coursess = DB::table('submitcourses')
            ->select(
               'submitcourses.*',
               'submitcourses.user_id as Uid',
               'submitcourses.id as Oid',
               'users.*',
               'banks.*',
               'courses.*'
               )
            ->where('submitcourses.id', $id)
            ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
            ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
            ->leftjoin('banks', 'banks.id', '=', 'submitcourses.bank_id')
            ->first();





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

                        Mail::send('mails.index2', $data_toview, function($message) use ($data)
                        {
                            $message->from($data['sender'], 'Learnsbuy');
                            $message->to($data['sender'])
                            ->replyTo($data['sender'], 'Learnsbuy.')
                            ->subject('ทำรายการสำหรับการสั่งซื้อคอร์สเรียน Learnsbuy สำเร็จ');

                            //echo 'Confirmation email after registration is completed.';
                        });

            }catch(\Swift_TransportException $e){
                $response = $e->getMessage() ;
                echo $response;

            }


            // Restore your original mailer
            Mail::setSwiftMailer($backup);
            // send email








       }

       return redirect(url('admin/order_shop/'.$id.'/edit'))->with('edit_order','แก้ไขข้อมูล สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $obj = DB::table('submitcourses')
      ->where('submitcourses.id', $id)
      ->delete();

      return redirect(url('admin/order_shop/'))->with('delete','ลบข้อมูล สำเร็จ');
    }
}
