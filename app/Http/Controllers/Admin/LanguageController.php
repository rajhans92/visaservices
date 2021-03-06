<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Hash;
use Auth;

class LanguageController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('language_access')) {
            return abort(401);
        }

        $querlanguage = DB::table('languages')
            ->select('languages.id AS id','languages.title AS title','status.title AS status')
            ->join('status','status.id','=','languages.status');

        $language = $querlanguage->get();

        return view('admin.language.index', compact('language'));
    }

    public function onlyView()
    {
        $querlanguage = DB::table('languages')
            ->select('languages.id AS id','languages.title AS title')
            ->join('status','status.id','=','languages.status')
            ->where('languages.status' ,"=",'2');

        $language = $querlanguage->get();
        return view('admin.language.onlyView', compact('language'));
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

        return view('admin.language.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('language_create')) {
            return abort(401);
        }

        $user = DB::table('languages')->insertGetId(
            [
             'title' => $request['title'],
             'status' => 1,
             'created_at' => date('Y-m-d'),
            'created_by' => Auth::user()->id
           ]
        );
        return redirect()->route('admin.language.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('language_edit')) {
            return abort(401);
        }

        $querlanguage = DB::table('languages')
            ->select('languages.id AS id','languages.title AS title','status.title AS status')
            ->join('status','status.id','=','languages.status')
            ->where('languages.id','=',$id);

        $language = $querlanguage->first();

        return view('admin.language.edit', compact('language'));
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
          if (! Gate::allows('language_edit')) {
              return abort(401);
          }

          $data =  [
               'title' => $request['title'],
               'status' => 1,
               'updated_at' => date('Y-m-d'),
              'updated_by' => Auth::user()->id
            ];

          DB::table('languages')->where('id','=',$id)->update($data);

          return redirect()->route('admin.language.index');
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
        if (! Gate::allows('language_delete')) {
            return abort(401);
        }

        DB::table('languages')->where('id', $id)->delete();

        return redirect()->route('admin.language.index');
    }

    public function updateStatus(Request $request){
      if (! Gate::allows('language_edit')) {
          return abort(401);
      }
      // exit(print_r($request->all()));
      DB::table('languages')->where('id', $request->id)->limit(1)
      ->update(array('status' => $request->status,
       'updated_at' => date('Y-m-d'),
      'updated_by' => Auth::user()->id));

      return redirect()->route('admin.language.index');
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
