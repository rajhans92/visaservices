<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;

class ExamCategoryController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('exam_category_access')) {
            return abort(401);
        }

        $querUsers = DB::table('exam_category')
            ->select('exam_category.id AS id','exam_category.title AS title','status.title AS status')
            ->join('status','status.id','=','exam_category.status');

        $category = $querUsers->get();

        return view('admin.exam-category.index', compact('category'));
    }

    public function onlyView()
    {
        $querUsers = DB::table('exam_category')
            ->select('exam_category.id AS id','exam_category.title AS title')
            ->join('status','status.id','=','exam_category.status')
            ->where('exam_category.status' ,"=",'2');

        $category = $querUsers->get();
        return view('admin.exam-category.onlyView', compact('category'));
    }
    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('exam_category_create')) {
            return abort(401);
        }

        return view('admin.exam-category.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('exam_category_create')) {
            return abort(401);
        }

        $user = DB::table('exam_category')->insertGetId(
            [
             'title' => $request['title'],
             'status' => 1,
             'created_at' => date('Y-m-d'),
            'created_by' => Auth::user()->id
           ]
        );
        return redirect()->route('admin.exam-category.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('exam_category_edit')) {
            return abort(401);
        }

        $querUsers = DB::table('exam_category')
            ->select('exam_category.id AS id','exam_category.title AS title','status.title AS status')
            ->join('status','status.id','=','exam_category.status')
            ->where('exam_category.id','=',$id);

        $category = $querUsers->first();

        return view('admin.exam-category.edit', compact('category'));
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
          if (! Gate::allows('exam_category_edit')) {
              return abort(401);
          }

          $data =  [
               'title' => $request['title'],
               'status' => 1,
               'updated_at' => date('Y-m-d'),
              'updated_by' => Auth::user()->id
            ];

          DB::table('exam_category')->where('id','=',$id)->update($data);

          return redirect()->route('admin.exam-category.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('exam_category_delete')) {
            return abort(401);
        }

        DB::table('exam_category')->where('id', $id)->delete();

        return redirect()->route('admin.exam-category.index');
    }

    public function updateStatus(Request $request){
      if (! Gate::allows('exam_category_edit')) {
          return abort(401);
      }
      // exit(print_r($request->all()));
      DB::table('exam_category')->where('id', $request->id)->limit(1)
      ->update(array('status' => $request->status,
       'updated_at' => date('Y-m-d'),
      'updated_by' => Auth::user()->id));

      return redirect()->route('admin.exam-category.index');
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
