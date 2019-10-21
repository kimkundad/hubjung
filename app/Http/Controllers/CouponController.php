<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\coupon_user;
use App\coupon;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
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
        $cat = DB::table('coupons')->select(
              'coupons.*'
              )
              ->get();


              foreach ($cat as $k) {
                //  $optionsRes = [];

                    $obj_pro_count = DB::table('coupon_users')
                        ->where('coupon_status', 1)
                        ->where('c_id', $k->id)
                        ->count();

                  $k->options = $obj_pro_count;

                  $obj_pro_count_1 = DB::table('coupon_users')
                      ->where('coupon_status', 0)
                      ->where('c_id', $k->id)
                      ->count();

                $k->options_set = $obj_pro_count_1;
                //  $obj->options = 0;
                }
          //
        //  dd($cat);
          $s = 1;
          $data['s'] = $s;
          $data['objs'] = $cat;
          $data['datahead'] = "Coupon";
          return view('admin.coupon.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


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

        $objs = DB::table('courses')->get();
        $data['courses'] = $objs;
        $data['method'] = "post";
        $data['url'] = url('admin/coupon');
        $data['datahead'] = "สร้าง Coupon";
        return view('admin.coupon.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //c_type
        $this->validate($request, [
         'c_code' => 'required',
         'c_max' => 'required',
         'c_price' => 'required',
         'c_type' => 'required',
         'c_price_product' => 'required'
        ]);

        $package = new coupon();
        $package->c_code = $request['c_code'];
        $package->c_max = $request['c_max'];
        $package->c_price = $request['c_price'];
        $package->c_price_product = $request['c_price_product'];
        $package->c_type = $request['c_type'];
        $package->save();
        return redirect(url('admin/coupon'))->with('add_success','เพิ่ม เสร็จเรียบร้อยแล้ว');
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
        //

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

       $objss = DB::table('courses')->get();
       $data['courses'] = $objss;
        $obj = coupon::find($id);


        $get_course = DB::table('coupon_users')
         ->where('c_id', $id)
         ->get();

         foreach($get_course as $u){


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
             ->where('submitcourses.id', '=', $u->order_id)
             ->first();

             $u->get_order = $coursess;
         }


        $data['coursess'] = $get_course;

        //dd($get_course);

        $data['url'] = url('admin/coupon/'.$id);
        $data['datahead'] = "แก้ไข coupon";
        $data['method'] = "put";
        $data['objs'] = $obj;
        return view('admin.coupon.edit', $data);
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
        $this->validate($request, [
         'c_code' => 'required',
         'c_max' => 'required',
         'c_price' => 'required',
         'c_price_product' => 'required'
        ]);

        $package = coupon::find($id);
        $package->c_code = $request['c_code'];
        $package->c_max = $request['c_max'];
        $package->c_price = $request['c_price'];
        $package->c_price_product = $request['c_price_product'];
        $package->c_type = $request['c_type'];
        $package->save();

        return redirect(url('admin/coupon/'.$id.'/edit'))->with('edit_success','คุณทำการเพิ่มอสังหา สำเร็จ');
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
        $obj = coupon::find($id);
        $obj->delete();
        return redirect(url('admin/coupon/'))->with('delete','คุณทำการลบอสังหา สำเร็จ');
    }
}
