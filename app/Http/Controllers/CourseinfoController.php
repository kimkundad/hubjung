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
use Session;
use App\Users;
use App\submitcourse;
use App\bank;
use Mail;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;
use App\qrcode;
use App\comment;
use Response;

class CourseinfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


      $filecourses = DB::table('filecourses')
       ->where('course_id', $id)
       ->get();




      // dd($filecourses);


      $courseinfo = course::find($id);

      if (Auth::user()) {

        $check_course = DB::table('submitcourses')
          ->select(
             'submitcourses.*'
             )
          ->where('submitcourses.course_id', $id)
          ->where('submitcourses.user_id', Auth::user()->id)
          ->count();



      }else{
        $check_course = 0;
      }

    //  dd($check_course);

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

          //dd($comment_course);

      $coursess = DB::table('courses')
        ->select(
           'submitcourses.*',
           'submitcourses.user_id as Uid',
           'submitcourses.id as Oid',
           'users.*',
           'courses.*'
           )
        ->where('courses.id', $id)
        ->leftjoin('submitcourses', 'courses.id', '=', 'submitcourses.course_id')
        ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
        ->get();


        $video_list = DB::table('video_lists')
         ->select(
         DB::raw('video_lists.*')
         )
         ->where('course_id', $id)
         ->orderBy('order_sort', 'asc')
         ->get();

      //   dd($check_course);
    //  dd($coursess);
      $data['header'] = "แก้ไขคอร์ส";
      //dd($courseinfo);
      return view('course.courseinfo')->with([
           'video_list' => $video_list,
           'courseinfos' =>$coursess,
           'count_course' => $count_course,
           'comment_course' => $comment_course,
           'file' => $filecourses,
           'objs' => $courseinfo,
           'check_course' => $check_course
         ]);
    }


    public function download_file_course($id){

      $obj = filecourse::find($id);
      $file = public_path().'/assets/file_courses/'.$obj->file_of_course;
       return Response::download($file);

    }



    public function checkmycourse($id)
    {
      $bank = DB::table('banks')
        ->get();
      $getc = DB::table('submitcourses')
        ->select(
           'submitcourses.*'
           )
        ->where('submitcourses.user_id', Auth::user()->id)
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
        ->where('submitcourses.user_id', Auth::user()->id)
        ->where('submitcourses.id', $getc->id)
        ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
        ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
        ->first();

    //  dd($data);

   return view('confirm_course.pay_course')->with([
        'courseinfo' =>$coursess,
        'bank' => $bank,
        'bill' =>"บิลเลขที่"
      ]);
    }





    public function confirm_course($id)
    {
      $courseinfo = course::find($id);

      $count_course = DB::table('submitcourses')
        ->select(
           'submitcourses.*'
           )
        ->where('submitcourses.user_id', Auth::user()->id)
        ->where('submitcourses.course_id', $courseinfo->id)
        ->first();


        $coursess = DB::table('submitcourses')
          ->select(
             'submitcourses.*',
             'submitcourses.user_id as Uid',
             'submitcourses.id as Oid',
             'users.*',
             'courses.*'
             )
          ->where('submitcourses.user_id', Auth::user()->id)
          ->where('submitcourses.course_id', $courseinfo->id)
          ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
          ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
          ->first();

      //dd($count_course);
      if(isset($count_course)){

        if($count_course->status == 1 || $count_course->status == 2){

          return view('confirm_course.bil_course')->with([
            'courseinfo' =>$coursess,
            'user' =>"แก้ไขคอร์ส"
          ]);

        }else{

          return view('confirm_course.index')->with([
            'objs' =>$courseinfo,
            'user' =>"แก้ไขคอร์ส"
          ]);

        }

      }else{
        return view('confirm_course.index')->with([
          'objs' =>$courseinfo,
          'user' =>"แก้ไขคอร์ส"
        ]);
      }





    }



    public function pay_course(Request $request, $id)
    {



      $coursess = DB::table('submitcourses')
        ->select(
           'submitcourses.*',
           'submitcourses.user_id as Uid',
           'submitcourses.id as Oid',
           'users.*',
           'courses.*'
           )
        ->where('submitcourses.user_id', Auth::user()->id)
        ->where('submitcourses.id', $id)
        ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
        ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
        ->first();

    //  dd($data);

    /*  return view('confirm_course.pay_course')->with([
        'objs' =>$courseinfo,
        'bill' =>"บิลเลขที่"
      ]); */

      return redirect(url('pay_course/'.$id))->with('hbd','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');


    }












    public function submit_course_free(Request $request, $id)
    {

      $bank = DB::table('banks')
        ->get();

        $day_hbd = $request->get('day_hbd');
        $mo_hbd = $request->get('mo_hbd');
        $year_hbd = $request->get('year_hbd');

        if($day_hbd == null || $mo_hbd == null || $year_hbd == null){
            return redirect(url('confirm_course/'.$id))->with('hbd','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');
        }

        $hbd = $year_hbd."-".$mo_hbd."-".$day_hbd;

        $this->validate($request, [
             'name' => 'required',
             'phone' => 'required',
             'address' => 'required',
             'line' => 'required',
         ]);

            $package = Users::find(Auth::user()->id);
            $package->name = $request['name'];
            $package->hbd = $hbd;
            $package->phone = $request['phone'];
            $package->line_id = $request['line'];
            $package->address = $request['address'];
            $package->save();


       $countobj = DB::table('submitcourses')
         ->select(
            'submitcourses.*'
            )
         ->where('submitcourses.user_id', Auth::user()->id)
         ->where('submitcourses.course_id', $id)
         ->count();



      if($countobj > 0){

        $getc = DB::table('submitcourses')
          ->select(
             'submitcourses.*'
             )
          ->where('submitcourses.user_id', Auth::user()->id)
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
          ->where('submitcourses.user_id', Auth::user()->id)
          ->where('submitcourses.id', $getc->id)
          ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
          ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
          ->first();

      //  dd($data);

     return view('confirm_course.pay_course_free')->with([
          'courseinfo' =>$coursess
        ]);

      } else{

        $package = new submitcourse();
        $package->user_id = Auth::user()->id;
        $package->course_id = $id;
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
          ->where('submitcourses.user_id', Auth::user()->id)
          ->where('submitcourses.id', $the_id)
          ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
          ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
          ->first();

      //  dd($data);

     return view('confirm_course.pay_course_free')->with([
          'courseinfo' =>$coursess
        ]);


      }




    }










    public function submit_course(Request $request, $id)
    {

    //  dd(Session::get('coupon'));
      $bank = DB::table('banks')
        ->get();

      $day_hbd = $request->get('day_hbd');
      $mo_hbd = $request->get('mo_hbd');
      $year_hbd = $request->get('year_hbd');

      if($day_hbd == null || $mo_hbd == null || $year_hbd == null){
          return redirect(url('confirm_course/'.$id))->with('hbd','กรอกวันเกิดนักเรียนด้วยนะจ๊ะ');
      }
      $mo_hbd += 1;
      $hbd = $year_hbd."-".$mo_hbd."-".$day_hbd;

      $this->validate($request, [
           'name' => 'required',
           'phone' => 'required',
           'address' => 'required',
           'line' => 'required',
       ]);



          $package = Users::find(Auth::user()->id);
          $package->name = $request['name'];
          $package->email = $request['email'];
          $package->hbd = $hbd;
          $package->phone = $request['phone'];
          $package->line_id = $request['line'];
          $package->address = $request['address'];
          $package->save();




       $countobj = DB::table('submitcourses')
         ->select(
            'submitcourses.*'
            )
         ->where('submitcourses.user_id', Auth::user()->id)
         ->where('submitcourses.course_id', $id)
         ->count();



      if($countobj > 0){

        $getc = DB::table('submitcourses')
          ->select(
             'submitcourses.*'
             )
          ->where('submitcourses.user_id', Auth::user()->id)
          ->where('submitcourses.course_id', $id)
          ->first();

        //  dd($getc->Oid);

        $coursess = DB::table('submitcourses')
          ->select(
             'submitcourses.*',
             'submitcourses.user_id as Uid',
             'submitcourses.id as Oid',
             'users.*',
             'courses.*',
             'courses.id as c_ids'
             )
          ->where('submitcourses.user_id', Auth::user()->id)
          ->where('submitcourses.id', $getc->id)
          ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
          ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
          ->first();

      //  dd($data);

     return view('confirm_course.pay_course')->with([
          'courseinfo' =>$coursess,
          'bank' => $bank,
          'bill' =>"บิลเลขที่"
        ]);

      } else{

        $package = new submitcourse();
        $package->user_id = Auth::user()->id;
        $package->course_id = $id;
        $package->save();

        $the_id = $package->id;


        $coursess = DB::table('submitcourses')
          ->select(
             'submitcourses.*',
             'submitcourses.user_id as Uid',
             'submitcourses.id as Oid',
             'users.*',
             'courses.*',
             'courses.id as c_ids'
             )
          ->where('submitcourses.user_id', Auth::user()->id)
          ->where('submitcourses.id', $the_id)
          ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
          ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
          ->first();

      //  dd($data);

     return view('confirm_course.pay_course')->with([
          'courseinfo' =>$coursess,
          'bank' => $bank,
          'bill' =>"บิลเลขที่"
        ]);


      }




    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }



    public function bil_course(Request $request, $id)
    {

      session()->forget('coupon');

      $this->validate($request, [
           'bankname' => 'required',
           'totalmoney' => 'required',
           'day' => 'required'
       ]);


       $countobj = DB::table('submitcourses')
         ->select(
            'submitcourses.*'
            )
         ->where('submitcourses.user_id', Auth::user()->id)
         ->where('submitcourses.id', $id)
         ->first();

       if($countobj->status > 0){

         $coursess = DB::table('submitcourses')
           ->select(
              'submitcourses.*',
              'submitcourses.user_id as Uid',
              'submitcourses.id as Oid',
              'users.*',
              'courses.*'
              )
           ->where('submitcourses.user_id', Auth::user()->id)
           ->where('submitcourses.id', $id)
           ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
           ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
           ->first();

          return view('confirm_course.bil_course')->with([
               'courseinfo' =>$coursess,
               'bill' =>"บิลเลขที่"
             ]);

       }else{

         $image = $request->file('image');


        if($image == NULL){

         $package = submitcourse::find($id);
         $package->bank_id = $request['bankname'];
         $package->money_tran = $request['totalmoney'];
         $package->date_tran = $request['day'];
         $package->time_tran = $request['timer'];
         $package->status = 1;
         $package->save();

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


        $package = submitcourse::find($id);
        $package->bank_id = $request['bankname'];
        $package->money_tran = $request['totalmoney'];
        $package->date_tran = $request['day'];
        $package->time_tran = $request['timer'];
        $package->status = 1;
        $package->bill_image = $input['imagename'];
        $package->bill_image_small = $input['imagename_small'];
        $package->save();

       }


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
           ->where('submitcourses.user_id', Auth::user()->id)
           ->where('submitcourses.id', $id)
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




            $message = Auth::user()->name." ได้สั่งซื้อคอร์ส : ".$coursess->title_course.", ธนาคาร :".$coursess->bank_name.", ยอดโอน : ".$coursess->money_tran.", ส่วนลด : ".$coursess->discount_price;
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






           session()->forget('coupon');


          return view('confirm_course.bil_course')->with([
               'courseinfo' =>$coursess,
               'bill' =>"บิลเลขที่"
             ]);


       }


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
