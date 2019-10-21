<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\example;
use App\category;
use App\Http\Requests;
use App\course;
use App\answer;
use App\setpoint;
use Illuminate\Support\Facades\DB;
use Mail;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;

class Example_adminController extends Controller
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

      $objs = DB::table('setpoints')
          ->select(
          'setpoints.*',
          'setpoints.id as set_id',
          'examples.*',
          'users.*',
          'users.id as u_id',
          'courses.*'
          )
          ->where('setpoints.status_p', 0)
          ->leftjoin('examples', 'examples.id', '=', 'setpoints.examples_id_p')
          ->leftjoin('users', 'users.id', '=', 'setpoints.user_id')
          ->leftjoin('courses', 'courses.id', '=', 'examples.course_id')
          ->get();


          $objs_old = DB::table('setpoints')
              ->select(
              'setpoints.*',
              'setpoints.id as set_id',
              'examples.*',
              'users.*',
              'users.id as u_id',
              'courses.*'
              )
              ->where('setpoints.status_p', 1)
              ->leftjoin('examples', 'examples.id', '=', 'setpoints.examples_id_p')
              ->leftjoin('users', 'users.id', '=', 'setpoints.user_id')
              ->leftjoin('courses', 'courses.id', '=', 'examples.course_id')
              ->paginate(15);


          //dd($objs);
          $data['objs'] = $objs;
          $data['objs_old'] = $objs_old;
          $data['datahead'] = "ส่งแบบฝึกหัดมาใหม่";
          return view('admin.example_admin.index', $data);
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




     $objs = DB::table('setpoints')
         ->select(
         'setpoints.*',
         'setpoints.id as set_id',
         'examples.*',
         'examples.id as Eid',
         'users.*',
         'users.id as u_id',
         'courses.*'
         )
         ->where('setpoints.id', $id)
         ->leftjoin('examples', 'examples.id', '=', 'setpoints.examples_id_p')
         ->leftjoin('users', 'users.id', '=', 'setpoints.user_id')
         ->leftjoin('courses', 'courses.id', '=', 'examples.course_id')
         ->first();


         $course_tech = DB::table('questions')->select(
           'questions.*',
           'answers.question_id',
           'answers.answers',
           'answers.id as ans_id',
           'answers.ans_status',
           'answers.id_option'
           )
           ->leftjoin('answers', 'questions.id_questions', '=', 'answers.question_id')
           ->where('answers.id_option',$objs->id_option_p)
           ->get();


           $sum = 0;

           $course_ist = DB::table('questions')->select(
             'questions.*'
             )
             ->where('questions.category_id',$objs->examples_id_p)
             ->get();

//dd($objs);
      $data['url'] = url('admin/example_admin/'.$id);
      $data['course_tech'] = $course_tech;
      $data['objs'] = $objs;
      $data['method'] = "put";
      $data['datahead'] = "ตรวจแบบฝึกหัด";
      return view('admin.example_admin.edit', $data);

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



      $ans_id = $request['ans_id'];
      $answer_status = 0;
      if (sizeof($ans_id) > 0) {
                    for ($i = 0; $i < sizeof($ans_id); $i++) {


                        $value = $request['value_'.$ans_id[$i]];
                        $value_sum = $request['ans_status_'.$ans_id[$i]];

                        if($value_sum == 1){
                          $answer_status = 1;
                        }else{
                          $answer_status = 2;
                        }


                        $ids = $ans_id[$i];
                        $obj = answer::find($ids);
                        $obj->answers = $value;
                        $obj->ans_status = $value_sum;
                        $obj->answer_status = $answer_status;
                        $obj->save();

                    }

                }

                $obj = setpoint::find($id);
                $obj->status_p = 1;
                $obj->save();


                $objs = DB::table('setpoints')
                    ->select(
                    'setpoints.*',
                    'setpoints.id as set_id',
                    'examples.*',
                    'examples.id as Eid',
                    'users.*',
                    'users.id as u_id',
                    'courses.*'
                    )
                    ->where('setpoints.id', $id)
                    ->leftjoin('examples', 'examples.id', '=', 'setpoints.examples_id_p')
                    ->leftjoin('users', 'users.id', '=', 'setpoints.user_id')
                    ->leftjoin('courses', 'courses.id', '=', 'examples.course_id')
                    ->first();
                  //  dd($objs);



                    // send email
                      $data_toview = array();
                    //  $data_toview['pathToImage'] = "assets/image/email-head.jpg";
                      date_default_timezone_set("Asia/Bangkok");
                      $data_toview['name'] = $objs->name;
                      $data_toview['email'] = $objs->email;
                      $data_toview['image'] = $objs->image_course;
                      $data_toview['examples_name'] = $objs->examples_name;
                      $data_toview['title_course'] = $objs->title_course;
                      $data_toview['code_course'] = $objs->code_course;
                      $data_toview['price_course'] = $objs->price_course;
                      $data_toview['url'] = "http://www.learnsbuy.com/success_ans/".$objs->id_option_p;
                      $data_toview['datatime'] = date("d-m-Y H:i:s");

                      $email_sender   = 'learnsbuy@gmail.com';
                      $email_pass     = 'Ayumusiam168';

                  /*    $email_sender   = 'info@acmeinvestor.com';
                      $email_pass     = 'Iaminfoacmeinvestor';  */
                      $email_to       =  $objs->email;
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

                                  Mail::send('mails.mail_example', $data_toview, function($message) use ($data)
                                  {
                                      $message->from($data['emailto'], 'มีข้อความจาก learnsabuy');
                                      $message->to($data['sender'])
                                      ->replyTo($data['sender'], 'มีข้อความจาก learnsabuy.com')
                                      ->subject('ผลการตรวจสอบแบบฝึกหัด สำเร็จ learnsabuy.com');

                                      //echo 'Confirmation email after registration is completed.';
                                  });



                      }catch(\Swift_TransportException $e){
                          $response = $e->getMessage() ;
                          echo $response;

                      }


                      // Restore your original mailer
                      Mail::setSwiftMailer($backup);
                      // send email

    return redirect(url('admin/example_admin/'.$id.'/edit'))->with('success_check_course','ทำการตรวจคำตอบนักเรียน สำเร็จ');


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
