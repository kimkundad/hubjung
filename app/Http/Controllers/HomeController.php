<?php

namespace App\Http\Controllers;


use App\course;
use App\coupon_user;
use App\Http\Requests;
use Session;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }




    public function post_coupon(Request $request){



      $get_coupon_count = DB::table('coupons')
          ->select(
          'coupons.*'
          )
          ->where('c_code', $request->coupon)
          ->count();



          $get_coupon = DB::table('coupons')
              ->select(
              'coupons.*'
              )
              ->where('c_code', $request->coupon)
              ->first();


              $get_cource = DB::table('courses')
                  ->select(
                  'courses.price_course',
                  'courses.id'
                  )
                  ->where('id', $get_coupon->c_price_product)
                  ->first();

            //  max_price = course

          if($get_coupon_count > 0){


            $check_limit = DB::table('coupon_users')
                ->select(
                'coupon_users.*'
                )
                ->where('c_id', $get_coupon->id)
                ->where('coupon_status', 1)
                ->count();


                if($check_limit >= $get_coupon->c_max){

                  $response = array(
                      'status' => 'error',
                      'msg' => 'คุณไม่สามารถใช้ Coupon นี้ได้ Coupon ได้ถูกใช้ไปหมดแล้ว',
                  );

                }else{




                  if($request->max_price == $get_coupon->c_price_product){

                    $get_coupons = DB::table('coupons')
                        ->select(
                        'coupons.*'
                        )
                        ->where('c_code', $request->coupon)
                        ->first();

                        if($get_coupon->c_type == 1){

                          $send_price = (($get_cource->price_course*$get_coupon->c_price)/100);

                        }else{

                          $send_price = $get_coupon->c_price;
                        }

                        Session::put('coupon', ['code' => $get_coupon->c_code, 'id' => $get_coupon->id, 'price' => $send_price, 'course' => $get_coupon->c_price_product, 'type' => 0]);


                        $obj = new coupon_user();
                        $obj->user_id = Auth::user()->id;
                        $obj->c_id = $get_coupon->id;
                        $obj->order_id = $request->order_id;
                        $obj->save();

                    $response = array(
                        'status' => 'success',
                        'msg' => 'คุณสามารถใช้ Coupon นี้ได้',
                        'coupon' => $send_price,
                    );

                  }else{


                    if($get_coupon->c_price_product == 0){

                      $get_cource = DB::table('courses')
                          ->select(
                          'courses.price_course',
                          'courses.id'
                          )
                          ->where('id', $request->max_price)
                          ->first();



                      $get_coupons = DB::table('coupons')
                          ->select(
                          'coupons.*'
                          )
                          ->where('c_code', $request->coupon)
                          ->first();

                        //  $sum_price_type = 0;

                          if($get_coupon->c_type == 1){

                            $send_price = (($get_cource->price_course*$get_coupon->c_price)/100);

                          }else{

                            $send_price = $get_coupon->c_price;
                          }



                        //  $sum_price_type = (($get_cource->price_course*$get_coupon->c_price)/100);

                          Session::put('coupon', ['code' => $get_coupon->c_code, 'id' => $get_coupon->id, 'price' => $send_price, 'course' => $get_coupon->c_price_product, 'type' => 1]);
                          $obj = new coupon_user();
                          $obj->user_id = Auth::user()->id;
                          $obj->c_id = $get_coupon->id;
                          $obj->order_id = $request->order_id;
                          $obj->save();

                      $response = array(
                          'status' => 'success',
                          'msg' => 'คุณสามารถใช้ Coupon นี้ได้',
                          'coupon' => $send_price,
                      );



                    }else{

                      $response = array(
                          'status' => 'error',
                          'msg' => 'คุณไม่สามารถใช้ Coupon นี้ได้ Coupon กับ Course ไม่ตรงกับที่ระบุไว้',
                          'coupon' => 'คุณไม่สามารถใช้ Coupon นี้ได้ Coupon กับ Course ไม่ตรงกับที่ระบุไว้',
                      );

                    }



                  }





                }





          }else{

            $response = array(
                'status' => 'error',
                'msg' => 'คุณไม่สามารถใช้ Coupon นี้ได้',
            );

          }


    //  dd($get_coupon_count);



      return response()->json($response);
    }




    public function home_test(){

      $slide = DB::table('slide_shows')->select(
            'slide_shows.*'
            )
            ->where('slide_status', 1)
            ->get();
      $data['slide'] = $slide;

      $objs = DB::table('courses')
          ->select(
          'courses.*',
          'courses.id as A',
          'typecourses.*'
          )
          ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
          ->where('courses.ch_status', 1)
          ->orderBy('sort_corse', 'asc')
          ->limit(16)
          ->get();

      $data['objs'] = $objs;
      return view('test_home', $data);

    }





    public function home()
    {
      session()->forget('coupon');

      $get_cat = DB::table('departments')
            ->get();


      $slide = DB::table('slide_shows')->select(
            'slide_shows.*'
            )
            ->where('slide_status', 1)
            ->get();
      $data['slide'] = $slide;

      $objs = DB::table('courses')
          ->select(
          'courses.*',
          'courses.id as A',
          'typecourses.*',
          'departments.*'
          )
          ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
          ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
          ->where('courses.ch_status', 1)
          ->orderBy('sort_corse', 'asc')
          ->get();


          $pack = DB::table('package_products')
           ->where('package_status', 1)
           ->orderBy('package_sort', 'asc')
           ->get();

          $data['pack'] = $pack;

      $data['get_cat'] = $get_cat;
      $data['objs'] = $objs;
      return view('welcome', $data);
    }

    public function course()
    {

      $get_cat = DB::table('departments')
            ->get();

      session()->forget('coupon');

      $objs = DB::table('courses')
          ->select(
          'courses.*',
          'courses.id as A',
          'typecourses.*',
          'departments.*'
          )
          ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
          ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
          ->where('typecourses.id', 2)
          ->where('courses.ch_status', 1)
          ->orderBy('sort_corse', 'asc')
          ->get();


      $data['get_cat'] = $get_cat;
      $data['objs'] = $objs;
      return view('course.index', $data);
    }


    public function course_free()
    {
      $get_cat = DB::table('departments')
            ->get();

            $objs = DB::table('courses')
                ->select(
                'courses.*',
                'courses.id as A',
                'typecourses.*',
                'departments.*'
                )
                ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
                ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
                ->where('typecourses.id', 3)
                ->where('courses.ch_status', 1)
                ->orderBy('sort_corse', 'asc')
                ->get();

          $data['get_cat'] = $get_cat;
          $data['objs'] = $objs;

      return view('course.course_free', $data);
    }

    public function Teaching()
    {

      $get_cat = DB::table('departments')
            ->get();

            $objs = DB::table('courses')
                ->select(
                'courses.*',
                'courses.id as A',
                'typecourses.*',
                'departments.*'
                )
                ->leftjoin('typecourses', 'typecourses.id', '=', 'courses.type_course')
                ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
                ->where('typecourses.id', 1)
                ->where('courses.ch_status', 1)
                ->orderBy('sort_corse', 'asc')
                ->get();

          $data['get_cat'] = $get_cat;
          $data['objs'] = $objs;
      return view('course.teaching', $data);
    }

}
