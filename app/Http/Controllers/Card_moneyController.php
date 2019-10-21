<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cardmoney;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use File;

class Card_moneyController extends Controller
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

      $objs = cardmoney::all();
      $data['objs'] = $objs;
      $data['datahead'] = "บัตรเติมเงิน";
      return view('admin.card_money.index', $data);
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

      $data['method'] = "post";
      $data['url'] = url('admin/card_money');
      $data['header'] = "เพิ่ม บัตรเติมเงิน";
      return view('admin.card_money.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $image = $request->file('image');

      $this->validate($request, [
           'image' => 'required|mimes:jpg,jpeg,png,gif|max:10048',
           'coin' => 'required',
           'name' => 'required',
           'price' => 'required'
       ]);

        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

       $img = Image::make($image->getRealPath());
       $img->resize(300, 186, function ($constraint) {
       $constraint->aspectRatio();
     })->save('assets/uploads/'.$input['imagename']);

     $obj = new cardmoney();
     $obj->name_card = $request['name'];
     $obj->money_card_sum = $request['price'];
     $obj->image_card = $input['imagename'];
     $obj->card_point = $request['coin'];
     $obj->save();

     return redirect(url('admin/card_money/'))->with('success_course','เพิ่มข้อมูล '.$request['name'].' สำเร็จ');

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

      $obj = cardmoney::find($id);
      $data['url'] = url('admin/card_money/'.$id);
      $data['header'] = "แก้ไข บัตรเติมเงิน";
      $data['method'] = "put";
      $data['courseinfo'] = $obj;
      return view('admin.card_money.edit', $data);
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



       if($image != NULL){

         $this->validate($request, [
              'image' => 'required|mimes:jpg,jpeg,png,gif|max:10048',
              'coin' => 'required',
              'name' => 'required',
              'price' => 'required'
          ]);

         $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

        $img = Image::make($image->getRealPath());
        $img->resize(300, 186, function ($constraint) {
        $constraint->aspectRatio();
      })->save('assets/uploads/'.$input['imagename']);


        $obj = cardmoney::find($id);
        $obj->name_card = $request['name'];
        $obj->money_card_sum = $request['price'];
        $obj->image_card = $input['imagename'];
        $obj->card_point = $request['coin'];
        $obj->save();

       }else{

         $this->validate($request, [
              'coin' => 'required',
              'name' => 'required',
              'price' => 'required'
          ]);


        $obj = cardmoney::find($id);
        $obj->name_card = $request['name'];
        $obj->money_card_sum = $request['price'];
        $obj->card_point = $request['coin'];
        $obj->save();

       }



       return redirect(url('admin/card_money/'.$id.'/edit'))->with('success_course','แก้ไขข้อมูล '.$request['name'].' สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $objs = DB::table('cardmoneys')
      ->where('cardmoneys.id', $id)
      ->first();

      $destinationPath = 'assets/uploads/'.$objs->image_card;
      File::delete($destinationPath);



      $obj = DB::table('cardmoneys')
      ->where('cardmoneys.id', $id)
      ->delete();

      return redirect(url('admin/card_money/'))->with('delete','ลบข้อมูล สำเร็จ');
    }
}
