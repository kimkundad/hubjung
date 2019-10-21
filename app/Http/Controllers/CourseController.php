<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Hash;
use App\course;
use App\typecourses;
use App\Http\Requests;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Excel;
use File;
use App\question;
use App\option;
use App\example;
use App\filecourse;
use App\category;
use App\department;
use Response;
use App\video_list;
use App\example_video;

class CourseController extends Controller
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


        $objs = DB::table('courses')
            ->select(
            'courses.*',
            'examples.id as e_id',
            'courses.id as c_id'
            )
            ->leftjoin('examples', 'examples.course_id', '=', 'courses.id')
            ->orderBy('id', 'desc')
            ->groupBy('courses.id')
            ->paginate(15);

        $course = typecourses::all();
        $department = department::all();
        $data['department'] = $department;
        $data['course'] = $course;
        $data['objs'] = $objs;
        $data['datahead'] = "คอร์สเรียนทั้งหมด";
        return view('admin.course.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function video_course_edit($id){

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


      $get_video = DB::table('video_lists')
          ->select(
          'video_lists.*'
          )
          ->where('id', $id)
          ->first();


      $data['get_video'] = $get_video;
       $data['datahead'] = "แก้ไข video";
       return view('admin.course.video_course_edit', $data);
     }



     public function video_course_edit2($id){

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


      $get_video = DB::table('example_videos')
          ->select(
          'example_videos.*'
          )
          ->where('id', $id)
          ->first();


      $data['get_video'] = $get_video;
       $data['datahead'] = "แก้ไข video";
       return view('admin.course.video_course_edit2', $data);
     }


     public function message_chat($id){


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


      $data2 = \DB::table('message_chat')
        ->select(\DB::raw('CAST(created_at as date) as created_at'))
        ->where('room_id', $id)
        ->orderBy('created_at', 'desc')
        ->distinct('created_at')->get();

      /*  $cat = DB::table('wishlists')->select(
              DB::raw("DATE_FORMAT(created_at, '%d-%b-%Y') as formatted_dob")
              )
              ->groupBy('formatted_dob')
              ->get(); */



              foreach($data2 as $u){

                $get_value_a = array();

                $cat2 = \DB::table('message_chat')
                      ->select(
                        'message_chat.*',
                        'users.id',
                        'users.name',
                        'users.avatar',
                        'users.provider',
                        \DB::raw("DATE_FORMAT(message_chat.created_at, '%Y-%m-%d') as formatted_dob")
                        )
                      ->leftjoin('users', 'users.id', '=', 'message_chat.user_id')
                      ->where(\DB::raw("DATE_FORMAT(message_chat.created_at, '%Y-%m-%d')"), $u->created_at)
                      ->get();



                  $get_value_a = $cat2;
                  $u->option = $cat2;
              }

      //    dd($data2);





      $data['data2'] = $data2;
      $data['datahead'] = "Changelog Chat";
      return view('admin.course.message_chat', $data);

     }



     public function post_status(Request $request){

        //  $user = course::findOrFail($request->course_id);


        //  $course_id = $request->course_id;


    $user = course::findOrFail($request->course_id);

          if($user->ch_status == 1){
              $user->ch_status = 0;
          } else {
              $user->ch_status = 1;
          }


  return response()->json([
  'data' => [
    'success' => $user->save(),
  ]
]);


}



    public function create()
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

        $department = department::all();
        $course = typecourses::all();
        $data['course'] = $course;
        $data['department'] = $department;
        $data['method'] = "post";
        $data['url'] = url('admin/course');
        $data['header'] = "เพิ่มคอร์ส";
        return view('admin.course.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function post_edit_video_course(Request $request){

       $image = $request->file('image');
       $file = $request->file('file');

       $this->validate($request, [
            'course_id' => 'required',
            'name_video' => 'required'
        ]);
        $id = $request['video_id'];
        if($image == null && $file == null){

          $obj = video_list::find($id);
          $obj->time_video = $request['time_video'];
          $obj->course_video_name = $request['name_video'];
          $obj->course_video_detail = $request['course_video_detail'];
          $obj->save();

        }elseif($image != null && $file == null){

          $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

           $img = Image::make($image->getRealPath());
           $img->resize(640, 360, function ($constraint) {
           $constraint->aspectRatio();
       })->save('assets/uploads/'.$input['imagename']);

       $obj = video_list::find($id);
       $obj->course_video_name = $request['name_video'];
       $obj->time_video = $request['time_video'];
       $obj->course_video_detail = $request['course_video_detail'];
       $obj->thumbnail_img = $input['imagename'];
       $obj->save();

        }elseif($image == null && $file != null){

          $destinationPath = 'assets/videos';
          $input['file'] = time().'.'.$file->getClientOriginalExtension();
          $request->file('file')->move($destinationPath, $input['file']);

          $obj = video_list::find($id);
          $obj->course_video_name = $request['name_video'];
          $obj->time_video = $request['time_video'];
          $obj->course_video_detail = $request['course_video_detail'];
          $obj->course_video = $input['file'];
          $obj->course_video_url = "https://learnsbuy.com/assets/videos/".$input['file'];
          $obj->save();

        }else{

          $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

           $img = Image::make($image->getRealPath());
           $img->resize(640, 360, function ($constraint) {
           $constraint->aspectRatio();
       })->save('assets/uploads/'.$input['imagename']);


          $destinationPath = 'assets/videos';
          $input['file'] = time().'.'.$file->getClientOriginalExtension();
          $request->file('file')->move($destinationPath, $input['file']);

          $obj = video_list::find($id);
          $obj->course_video_name = $request['name_video'];
          $obj->time_video = $request['time_video'];
          $obj->course_video_detail = $request['course_video_detail'];
          $obj->course_video = $input['file'];
          $obj->course_video_url = "https://learnsbuy.com/assets/videos/".$input['file'];
          $obj->thumbnail_img = $input['imagename'];
          $obj->save();




        }



       return redirect(url('admin/course/'.$request['course_id'].'/edit#video_set'))->with('success_edit_video','แก้ไขข้อมูล Video สำเร็จ');

     }





     public function post_edit_video_course2(Request $request){

       $image = $request->file('image');
       $file = $request->file('file');

       $this->validate($request, [
            'course_id' => 'required',
            'name_video' => 'required'
        ]);
        $id = $request['video_id'];
        if($image == null && $file == null){

          $obj = example_video::find($id);
          $obj->time_video = $request['time_video'];
          $obj->course_video_name = $request['name_video'];
          $obj->course_video_detail = $request['course_video_detail'];
          $obj->save();

        }elseif($image != null && $file == null){

          $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

           $img = Image::make($image->getRealPath());
           $img->resize(640, 360, function ($constraint) {
           $constraint->aspectRatio();
       })->save('web_stream/thumbnail_video/'.$input['imagename']);

       $obj = example_video::find($id);
       $obj->course_video_name = $request['name_video'];
       $obj->time_video = $request['time_video'];
       $obj->course_video_detail = $request['course_video_detail'];
       $obj->thumbnail_img = $input['imagename'];
       $obj->save();

        }elseif($image == null && $file != null){

          $destinationPath = 'web_stream/example_video/';
          $input['file'] = time().'.'.$file->getClientOriginalExtension();
          $request->file('file')->move($destinationPath, $input['file']);

          $obj = example_video::find($id);
          $obj->course_video_name = $request['name_video'];
          $obj->time_video = $request['time_video'];
          $obj->course_video_detail = $request['course_video_detail'];
          $obj->course_video = $input['file'];
          $obj->course_video_url = "https://learnsbuy.com/web_stream/example_video/".$input['file'];
          $obj->save();
          //https://learnsbuy.com/assets/web_stream/example_video/
        }else{

          $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

           $img = Image::make($image->getRealPath());
           $img->resize(640, 360, function ($constraint) {
           $constraint->aspectRatio();
       })->save('web_stream/thumbnail_video/'.$input['imagename']);


          $destinationPath = 'web_stream/example_video/';
          $input['file'] = time().'.'.$file->getClientOriginalExtension();
          $request->file('file')->move($destinationPath, $input['file']);

          $obj = example_video::find($id);
          $obj->course_video_name = $request['name_video'];
          $obj->time_video = $request['time_video'];
          $obj->course_video_detail = $request['course_video_detail'];
          $obj->course_video = $input['file'];
          $obj->course_video_url = "https://learnsbuy.com/web_stream/example_video/".$input['file'];
          $obj->thumbnail_img = $input['imagename'];
          $obj->save();




        }



       return redirect(url('admin/course/'.$request['course_id'].'/edit#video_set'))->with('success_edit_video','แก้ไขข้อมูล Video สำเร็จ');

     }



     public function get_file_course($id){
       $obj = filecourse::find($id);
       $file = public_path().'/assets/file_courses/'.$obj->file_of_course;
        return Response::download($file);
     }


     public function del_file_course(Request $request, $id){

       $objs = DB::table('filecourses')
       ->where('id', $id)
       ->first();

       $destinationPath = 'assets/file_courses/'.$objs->file_of_course;
       File::delete($destinationPath);

       $obj = DB::table('filecourses')
       ->where('id', $id)
       ->delete();

       return redirect(url('admin/course/'.$request['course_id'].'/edit'))->with('success_file_del','ลบไฟล์เอกสาร สำเร็จแล้ว');

     }

     public function add_file_course(Request $request)
     {
       $file = $request->file('file');
       $this->validate($request, [
            'file_of_name' => 'required',
            'file' => 'required'
        ]);

        $destinationPath = 'assets/file_courses';
        $input['file'] = time().'.'.$file->getClientOriginalExtension();
        $request->file('file')->move($destinationPath, $input['file']);

        $obj = new filecourse();
        $obj->course_id = $request['course_id'];
        $obj->file_of_name = $request['file_of_name'];
        $obj->file_of_course = $input['file'];
        $obj->save();


        return redirect(url('admin/course/'.$request['course_id'].'/edit'))->with('add_file_of_course','เพิ่มเอกสารการเรียนสำเร็จ');



     }

     public function add_video_course_example(Request $request){


       $image = $request->file('image1');


       $file = $request->file('file1');

       $this->validate($request, [
            'image1' => 'required',
            'file1' => 'required',
            'course_id1' => 'required',
            'name_video1' => 'required'
        ]);


        $destinationPath = 'web_stream/example_video/';
        $input['file1'] = time().'.'.$file->getClientOriginalExtension();
        $request->file('file1')->move($destinationPath, $input['file1']);
        ///

        ////
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
      //  dd($input['imagename']);

         $img = Image::make($image->getRealPath());
         $img->resize(640, 360, function ($constraint) {
         $constraint->aspectRatio();
     })->save('web_stream/thumbnail_video/'.$input['imagename']);


        $obj = new example_video();
        $obj->course_id = $request['course_id1'];
        $obj->time_video = $request['time_video1'];
        $obj->course_video_name = $request['name_video1'];
        $obj->course_video_detail = $request['course_video_detail1'];
        $obj->course_video = $input['file1'];
        $obj->course_video_url = "https://learnsbuy.com/web_stream/example_video/".$input['file1'];
        $obj->thumbnail_img = $input['imagename'];
        $obj->save();





        return redirect(url('admin/course/'.$request['course_id1'].'/edit'))->with('success_course_video','เพิ่มข้อมูล Video สำเร็จ');

     }

     public function add_video_course(Request $request)
     {
       $image = $request->file('image');

       //dd($image);
       $file = $request->file('file');

       $this->validate($request, [
            'image' => 'required',
            'file' => 'required',
            'course_id' => 'required',
            'name_video' => 'required'
        ]);


        $destinationPath = 'assets/videos';
        $input['file'] = time().'.'.$file->getClientOriginalExtension();
        $request->file('file')->move($destinationPath, $input['file']);
        ///

        ////
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

         $img = Image::make($image->getRealPath());
         $img->resize(640, 360, function ($constraint) {
         $constraint->aspectRatio();
     })->save('assets/uploads/'.$input['imagename']);


        $obj = new video_list();
        $obj->course_id = $request['course_id'];
        $obj->time_video = $request['time_video'];
        $obj->course_video_name = $request['name_video'];
        $obj->course_video_detail = $request['course_video_detail'];
        $obj->course_video = $input['file'];
        $obj->course_video_url = "https://learnsbuy.com/assets/videos/".$input['file'];
        $obj->thumbnail_img = $input['imagename'];
        $obj->save();





        return redirect(url('admin/course/'.$request['course_id'].'/edit'))->with('success_course_video','เพิ่มข้อมูล Video สำเร็จ');


     }


    public function store(Request $request)
    {
      $image = $request->file('image');
      $file = $request->file('file');
      $this->validate($request, [
           'image' => 'required|mimes:jpg,jpeg,png,gif|max:10048',
           'name' => 'required',
           'typecourses' => 'required',
           'price' => 'required',
           'detail' => 'required',
           'discount' => 'required',
           'code_course' => 'required',
           'del_video' => 'required',
           'name_department' => 'required'
       ]);


       $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = asset('assets/uploads/');
        $img = Image::make($image->getRealPath());
        $img->resize(500, 500, function ($constraint) {
        $constraint->aspectRatio();
      })->save('assets/uploads/'.$input['imagename']);

      $obj = new course();
      $obj->user_id = Auth::user()->id;
      $obj->type_course = $request['typecourses'];
      $obj->title_course = $request['name'];
      $obj->detail_course = $request['detail'];
      $obj->price_course = $request['price'];
      $obj->time_course_text = $request['time_course_text'];
      $obj->time_course = $request['time_course'];
      $obj->day_course = $request['day_course'];
      $obj->image_course = $input['imagename'];
      $obj->discount = $request['discount'];
      $obj->code_course = $request['code_course'];
      $obj->department_id = $request['name_department'];
      $obj->del_video = $request['del_video'];
      $obj->video_back = $request['video_back'];
      $obj->file_study = $request['file_study'];
      $obj->set_type_c = $request['set_type_c'];
      $obj->tags = $request['tags'];
      $obj->te_study = $request['te_study'];
      $obj->save();

      return redirect(url('admin/course/'))->with('success_course','เพิ่มข้อมูล '.$request['name'].' สำเร็จ');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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


        //example
        $objs = DB::table('examples')
            ->select(
            'examples.*',
            'examples.id as e_id',
            'courses.*',
            'courses.id as c_id',
            'categories.*'
            )
            ->leftjoin('courses', 'examples.course_id', '=', 'courses.id')
            ->leftjoin('categories', 'examples.category_id', '=', 'categories.id')
            ->where('courses.id', $id)
            ->get();


            foreach ($objs as $obj) {

                $options = DB::table('questions')->where('category_id',$obj->e_id)->count();
                $obj->options = $options;
            }

            //dd($objs);
            $data['objs'] = $objs;
            $data['datahead'] = "แบบฝึกหัดทั้งหมด";
            return view('admin.course.example', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function examination($id)
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

      $get_q = DB::table('questions')
          ->select(
          'questions.*'
          )
          ->where('questions.category_id', $id)
          ->orderBy('order_sort', 'asc')
          ->get();
      //dd($get_q);
      $data['get_q'] = $get_q;

        $objs = DB::table('courses')
            ->select(
            'courses.*',
            'questions.*',
            'questions.name_questions'
            )
            ->Join('questions', 'courses.id', '=', 'questions.category_id')
            ->where('courses.id', $id)->orderBy('order_sort', 'asc')->get();
            //->Join('options', 'questions.id_questions', '=', 'options.question_id')
            //->where('categorys.id_category', $id)
            //->get();

        $objss = DB::table('courses')
            ->select(
            'courses.*'
            )
            ->where('courses.id', $id)
            ->first();

        foreach ($objs as $obj) {
            $optionsRes = [];
            $options = DB::table('options')->where('question_id',$obj->id_questions)->get();
            foreach ($options as $option) {
                $optionsRes[] = $option;
            }
            $obj->options = $optionsRes;

        }

       // dd($objs);

        $data['url'] = url('admin/examination/'.$id);
        $data['method'] = "put";
        $data['objs'] = $objs;
        $data['objss'] = $objss;
        $data['header'] = "จัดการแบบสอบถาม";
        return view('admin.course.examination', $data);
    }





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

     $video_list = DB::table('video_lists')
      ->select(
      DB::raw('video_lists.*')
      )
      ->where('course_id', $id)
      ->orderBy('order_sort', 'asc')
      ->get();


      $video_list_ex = DB::table('example_videos')
       ->where('course_id', $id)
       ->get();
       $data['video_list_ex'] = $video_list_ex;

      $file_course = DB::table('filecourses')
       ->where('course_id', $id)
       ->get();
       $data['file_course'] = $file_course;


      $course = typecourses::all();
      $department = department::all();
      $courseinfo = course::find($id);
      $data['department'] = $department;
      $data['video_list'] = $video_list;
      $data['course'] = $course;
      $data['courseinfo'] = $courseinfo;
      $data['method'] = "put";
      $data['url'] = url('admin/course/'.$id);
      $data['header'] = "แก้ไขคอร์ส";
      return view('admin.course.edit', $data);
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
        $image = $request->file('image');


        $sort_corse = $request['sort_corse'];
        if($sort_corse == null){
          $sort_corse = 0;
        }

        if($image != NULL){

          $this->validate($request, [
               'image' => 'required|mimes:jpg,jpeg,png,gif|max:10048',
               'name' => 'required',
               'typecourses' => 'required',
               'price' => 'required',
               'detail' => 'required',
               'discount' => 'required',
               'code_course' => 'required',
               'del_video' => 'required',
               'live_stream_status' => 'required',
               'name_department' => 'required'
           ]);



           $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

            $destinationPath = asset('assets/uploads/');
            $img = Image::make($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
            $constraint->aspectRatio();
          })->save('assets/uploads/'.$input['imagename']);


           $obj = course::find($id);
           $obj->type_course = $request['typecourses'];
           $obj->title_course = $request['name'];
           $obj->detail_course = $request['detail'];
           $obj->price_course = $request['price'];
           $obj->time_course_text = $request['time_course_text'];
           $obj->time_course = $request['time_course'];
           $obj->day_course = $request['day_course'];
           $obj->image_course = $input['imagename'];
           $obj->discount = $request['discount'];
           $obj->code_course = $request['code_course'];
           $obj->department_id = $request['name_department'];
           $obj->sort_corse = $sort_corse;
           $obj->del_video = $request['del_video'];
           $obj->url_youtube = $request['url_youtube'];
           $obj->live_stream_status = $request['live_stream_status'];
           $obj->video_back = $request['video_back'];
           $obj->file_study = $request['file_study'];
           $obj->set_type_c = $request['set_type_c'];
           $obj->tags = $request['tags'];
           $obj->te_study = $request['te_study'];
           $obj->show_students = $request['show_students'];
           $obj->save();

           return redirect(url('admin/course/'))->with('success_course','แก้ไขข้อมูล '.$request['name'].' สำเร็จ');


        }else{


          $this->validate($request, [
               'name' => 'required',
               'typecourses' => 'required',
               'price' => 'required',
               'detail' => 'required',
               'del_video' => 'required',
               'name_department' => 'required',
           ]);

           $obj = course::find($id);
           $obj->type_course = $request['typecourses'];
           $obj->title_course = $request['name'];
           $obj->detail_course = $request['detail'];
           $obj->price_course = $request['price'];
           $obj->time_course_text = $request['time_course_text'];
           $obj->time_course = $request['time_course'];
           $obj->day_course = $request['day_course'];
           $obj->discount = $request['discount'];
           $obj->code_course = $request['code_course'];
           $obj->department_id = $request['name_department'];
           $obj->sort_corse = $sort_corse;
           $obj->del_video = $request['del_video'];
           $obj->url_youtube = $request['url_youtube'];
           $obj->live_stream_status = $request['live_stream_status'];
           $obj->video_back = $request['video_back'];
           $obj->file_study = $request['file_study'];
           $obj->set_type_c = $request['set_type_c'];
           $obj->tags = $request['tags'];
           $obj->te_study = $request['te_study'];
           $obj->show_students = $request['show_students'];
           $obj->save();

           return redirect(url('admin/course/'))->with('success_course','แก้ไขข้อมูล '.$request['name'].' สำเร็จ');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $objs = DB::table('courses')
      ->where('courses.id', $id)
      ->first();

      $destinationPath = 'assets/uploads/'.$objs->image_course;
      File::delete($destinationPath);

      $url_course = 'assets/excel/'.$objs->url_course;
      File::delete($url_course);

      $obj = DB::table('courses')
      ->where('courses.id', $id)
      ->delete();

      return redirect(url('admin/course/'))->with('delete','ลบข้อมูล สำเร็จ');
    }
}
