<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\department;
use App\package_product;
use App\package_his;
use App\submit_package;
use App\noti_package;

class OrederPackageController extends Controller
{
    //
    public function index(){

      $coursess = DB::table('package_his')
        ->select(
           'package_his.*',
           'package_his.user_id as Uid',
           'package_his.id as Oid',
           'package_his.created_at as Dcre',
           'users.*',
           'users.id as Ustudent',
           'banks.*',
           'package_products.*',
           'package_products.id as id_cource'
           )
        ->leftjoin('users', 'users.id', '=', 'package_his.user_id')
        ->leftjoin('package_products', 'package_products.id', '=', 'package_his.packeage_id')
        ->leftjoin('banks', 'banks.id', '=', 'package_his.bank_id')
        ->get();


        $data['objs'] = $coursess;
        $data['count_message'] = 0;
        $data['course_message'] = 0;
        $data['datahead'] = "สั่งซื้อ Package ใหม่";
        return view('admin.order_package.index', $data);

    }

    public function order_package_edit($id){


      $coursess = DB::table('package_his')
      ->select(
         'package_his.*',
         'package_his.user_id as Uid',
         'package_his.id as Oid',
         'package_his.created_at as Dcre',
         'users.*',
         'users.id as Ustudent',
         'banks.*',
         'package_products.*',
         'package_products.id as id_cource'
         )
        ->where('package_his.id', $id)
        ->leftjoin('users', 'users.id', '=', 'package_his.user_id')
        ->leftjoin('package_products', 'package_products.id', '=', 'package_his.packeage_id')
        ->leftjoin('banks', 'banks.id', '=', 'package_his.bank_id')
        ->first();


      $data['courseinfo'] = $coursess;
      $data['count_message'] = 0;
      $data['course_message'] = 0;
      $data['datahead'] = "สั่งซื้อ Package ใหม่";
      return view('admin.order_package.edit', $data);
    }

    public function update_order_package(Request $request){

      $id = $request['id'];
      $status = $request['status'];
      $package_day = $request['package_day'];

      $coursess = DB::table('package_his')
        ->select(
           'package_his.*',
           'package_his.user_id as Uid',
           'package_his.id as Oid',
           'users.*',
           'banks.*',
           'package_products.*',
           'package_products.id as id_cource'
           )
        ->where('package_his.id', $id)
        ->leftjoin('users', 'users.id', '=', 'package_his.user_id')
        ->leftjoin('package_products', 'package_products.id', '=', 'package_his.packeage_id')
        ->leftjoin('banks', 'banks.id', '=', 'package_his.bank_id')
        ->first();

      //  dd($coursess);

        $check_count = DB::table('submit_packages')
         ->where('user_id', $coursess->Uid)
         ->where('department_id', $coursess->department_id)
         ->count();

        if($status != 0){

          $package = new noti_package();
          $package->user_id = $coursess->user_id;
          $package->name_noti = $coursess->package_name." ได้ทำการยืนยันแล้ว";
          $package->url_noti = "account";
          $package->save();

          if($check_count == 0){
          //  $package_day=15;
            ///// เพิ่มวันใหม่
            $start=date("Y-m-d",time());
            $startdatec=strtotime($start);
            $tod=$package_day*86400;
            $ndate=$startdatec+$tod; // นับบวกไปอีกตามจำนวนวันที่รับมา
            $df=date("Y-m-d",$ndate);
            //dd($df);

            $package = new submit_package();
            $package->user_id = $coursess->Uid;
            $package->packeage_id = $coursess->packeage_id;
            $package->department_id = $coursess->department_id;
            $package->total_day = $package_day;
            $package->start = $start;
            $package->end_date = $df;
            $package->sp_status = 1;
            $package->submit_type = 1;
            $package->save();

            $package = package_his::find($coursess->Oid);
            $package->his_status = 1;
            $package->start = $start;
            $package->end_date = $df;
            $package->save();

          }else{

            $objs = DB::table('submit_packages')
             ->where('user_id', $coursess->Uid)
             ->where('department_id', $coursess->department_id)
             ->first();
             //หากต้องการนับว่าอีกกี่วันจะหมดอายุก็แบบนี้ครับ
             $str_start = strtotime($objs->start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
             $str_end = strtotime($objs->end_date); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
             $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน

             $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที

          //   dd($ndays); // get day

             //// check วันคงเหลือ  ////////////////

             if($ndays == 0){

               ///// เพิ่มวันใหม่

               $start=date("Y-m-d",time());
               $startdatec=strtotime($start);
               $tod=$package_day*86400;
               $ndate=$startdatec+$tod; // นับบวกไปอีกตามจำนวนวันที่รับมา
               $df=date("Y-m-d",$ndate);

               $package = submit_package::find($objs->id);
               $package->packeage_id = $coursess->packeage_id;
               $package->department_id = $coursess->department_id;
               $package->total_day = $package_day;
               $package->start = $start;
               $package->end_date = $df;
               $package->sp_status = 1;
               $package->submit_type = 1;
               $package->save();


               $package = package_his::find($coursess->Oid);
               $package->his_status = 1;
               $package->start = $start;
               $package->end_date = $df;
               $package->save();

               //dd('เพิ่มวันใหม่ลงไป แบบมีของเดิม');

             }else{

               $start=date("Y-m-d",time());
               $startdatec=strtotime($start);
               $tod=$package_day*86400;
               $set_day=$ndays*86400;
               $total_day=$startdatec+($tod+$set_day); // นับบวกไปอีกตามจำนวนวันที่รับมา
               $final_day=date("Y-m-d",$total_day);

               $package = submit_package::find($objs->id);
               $package->packeage_id = $coursess->packeage_id;
               $package->department_id = $coursess->department_id;
               $package->total_day = $package_day;
               $package->end_date = $final_day;
               $package->sp_status = 1;
               $package->submit_type = 1;
               $package->save();


               $package = package_his::find($coursess->Oid);
               $package->his_status = 1;
               $package->start = $start;
               $package->end_date = $final_day;
               $package->save();

            //   dd('มีวันเหลืออยู่นะ '.$final_day);
             }

          /*   $total = $objs->total_day + $package_day;

            $package = submit_package::find($objs->id);
            $package->total_day = $total;
            $package->sp_status = 1;
            $package->save(); */



          }

        }else{

        }

        return redirect(url('admin/order_package/'))->with('delete','คุณทำการลบอสังหา สำเร็จ');

    }

    public function order_package_del(Request $request, $id){

      DB::table('package_his')
     ->where('id', $id)
     ->delete();

     return redirect(url('admin/order_package/'))->with('delete','คุณทำการลบอสังหา สำเร็จ');

    }
}
