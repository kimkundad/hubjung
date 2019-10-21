<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Users;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class UserprofileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(){
      $objs = DB::table('users')
          ->select(
          'users.*',
          'levels.*',
          'levels.id as level_user'
          )
          ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
          ->where('users.id', Auth::user()->id)
          ->first();
        //  dd($objs);
      $data['objs'] = $objs;
      $data['method'] = "put";
      return view('profile.profile_user', $data);
    }
    public function index()
    {
      $objs = DB::table('users')
          ->select(
          'users.*',
          'levels.*',
          'levels.id as level_user'
          )
          ->leftjoin('levels', 'levels.points', '>=', 'users.point_level')
          ->where('users.id', Auth::user()->id)
          ->first();
        //  dd($objs);
      $data['objs'] = $objs;
      $data['method'] = "put";
      return view('profile.index', $data);
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
       $image = $request->file('image');


      if($image == NULL){

        $this->validate($request, [
             'nickname' => 'required',
             'email' => 'required',
             'hbd' => 'required',
             'address' => 'required',
             'phone' => 'required',
             'line_id' => 'required',
         ]);

         $package = users::find($id);
         $package->name = $request['nickname'];
         $package->email = $request['email'];
         $package->hbd = $request['hbd'];
         $package->phone = $request['phone'];
         $package->address = $request['address'];
         $package->line_id = $request['line_id'];
         $package->bio = $request['bio'];
         $package->save();

       return redirect(url('profile_user'))->with('success','แก้ไขข้อมูลส่วนตัวสำเร็จ');

       }else{

         $this->validate($request, [
              'image' => 'required|mimes:jpg,jpeg,png,gif|max:10048',
              'nickname' => 'required',
              'email' => 'required',
              'hbd' => 'required',
              'address' => 'required',
              'phone' => 'required',
              'line_id' => 'required',
          ]);

          $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

           $destinationPath = asset('assets/images/avatar');
           $img = Image::make($image->getRealPath());
           $img->resize(300, null, function ($constraint) {
           $constraint->aspectRatio();
         })->save('assets/images/avatar/'.$input['imagename'], 50);

          $package = users::find($id);
          $package->avatar = $input['imagename'];
          $package->name = $request['nickname'];
          $package->email = $request['email'];
          $package->hbd = $request['hbd'];
          $package->phone = $request['phone'];
          $package->address = $request['address'];
          $package->line_id = $request['line_id'];
          $package->bio = $request['bio'];
          $package->save();
          return redirect(url('profile_user'))->with('success','แก้ไขข้อมูลส่วนตัวสำเร็จ');
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
