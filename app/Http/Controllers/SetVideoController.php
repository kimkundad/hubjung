<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\video_list;
use Illuminate\Support\Facades\Response;

class SetVideoController extends Controller
{
    //
    public function index(){


      $data['course_message'] = 0;
      $data['count_message'] = 0;


      $video_list = DB::table('video_lists')
       ->select(
       'video_lists.*',
       'video_lists.id as id_v',
       'courses.title_course',
       'courses.set_type_c',
       'departments.name_department'
       )
       ->leftjoin('courses', 'courses.id', '=', 'video_lists.course_id')
       ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
       ->orderBy('video_lists.order_sort', 'asc')
       ->paginate(15);
       $data['video_list'] = $video_list;
      // dd($video_list);

      return view('admin.set_video.index', $data);

    }

    public function fea_video(Request $request){


      $user = video_list::findOrFail($request->course_id);

            if($user->fea_video == 1){
                $user->fea_video = 0;
            } else {
                $user->fea_video = 1;
            }


    return response()->json([
    'data' => [
      'success' => $user->save(),
    ]
  ]);


    }

    public function free_video(Request $request){

      $user = video_list::findOrFail($request->course_id);

            if($user->free_video == 1){
                $user->free_video = 0;
            } else {
                $user->free_video = 1;
            }


    return response()->json([
    'data' => [
      'success' => $user->save(),
    ]
  ]);

    }


    public function add_qty2_photo(Request $request){

      $qty2 = $request['qty2'];
      $ids = $request['ids'];

      $obj = video_list::find($ids);
      $obj->time_video = $qty2;
      $obj->save();

      return Response::json([
            'status' => 1001
        ], 200);

    }

    public function search_list_video(Request $request){

      $course_message = null;
      $count_message = null;

      $search_text = $request['q'];
      //dd($search_text);

        $video_list = DB::table('video_lists')
         ->select(
         'video_lists.*',
         'video_lists.id as id_v',
         'courses.title_course',
         'courses.set_type_c',
         'departments.name_department'
         )
         ->leftjoin('courses', 'courses.id', '=', 'video_lists.course_id')
         ->leftjoin('departments', 'departments.id', '=', 'courses.department_id')
          ->Where('courses.title_course','LIKE','%'.$search_text.'%')
          ->orWhere('video_lists.course_video_name','LIKE','%'.$search_text.'%')
          ->paginate(15)
          ->setPath('?q=' . $search_text . '&course_message=' . $course_message . '&count_message=' . $count_message);

        //  dd($search_text);


          return view('admin.set_video.search_video', compact(['video_list']))
             ->with('q', $search_text)
             ->with('course_message', $search_text)
             ->with('count_message', $search_text);


    }
}
