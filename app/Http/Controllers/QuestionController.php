<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\question;
use App\option;
use App\course;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use File;
use App\video_list;

class QuestionController extends Controller
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
        //
    }




    public function store2(Request $request)
    {
      $input = $request->all();
      $image = $request->file('image');

      $this->validate($request, [
           'category_id' => 'required',
           'name_question' => 'required'
       ]);

        $radioExample = $request['radioExample'];

        if($image != NULL){

          $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
          $destinationPath = asset('assets/uploads/');
          $img = Image::make($image->getRealPath());
          $img->resize(500, 500, function ($constraint) {
          $constraint->aspectRatio();
        })->save('assets/uploads/'.$input['imagename']);

          $obj = new question();
          $obj->category_id = $request['category_id'];
          $obj->name_questions = $request['name_question'];
          $obj->point = 1;
          $obj->image = $input['imagename'];
          $obj->save();

        }else{

          $obj = new question();
          $obj->category_id = $request['category_id'];
          $obj->name_questions = $request['name_question'];
          $obj->point = 1;
          $obj->save();

        }



         $the_id = $obj->id;

         $name_option = request()->get('name_option');
         $type_option = request()->get('type_option');

         if($the_id){
         if (sizeof($name_option) > 0) {
                    for ($i = 0; $i < sizeof($name_option); $i++) {

                      $j = $i+1;

                      $option = new option();
                      $option->question_id = $the_id;
                      $option->name_option = $name_option[$i];
                      $option->type_option = $type_option;
                    //  $obj->status = $request['status'];
                      $option->save();

                      $the_option = $option->id;

                    /*    $admins[] = [
                            'question_id' => $the_id,
                            'name_option' => $name_option[$i],
                            'type_option' => $type_option,
                        ];  */

                        if($j == $radioExample){

                          $sum_ans = $radioExample;

                          DB::table('questions')
                          ->where('id_questions', $the_id)
                          ->update(['status' => $the_option]);

                        }


                    }

                }
        //  option::insert($admins);


        return redirect(url('admin/example/'.$request['category_id']))->with('success_questions','เพิ่มข้อสอบ'.$request['name_question'].' สำเร็จ');
    }



    }



    public function updatesort_video(Request $request, $id)
    {
      $sort_order = $request['sort_order'];



         // dd($sort_order);
          $sort_order = json_decode($sort_order,true);
         // dd($sort_order);
        //  return redirect(url('admin/category'))->with('edit','Edit successful');

          foreach($sort_order as $index=>$ids) {
         // $ids = (int) $ids;

         $obj = DB::table('video_lists')
          ->select(
          'video_lists.*'
          )
          ->where('id', $ids['id'])
          ->where('course_id', $id)
          ->update(array('order_sort' => ($index + 1) ));

         // echo $ids['id'];
  }

  return redirect(url('admin/course/'.$id.'/edit'))->with('edit_sort_video','ทำการเรียงลำดับ video ใหม่เรียบร้อยแล้ว');
    }

    public function updatesort(Request $request, $id)
    {
        $sort_order = $request['sort_order'];



           // dd($sort_order);
            $sort_order = json_decode($sort_order,true);
           // dd($sort_order);
          //  return redirect(url('admin/category'))->with('edit','Edit successful');

            foreach($sort_order as $index=>$ids) {
           // $ids = (int) $ids;

           $obj = DB::table('questions')
            ->select(
            'questions.*'
            )
            ->where('id_questions', $ids['id'])
            ->update(array('order_sort' => ($index + 1) ));

           // echo $ids['id'];
    }

    return redirect(url('admin/example/'.$id))->with('edit','ทำการเรียงลำดับคำถามใหม่เรียบร้อยแล้ว');

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


    public function del_video(Request $request, $id)
    {

      $url_videos = DB::table('video_lists')
      ->where('video_lists.id', $id)
      ->first();


      $url_videos = 'assets/videos/'.$url_videos->course_video;
      File::delete($url_videos);


      $course_id = $request['course_id'];

      $objo = DB::table('video_lists')
      ->where('id', $id)
      ->delete();

      return redirect(url('admin/course/'.$course_id.'/edit'))->with('delete_video','ทำการลบ video ใหม่เรียบร้อยแล้ว');
    }


    public function del_video2(Request $request, $id)
    {

      $url_videos = DB::table('example_videos')
      ->where('example_videos.id', $id)
      ->first();


      $url_videos = 'web_stream/example_video/'.$url_videos->course_video;
      File::delete($url_videos);


      $course_id = $request['course_id'];

      $objo = DB::table('example_videos')
      ->where('id', $id)
      ->delete();

      return redirect(url('admin/course/'.$course_id.'/edit'))->with('delete_video','ทำการลบ video ใหม่เรียบร้อยแล้ว');
    }


    public function deleteq($id)
    {

      $obj_img = DB::table('questions')
      ->where('questions.id_questions', $id)
      ->first();

      $destinationPath = 'assets/uploads/'.$obj_img->image;
      File::delete($destinationPath);


      $obj = DB::table('questions')
      ->where('questions.id_questions', $id)
      ->delete();

      $objo = DB::table('options')
      ->where('options.question_id', $id)
      ->delete();

      return back()->with('delete_q','ลบข้อมูล สำเร็จ');
    }


}
