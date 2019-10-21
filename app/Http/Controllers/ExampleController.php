<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\example;
use App\category;
use App\Http\Requests;
use App\course;
use Illuminate\Support\Facades\DB;

class ExampleController extends Controller
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
          ->get();


          foreach ($objs as $obj) {

              $options = DB::table('questions')->where('category_id',$obj->e_id)->count();
              $obj->options = $options;
          }

          //dd($objs);
          $data['objs'] = $objs;
          $data['datahead'] = "แบบฝึกหัดทั้งหมด";
          return view('admin.example.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

      $category = category::all();
      $course = course::all();

      $data['category'] = $category;
      $data['course'] = $course;
      $data['method'] = "post";
      $data['url'] = url('admin/example');
      $data['header'] = "เพิ่มแบบฝึกหัด";
      return view('admin.example.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
           'example_name' => 'required',
           'categorys' => 'required',
           'course' => 'required',
           'example_detail' => 'required'
       ]);

       $obj = new example();
       $obj->examples_name = $request['example_name'];
       $obj->category_id = $request['categorys'];
       $obj->course_id = $request['course'];
       $obj->examples_detail = $request['example_detail'];
       $obj->save();

       $the_id = $obj->id;

      // dd($the_id);
      return redirect(url('admin/example/'.$the_id));

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


      $get_q = DB::table('questions')
          ->select(
          'questions.*'
          )
          ->where('questions.category_id', $id)
          ->orderBy('order_sort', 'asc')
          ->get();
      //dd($get_q);
      $data['get_q'] = $get_q;

        $objs = DB::table('examples')
            ->select(
            'examples.*',
            'questions.*',
            'questions.name_questions'
            )
            ->Join('questions', 'examples.id', '=', 'questions.category_id')
            ->where('examples.id', $id)->orderBy('order_sort', 'asc')->get();
            //->Join('options', 'questions.id_questions', '=', 'options.question_id')
            //->where('categorys.id_category', $id)
            //->get();

        $objss = DB::table('examples')
            ->select(
            'examples.*',
            'courses.*',
            'examples.id as e_id',
            'courses.id as c_id',
            'courses.id as ca_id',
            'categories.*'
            )
            ->leftjoin('courses', 'courses.id', '=', 'examples.course_id')
            ->leftjoin('categories', 'examples.category_id', '=', 'categories.id')
            ->where('examples.id', $id)
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
        $data['header'] = "จัดการแบบฝึกหัด";
        return view('admin.course.examination', $data);
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


      $category = category::all();
      $course = course::all();
      $data['category'] = $category;
      $data['course'] = $course;

      $courseinfo = example::find($id);

      $data['courseinfo'] = $courseinfo;
      $data['method'] = "put";
      $data['url'] = url('admin/example/'.$id);
      $data['header'] = "แก้ไขหัวข้อแบบฝึกหัด";
      return view('admin.example.edit', $data);
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
           'example_name' => 'required',
           'categorys' => 'required',
           'course' => 'required',
           'example_detail' => 'required'
       ]);

       $obj = example::find($id);
       $obj->examples_name = $request['example_name'];
       $obj->category_id = $request['categorys'];
       $obj->course_id = $request['course'];
       $obj->examples_detail = $request['example_detail'];
       $obj->save();


      // dd($the_id);
      return redirect(url('admin/example/'.$id.'/edit'))->with('success_course','แก้ไขข้อมูล '.$request['example_name'].' สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {





      $objs = DB::table('examples')
          ->select(
          'examples.*',
          'questions.*'
          )
          ->leftjoin('questions', 'examples.id', '=', 'questions.category_id')
          ->where('examples.id', $id)
          ->first();


      $objo = DB::table('options')
      ->where('options.question_id', $objs->id_questions)
      ->delete();

      $obj = DB::table('questions')
      ->where('questions.category_id', $id)
      ->delete();

      $obj = DB::table('examples')
      ->where('examples.id', $id)
      ->delete();

      return back()->with('delete_q','ลบข้อมูล สำเร็จ');
    }
}
