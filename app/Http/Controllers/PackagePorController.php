<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\department;
use App\package_product;
use App\noti_package;

class PackagePorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $objs = DB::table('package_products')
         ->orderBy('package_sort', 'asc')
         ->get();

        $data['objs'] = $objs;
        $data['count_message'] = 0;
        $data['course_message'] = 0;
        $data['datahead'] = "คอร์สเรียนทั้งหมด";
        return view('admin.package_product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $department = department::all();
        $data['url'] = url('admin/package_product');
        $data['department'] = $department;
        $data['count_message'] = 0;
        $data['course_message'] = 0;
        $data['datahead'] = "คอร์สเรียนทั้งหมด";
        return view('admin.package_product.create', $data);
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
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->resize(500, 500, function ($constraint) {
        $constraint->aspectRatio();
      })->save('web_stream/img/package/'.$input['imagename']);

      $package_day = $request['package_day'];
      if($package_day == 7){
        $type = 1;
      }else{
        $type = 0;
      }

      $obj = new package_product();
      $obj->package_name = $request['package_name'];
      $obj->department_id = $request['department_id'];
      $obj->package_day = $request['package_day'];
      $obj->package_price = $request['package_price'];
      $obj->package_sort = $request['package_sort'];
      $obj->package_type = $type;
      $obj->package_image = $input['imagename'];
      $obj->save();


      $package = new noti_package();
      $package->user_id = 0;
      $package->name_noti = "Package ใหม่ สมัครเลย ".$request['package_name'];
      $package->url_noti = "japanonline";
      $package->new_status = 1;
      $package->save();

      return redirect(url('admin/package_product/'))->with('success','เพิ่มข้อมูล สำเร็จ');


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
        $objs = package_product::find($id);
        $data['objs'] = $objs;
        $department = department::all();
        $data['department'] = $department;
        $data['count_message'] = 0;
        $data['course_message'] = 0;
        $data['method'] = "put";
        $data['url'] = url('admin/package_product/'.$id);
        $data['header'] = "แก้ไขคอร์ส";
        return view('admin.package_product.edit', $data);
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

        $package_day = $request['package_day'];
        if($package_day == 7){
          $type = 1;
        }else{
          $type = 0;
        }

        if($image != NULL){

          $objs = DB::table('package_products')
           ->where('id', $id)
           ->first();

           $file_path = 'web_stream/img/package/'.$objs->package_image;
                         unlink($file_path);


          $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
          $img = Image::make($image->getRealPath());
          $img->resize(500, 500, function ($constraint) {
          $constraint->aspectRatio();
        })->save('web_stream/img/package/'.$input['imagename']);

          $obj = package_product::find($id);
          $obj->package_name = $request['package_name'];
          $obj->department_id = $request['department_id'];
          $obj->package_day = $request['package_day'];
          $obj->package_price = $request['package_price'];
          $obj->package_sort = $request['package_sort'];
          $obj->package_image = $input['imagename'];
          $obj->package_status = $request['package_status'];
          $obj->package_type = $type;
          $obj->save();

        }else{


          $obj = package_product::find($id);
          $obj->package_name = $request['package_name'];
          $obj->department_id = $request['department_id'];
          $obj->package_day = $request['package_day'];
          $obj->package_price = $request['package_price'];
          $obj->package_sort = $request['package_sort'];
          $obj->package_status = $request['package_status'];
          $obj->package_type = $type;
          $obj->save();

        }

        return redirect(url('admin/package_product/'))->with('edit_success','แก้ไขข้อมูล สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function package_product_del($id)
    {
        //
        $objs = DB::table('package_products')
         ->where('id', $id)
         ->first();

         $file_path = 'web_stream/img/package/'.$objs->package_image;
                       unlink($file_path);

                       DB::table('package_products')
                      ->where('id', $id)
                      ->delete();

                      return redirect(url('admin/package_product/'))->with('delete','คุณทำการลบอสังหา สำเร็จ');
    }



}
