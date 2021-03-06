<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;

class ExamSliderController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('exam_slider_access')) {
            return abort(401);
        }

        $querUsers = DB::table('slider')
            ->select('slider.id AS id','slider.title AS title','slider.detail AS detail','status.title AS status')
            ->join('status','status.id','=','slider.status');

        $slider = $querUsers->get();

        return view('admin.exam-slider.index', compact('slider'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('exam_slider_create')) {
            return abort(401);
        }

        return view('admin.exam-slider.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('exam_slider_create')) {
            return abort(401);
        }
        $path = "";
        if ($request->hasFile('path')) {
            $images = $request->path->getClientOriginalName();
            $images = time().'_'.$images; // Add current time before image name
            $request->path->move(env('IMG_UPLOAD_PATH').'img/slider/',$images);
            $path = $images;
        }
        $slider = DB::table('slider')->insertGetId(
            [
             'title' => $request['title'],
             'detail' => $request['detail'],
             'path' => $path,
             'status' => 1,
             'created_at' => date('Y-m-d')
           ]
        );
        return redirect()->route('admin.exam-slider.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('exam_slider_edit')) {
            return abort(401);
        }

        $querUsers = DB::table('slider')
            ->select('slider.id AS id','slider.title AS title','slider.detail AS detail','slider.path AS path')
            ->where('slider.id','=',$id);

        $slider = $querUsers->first();

        return view('admin.exam-slider.edit', compact('slider'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          if (! Gate::allows('exam_slider_edit')) {
              return abort(401);
          }
          $path="";
          if ($request->hasFile('path')) {
              $images = $request->path->getClientOriginalName();
              $images = time().'_'.$images; // Add current time before image name
              $request->path->move(env('IMG_UPLOAD_PATH').'img/slider/',$images);
              $path = $images;

              $slider = DB::table('slider')
                  ->select('path')
                  ->where('id','=',$id)
                  ->first();
             $oldImagePath = env('IMG_UPLOAD_PATH').'img/slider/'.$slider->path;
              if (file_exists($oldImagePath)) {
                  @unlink($oldImagePath);
              }
          }
          $data =  [
               'title' => $request['title'],
               'detail' => $request['detail'],
               'path' => $path,
               'updated_at' => date('Y-m-d'),
            ];

          DB::table('slider')->where('id','=',$id)->update($data);

          return redirect()->route('admin.exam-slider.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      if (! Gate::allows('exam_slider_edit')) {
          return abort(401);
      }

      $slider = DB::table('slider')
          ->where('slider.id','=',$id)
          ->first();

      return view('admin.exam-slider.show', compact('slider'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('exam_slider_delete')) {
            return abort(401);
        }
        $slider = DB::table('slider')
            ->select('path')
            ->where('id','=',$id)
            ->first();
       $oldImagePath = env('IMG_UPLOAD_PATH').'img/slider/'.$slider->path;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }
        DB::table('slider')->where('id', $id)->delete();

        return redirect()->route('admin.exam-slider.index');
    }

    public function updateStatus(Request $request){
      if (! Gate::allows('exam_slider_edit')) {
          return abort(401);
      }
      // exit(print_r($request->all()));
      DB::table('slider')->where('id', $request->id)->limit(1)
      ->update(array('status' => $request->status,
       'updated_at' => date('Y-m-d')));

      return redirect()->route('admin.exam-slider.index');
    }
    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    // public function massDestroy(Request $request)
    // {
    //     if (! Gate::allows('student_delete')) {
    //         return abort(401);
    //     }
    //     if ($request->input('ids')) {
    //         $entries = User::whereIn('id', $request->input('ids'))->get();
    //
    //         foreach ($entries as $entry) {
    //             $entry->delete();
    //         }
    //     }
    // }

}
