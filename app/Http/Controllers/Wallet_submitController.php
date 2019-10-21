<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\bank;
use App\wallet_submit;
use App\Http\Requests;
use App\cardmoney;
use Illuminate\Support\Facades\DB;
use Mail;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;
use App\history_pay;

class Wallet_submitController extends Controller
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



     $coursess = DB::table('wallet_submits')
       ->select(
          'wallet_submits.*',
          'wallet_submits.id as Uid',
          'wallet_submits.created_at as Dcre',
          'users.*',
          'users.id as Ustudent',
          'banks.*',
          'cardmoneys.*',
          'cardmoneys.id as cardif'
          )
       ->leftjoin('users', 'users.id', '=', 'wallet_submits.user_id')
       ->leftjoin('cardmoneys', 'cardmoneys.id', '=', 'wallet_submits.card_id')
       ->leftjoin('banks', 'banks.id', '=', 'wallet_submits.bank_id')
       ->where('wallet_submits.status', '=', 0)
       ->get();


       $coursess_suc = DB::table('wallet_submits')
         ->select(
            'wallet_submits.*',
            'wallet_submits.id as Uid',
            'wallet_submits.created_at as Dcre',
            'users.*',
            'users.id as Ustudent',
            'banks.*',
            'cardmoneys.*',
            'cardmoneys.id as cardif'
            )
         ->leftjoin('users', 'users.id', '=', 'wallet_submits.user_id')
         ->leftjoin('cardmoneys', 'cardmoneys.id', '=', 'wallet_submits.card_id')
         ->leftjoin('banks', 'banks.id', '=', 'wallet_submits.bank_id')
         ->where('wallet_submits.status', '=', 1)
         ->paginate(10);

      // dd($coursess);

      $data['objs'] = $coursess;
      $data['coursess_suc'] = $coursess_suc;
      $data['datahead'] = "รายการสั่งซื้อทั้งหมด";
      return view('admin.wallet.index', $data);
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

    public function post_wallet(Request $request)
    {
      $image = $request->file('image');

      $this->validate($request, [
           'bank_id' => 'required',
           'totalmoney' => 'required',
           'day' => 'required',
           'card_id' => 'required',
           'user_id' => 'required'
       ]);

       if($image == NULL){

         $package = new wallet_submit();
         $package->bank_id = $request['bank_id'];
         $package->money_user = $request['totalmoney'];
         $package->date_transfer = $request['day'];
         $package->time_transfer = $request['timer'];
         $package->status = 0;
         $package->card_id = $request['card_id'];
         $package->user_id = $request['user_id'];
         $package->save();

       }else{


         $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

          $destinationPath = asset('assets/images/avatar');
          $img = Image::make($image->getRealPath());
          $img->resize(500, 500, function ($constraint) {
          $constraint->aspectRatio();
        })->save('assets/bill/'.$input['imagename']);

        $package = new wallet_submit();
        $package->bank_id = $request['bank_id'];
        $package->money_user = $request['totalmoney'];
        $package->date_transfer = $request['day'];
        $package->time_transfer = $request['timer'];
        $package->status = 0;
        $package->card_id = $request['card_id'];
        $package->user_id = $request['user_id'];
        $package->bill_image = $input['imagename'];
        $package->save();

       }

       $the_id = $package->id;

       $coursess = DB::table('wallet_submits')
         ->select(
            'wallet_submits.*',
            'wallet_submits.id as Uid',
            'users.*',
            'banks.*',
            'cardmoneys.*'
            )
         ->where('wallet_submits.user_id', Auth::user()->id)
         ->where('wallet_submits.id', $the_id)
         ->leftjoin('users', 'users.id', '=', 'wallet_submits.user_id')
         ->leftjoin('cardmoneys', 'cardmoneys.id', '=', 'wallet_submits.card_id')
         ->leftjoin('banks', 'banks.id', '=', 'wallet_submits.bank_id')
         ->first();

        // dd($coursess);


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
         $email_to       =  Auth::user()->email;
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

                     Mail::send('mails.wallet', $data_toview, function($message) use ($data)
                     {
                         $message->from($data['sender'], 'Learnsbuy');
                         $message->to($data['sender'])
                         ->replyTo($data['sender'], 'Learnsbuy.')
                         ->subject('ใบเสร็จสำหรับการสั่งซื้อบัตรเติมเงิน Learnsbuy ');

                         //echo 'Confirmation email after registration is completed.';
                     });


                     Mail::send('mails.wallet', $data_toview, function($message) use ($data)
                     {
                         $message->from($data['sender'], 'Learnsbuy');
                         $message->to($data['emailto'])
                         ->replyTo($data['sender'], 'Learnsbuy.')
                         ->subject('ใบเสร็จสำหรับการสั่งซื้อบัตรเติมเงิน Learnsbuy ');

                         //echo 'Confirmation email after registration is completed.';
                     });

         }catch(\Swift_TransportException $e){
             $response = $e->getMessage() ;
             echo $response;

         }


         // Restore your original mailer
         Mail::setSwiftMailer($backup);
         // send email










        return view('wallet.success_wallet')->with([
             'courseinfo' =>$coursess
           ]);



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

    public function buy_wallet($id)
    {
      $bank = DB::table('banks')
        ->get();

        $cardmoney = DB::table('cardmoneys')
          ->select(
             'cardmoneys.*'
             )
          ->where('cardmoneys.id', $id)
          ->first();

          $data['bank'] = $bank;
          $data['cardmoney'] = $cardmoney;

          return view('wallet.get_wallet', $data);
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



        $coursess = DB::table('wallet_submits')
          ->select(
             'wallet_submits.*',
             'wallet_submits.id as Uid',
             'wallet_submits.created_at as Dcre',
             'users.*',
             'users.id as Ustudent',
             'banks.*',
             'cardmoneys.*',
             'cardmoneys.id as cardif'
             )
          ->where('wallet_submits.id', $id)
          ->leftjoin('users', 'users.id', '=', 'wallet_submits.user_id')
          ->leftjoin('cardmoneys', 'cardmoneys.id', '=', 'wallet_submits.card_id')
          ->leftjoin('banks', 'banks.id', '=', 'wallet_submits.bank_id')
          ->first();

      //dd($coursess);
      $data['method'] = "put";
      $data['url'] = url('admin/wallet/'.$id);
      $data['courseinfo'] = $coursess;
      $data['datahead'] = "จัดการคำสั่งซื้อทั้งหมด";
      return view('admin.wallet.edit', $data);
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
   'status' => 'required',
   'card_point' => 'required'
    ]);


    $upobj = DB::table('wallet_submits')
        ->select(
        'wallet_submits.*'
        )
        ->where('id', $id)
        ->update(array(
          'status' => $request['status']
        ));


        $users_count = DB::table('history_pays')
                ->where('user_id', $request['user_id'])
                ->count();


                $user = DB::table('users')
                    ->select(
                    'users.*'
                    )
                    ->where('users.id', $request['user_id'])
                    ->first();

        if($users_count > 0){


      /*    $users_coin_sum = DB::table('history_pays')
                  ->select(DB::raw('SUM(history_pays.total_coin) as total_sales'))
                  ->where('history_pays.type_pay', 1)
                  ->orwhere('history_pays.type_pay', 2)
                  ->get(); */

                  //dd($users_coin_sum);

                $obj = new history_pay();
                $obj->name = 'เติมเงินเข้าระบบ : '.$request['course_tran'];
                $obj->type_pay = 2;
                $obj->money = $request['money_tran'];
                $obj->total_coin = $request['card_point'];
                $obj->user_id = $request['user_id'];
                $obj->save();

                $coin_sum = $user->user_coin + $request['card_point'];

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
          $obj->name = 'เติมเงินเข้าระบบ : '.$request['course_tran'];
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
                'user_coin' => $request['card_point']
              ));



        }








        $status_user = $request->get('status');


        if($status_user == 1){



            $coursess = DB::table('wallet_submits')
              ->select(
                 'wallet_submits.*',
                 'wallet_submits.id as Uid',
                 'wallet_submits.created_at as Dcre',
                 'users.*',
                 'users.id as Ustudent',
                 'banks.*',
                 'cardmoneys.*',
                 'cardmoneys.id as cardif'
                 )
              ->where('wallet_submits.id', $id)
              ->leftjoin('users', 'users.id', '=', 'wallet_submits.user_id')
              ->leftjoin('cardmoneys', 'cardmoneys.id', '=', 'wallet_submits.card_id')
              ->leftjoin('banks', 'banks.id', '=', 'wallet_submits.bank_id')
              ->first();





          // send email
            $data_toview = array();
          //  $data_toview['pathToImage'] = "assets/image/email-head.jpg";

          date_default_timezone_set("Asia/Bangkok");
          $data_toview['data'] = $coursess;
          $data_toview['datatime'] = date("d-m-Y H:i:s");


            $email_sender   = 'learnsbuy@gmail.com';
            $email_pass     = 'Homeayumu4549';

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

                        Mail::send('mails.wallet2', $data_toview, function($message) use ($data)
                        {
                            $message->from($data['sender'], 'Learnsbuy');
                            $message->to($data['sender'])
                            ->replyTo($data['sender'], 'Learnsbuy.')
                            ->subject('ทำรายการสำหรับการสั่งซื้อบัตรเติมเงิน Learnsbuy สำเร็จ');

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



        return redirect(url('admin/wallet/'.$id.'/edit'))->with('edit_order','แก้ไขข้อมูล สำเร็จ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $obj = wallet_submit::find($id);
      $obj->delete();
      return redirect(url('admin/wallet'))->with('delete','Delete successful');
    }
}
