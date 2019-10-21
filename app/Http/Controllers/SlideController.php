<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\slide_show;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;


class SlideController extends Controller
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
        //
        $cat = DB::table('slide_shows')->select(
              'slide_shows.*'
              )
              ->get();

          $data['objs'] = $cat;
          $data['datahead'] = "Slide Show";
          return view('admin.slide.index', $data);
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
        $data['url'] = url('admin/slide');
        $data['datahead'] = "สร้าง รูป slide ";
        return view('admin.slide.create', $data);
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
        $image = $request->file('image');
        $this->validate($request, [
         'text_1' => 'required',
         'image' => 'required|max:8048'
        ]);

        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

          $destinationPath = asset('assets/image/slide/');
          $img = Image::make($image->getRealPath());
          $img->resize(1800, 733, function ($constraint) {
          $constraint->aspectRatio();
        })->save('assets/image/slide/'.$input['imagename']);


        $package = new slide_show();
        $package->text_slide1 = $request['text_1'];
        $package->text_slide2 = $request['text_2'];
        $package->text_slide3 = $request['text_3'];
        $package->btn_slide = $request['text_btn'];
        $package->btn_url = $request['url_btn'];
        $package->image_slide = $input['imagename'];
        $package->save();
        return redirect(url('admin/slide'))->with('add_success','เพิ่ม เสร็จเรียบร้อยแล้ว');
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
        //
        $obj = slide_show::find($id);
        $data['url'] = url('admin/slide/'.$id);
        $data['datahead'] = "แก้ไข slide show";
        $data['method'] = "put";
        $data['objs'] = $obj;
        return view('admin.slide.edit', $data);
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

        $image = $request->file('image');
        $this->validate($request, [
         'text_1' => 'required'
        ]);

        if($image == null){

          $package = slide_show::find($id);
          $package->text_slide1 = $request['text_1'];
          $package->text_slide2 = $request['text_2'];
          $package->text_slide3 = $request['text_3'];
          $package->btn_slide = $request['text_btn'];
          $package->btn_url = $request['url_btn'];
          $package->save();
        }
        else{

          $objs = DB::table('slide_shows')
          ->select(
             'slide_shows.*'
             )
          ->where('id', $id)
          ->first();

          $file_path = 'assets/image/slide/'.$objs->image_slide;
          unlink($file_path);


          $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

            $destinationPath = asset('assets/image/slide/');
            $img = Image::make($image->getRealPath());
            $img->resize(1800, 733, function ($constraint) {
            $constraint->aspectRatio();
          })->save('assets/image/slide/'.$input['imagename']);

          $package = slide_show::find($id);
          $package->text_slide1 = $request['text_1'];
          $package->text_slide2 = $request['text_2'];
          $package->text_slide3 = $request['text_3'];
          $package->btn_slide = $request['text_btn'];
          $package->btn_url = $request['url_btn'];
          $package->image_slide = $input['imagename'];
          $package->save();

        }


        return redirect(url('admin/slide/'.$id.'/edit'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');
    }

    public function api_slide_status(Request $request){

    $user = slide_show::findOrFail($request->user_id);

              if($user->slide_status == 1){
                  $user->slide_status = 0;
              } else {
                  $user->slide_status = 1;
              }


      return response()->json([
      'data' => [
        'success' => $user->save(),
      ]
    ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $objs = DB::table('slide_shows')
      ->select(
         'slide_shows.*'
         )
      ->where('id', $id)
      ->first();

      $file_path = 'assets/image/slide/'.$objs->image_slide;
      unlink($file_path);
        //
        $obj = slide_show::find($id);
        $obj->delete();
        return redirect(url('admin/slide/'))->with('delete','คุณทำการลบอสังหา สำเร็จ');
    }
}
