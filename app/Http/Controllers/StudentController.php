<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Users;
use App\Http\Requests;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;


class StudentController extends Controller
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
        //
        $objs = DB::table('users')
            ->select(
            'users.*'
            )
            ->where('is_admin', 0)
            ->paginate(15);



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

        $data['objs'] = $objs;
        $data['datahead'] = "รายชื่อนักเรียนทั้งหมด";
        return view('admin.student.index', $data);
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

        //
        $data['method'] = "post";
        $data['url'] = url('admin/student');
        $data['header'] = "เพิ่มครูผู้สอน";
        return view('admin.student.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function search_student(Request $request){


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


      $this->validate($request, [
       'q' => 'required',
     ]);

      $search_text = $request['q'];




      $objs = DB::table('users')
          ->select(
          'users.*'
          )
          ->Where('name','LIKE','%'.$search_text.'%')
          ->orWhere('email','LIKE','%'.$search_text.'%')
          ->paginate(15);

      //    dd($objs);

          $data['search_text'] = $search_text;
          $data['objs'] = $objs;
          $data['datahead'] = 'รายชื่อนักเรียน';
          return view('admin.student.search', $data);

    }
    public function store(Request $request)
    {

      $image = $request->file('image');


     if($image == NULL){

      $this->validate($request, [
       'name' => 'required|unique:users|max:255',
       'email' => 'required|email|max:255|unique:users',
       'password' => 'required|min:6|confirmed',
       'position' => 'required',
       'hbd' => 'required',
       'phone' => 'required',
     ]);
        //
        $package = new Users();
        $package->name = $request['name'];
        $package->email = $request['email'];
        $package->position = $request['position'];
        $package->address = $request['address'];
        $package->phone = $request['phone'];
        $package->bio = $request['bio'];
        $package->hbd = $request['hbd'];
        $package->line_id = $request['line_id'];
        $package->provider = 'email';
        $package->password = bcrypt($request['password']);
        $package->save();
        return redirect(url('admin/student'))->with('success','เพิ่มบัญชีผู้ใช้งาน '.$request['name'].' เสร็จเรียบร้อยแล้ว');


  }else{


    $this->validate($request, [
     'image' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
     'name' => 'required|unique:users|max:255',
     'email' => 'required|email|max:255|unique:users',
     'password' => 'required|min:6|confirmed',
     'position' => 'required',
     'hbd' => 'required',
     'phone' => 'required',

   ]);


   $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

    $destinationPath = asset('assets/images/avatar');
    $img = Image::make($image->getRealPath());
    $img->resize(300, 300, function ($constraint) {
    $constraint->aspectRatio();
  })->save('assets/images/avatar/'.$input['imagename']);

    $package = new Users();
   $package->avatar = $input['imagename'];
   $package->name = $request['name'];
   $package->email = $request['email'];
   $package->position = $request['position'];
   $package->address = $request['address'];
   $package->phone = $request['phone'];
   $package->bio = $request['bio'];
   $package->hbd = $request['hbd'];
   $package->line_id = $request['line_id'];
   $package->provider = 'email';
   $package->password = bcrypt($request['password']);
   $package->save();

   return redirect(url('admin/student'))->with('success','เพิ่มบัญชีผู้ใช้งาน '.$request['name'].' เสร็จเรียบร้อยแล้ว');

  }
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

        //
        $obj = DB::table('users')
          ->select(
             'users.*'
             )
          ->where('users.id', $id)
          ->first();

        $score = 0;

      if($obj->name != NULL){
        $score += 20;
      }
      if($obj->address != NULL){
        $score += 20;
      }
      if($obj->position != NULL){
        $score += 20;
      }
      if($obj->phone != NULL){
        $score += 20;
      }
      if($obj->line_id != NULL){
        $score += 20;
      }


      $coursess = DB::table('submitcourses')
        ->select(
           'submitcourses.*',
           'submitcourses.user_id as Uid',
           'submitcourses.id as Oid',
           'submitcourses.created_at as created_at_user',
           'users.*',
           'courses.*'
           )
        ->where('submitcourses.user_id', $id)
        ->where('submitcourses.status', 2)
        ->leftjoin('users', 'users.id', '=', 'submitcourses.user_id')
        ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
        ->paginate(10);


      $coursess_suc = DB::table('history_pays')
        ->select(
           'history_pays.*'
           )
        ->where('user_id', $id)
        ->paginate(10);

        $data['header'] = "ข้อมูลนักเรียน";
        $data['coursess_suc'] = $coursess_suc;
        $data['coursess'] = $coursess;
        $data['score'] = $score;
        $data['objs'] = $obj;
        return view('admin.student.show', $data);
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

        //
        $obj = DB::table('users')
          ->select(
             'users.*'
             )
          ->where('users.id', $id)
          ->first();

        $score = 0;

      if($obj->name != NULL){
        $score += 20;
      }
      if($obj->address != NULL){
        $score += 20;
      }
      if($obj->position != NULL){
        $score += 20;
      }
      if($obj->phone != NULL){
        $score += 20;
      }
      if($obj->line_id != NULL){
        $score += 20;
      }

        $data['url'] = url('admin/student/'.$id);
        $data['header'] = "แก้ไขข้อมูลนักเรียน";
        $data['method'] = "put";
        $data['score'] = $score;
        $data['objs'] = $obj;
        return view('admin.student.edit', $data);
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


     if($image == NULL){

       $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'hbd' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'user_coin' => 'required',
            'line_id' => 'required',
        ]);

        $package = users::find($id);
        $package->name = $request['name'];
        $package->email = $request['email'];
        $package->bio = $request['bio'];
        $package->address = $request['address'];
        $package->phone = $request['phone'];
        $package->hbd = $request['hbd'];
        $package->line_id = $request['line_id'];
        $package->user_coin = $request['user_coin'];
        $package->save();

      return redirect(url('admin/student/'.$id.'/edit'))->with('success','Edit '.$request['name'].' successful');

      }else{

        $this->validate($request, [
             'image' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
             'name' => 'required',
             'email' => 'required',
             'hbd' => 'required',
             'address' => 'required',
             'phone' => 'required',
             'user_coin' => 'required',
             'line_id' => 'required',
         ]);

         $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

          $destinationPath = asset('assets/images/avatar');
          $img = Image::make($image->getRealPath());
          $img->resize(300, 300, function ($constraint) {
          $constraint->aspectRatio();
        })->save('assets/images/avatar/'.$input['imagename']);

         $package = users::find($id);
         $package->avatar = $input['imagename'];
         $package->name = $request['name'];
         $package->email = $request['email'];
         $package->bio = $request['bio'];
         $package->address = $request['address'];
         $package->phone = $request['phone'];
         $package->hbd = $request['hbd'];
         $package->line_id = $request['line_id'];
         $package->user_coin = $request['user_coin'];
         $package->save();
         return redirect(url('admin/student/'.$id.'/edit'))->with('success','Edit '.$request['name'].' successful');
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
        //

        $obj = Users::find($id);
        $obj->delete();
        return redirect(url('admin/student'))->with('delete','Delete successful');
    }
}
