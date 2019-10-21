<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\comment;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
      $this->validate($request, [
           'course_id' => 'required',
           'comment' => 'required'
       ]);

       $obj = new comment();
       $obj->user_id = Auth::user()->id;
       $obj->course_id = $request['course_id'];
       $obj->comment = $request['comment'];
       $obj->save();

       $comment_id = $obj->id;

       return redirect(url('courseinfo/'.$request['course_id'].'#comment-id-'.$comment_id))->with('success_course','เพิ่มข้อมูล '.$request['name'].' สำเร็จ');
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
      $this->validate($request, [
           'course_id' => 'required',
           'comment' => 'required'
       ]);

       $obj = comment::find($id);
       $obj->comment = $request['comment'];
       $obj->save();


       return redirect(url('courseinfo/'.$request['course_id'].'#comment-id-'.$id))->with('success_course','เพิ่มข้อมูล '.$request['name'].' สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $obj = DB::table('comments')
      ->where('comments.id', $id)
      ->delete();

      return Redirect::back();
    }
}
