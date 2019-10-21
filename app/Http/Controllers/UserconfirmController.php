<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\user_confirm;
use App\Users;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class UserconfirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $objs = DB::table('users')
          ->select(
          'user_confirms.*',
          'users.*',
          'levels.*',
          'levels.id as level_user'
          )
          ->leftjoin('user_confirms', 'users.id', '=', 'user_confirms.user_id')
          ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
          ->where('users.id', Auth::user()->id)
          ->first();
        //  dd($objs);
      $data['objs'] = $objs;
      $data['method'] = "put";
      return view('profile.user_confirm', $data);
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
      $objs = DB::table('users')
          ->select(
          'user_confirms.*',
          'user_confirms.id as AA',
          'users.*'
          )
          ->leftjoin('user_confirms', 'users.id', '=', 'user_confirms.user_id')
          ->where('users.id', Auth::user()->id)
          ->first();


        //  dd($objs->AA);

        if($objs->AA != NULL){



          $image = $request->file('image');

         if($image == NULL){

           $this->validate($request, [
                'id_card' => 'required',
            ]);

            $package = user_confirm::find($objs->AA);
            $package->id_card = $request['id_card'];
            $package->save();

          return redirect(url('user_confirm'))->with('success','แก้ไขข้อมูล ยืนยันตัวตน สำเร็จ');


          }else{


            $this->validate($request, [
                 'image' => 'required|mimes:jpg,jpeg,png,gif|max:10048',
                 'id_card' => 'required',
             ]);


             $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

              $destinationPath = asset('assets/uploads/');
              $img = Image::make($image->getRealPath());
              $img->resize(400, 400, function ($constraint) {
              $constraint->aspectRatio();
            })->save('assets/uploads/'.$input['imagename']);


            $package = user_confirm::find($objs->AA);
            $package->image = $input['imagename'];
            $package->id_card = $request['id_card'];
            $package->save();
            return redirect(url('user_confirm'))->with('success','แก้ไขข้อมูล ยืนยันตัวตน สำเร็จ');

          }



        }else{

          $image = $request->file('image');

          $this->validate($request, [
               'image' => 'required|mimes:jpg,jpeg,png,gif|max:10048',
               'id_card' => 'required',
           ]);

           $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

            $destinationPath = asset('assets/uploads/');
            $img = Image::make($image->getRealPath());
            $img->resize(400, 400, function ($constraint) {
            $constraint->aspectRatio();
          })->save('assets/uploads/'.$input['imagename']);

          $package = new user_confirm();
          $package->user_id = Auth::user()->id;
          $package->image = $input['imagename'];
          $package->id_card = $request['id_card'];
          $package->save();
          return redirect(url('user_confirm'))->with('success','แก้ไขข้อมูล ยืนยันตัวตน สำเร็จ');


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
    }
}
