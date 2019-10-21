<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\course;
use App\typecourses;
use App\Http\Requests;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Excel;
use App\example;
use File;
use App\users;
use App\submitcourse;
use App\bank;
use Mail;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;
use App\qrcode;

class MyansController extends Controller
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
          'users.*'
          )
          ->where('users.id', Auth::user()->id)
          ->first();

      $coursefin = DB::table('submitcourses')
        ->select(
           'submitcourses.*',
           'submitcourses.user_id as Uid',
           'submitcourses.id as Oid',
           'courses.*',
           'courses.id as Cid'
           )
        ->where('submitcourses.user_id', Auth::user()->id)
        ->where('submitcourses.status', 2)
        ->leftjoin('courses', 'courses.id', '=', 'submitcourses.course_id')
        ->get();

        foreach ($coursefin as $obj) {
            $optionsRes = [];
            $options = DB::table('examples')->select(
              'examples.*',
              'examples.id as Eid',
              'categories.*'
              )
              ->leftjoin('categories', 'categories.id', '=', 'examples.category_id')
              ->where('course_id',$obj->Cid)
              ->get();

            foreach ($options as $option) {

                 $optionsRes[] = $option;

            }
            $obj->options = $optionsRes;

        }

        dd($coursefin);

    return view('mycourse.my_ans')->with([
         'courseinfosfin' =>$coursefin,
         'objs' => $objs
       ]);
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
        //
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
