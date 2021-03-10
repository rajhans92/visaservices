@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Home</h3>


    <div class="panel panel-default">
        <div class="panel-heading">
            List
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped datatable dt-select ">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>Title</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                  <tr data-entry-id="">
                      <td></td>
                      <td>Review Section</td>
                      <td>
                          <a href="{{ route('admin.home.sectionReview',[env('APP_LANG')]) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>
                  </tr>
                  <tr data-entry-id="">
                      <td></td>
                      <td>Popular Visa</td>
                      <td>
                          <a href="{{ route('admin.home.popularVisa',env('APP_LANG')) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>

                  </tr>
                  <tr data-entry-id="">
                      <td></td>
                      <td>Section 2</td>
                      <td>
                          <a href="{{ route('admin.home.section2List',env('APP_LANG')) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>

                  </tr>
                  <tr >
                      <td></td>
                      <td>Info Section</td>
                      <td>
                          <a href="{{ route('admin.home.infoList',env('APP_LANG')) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>
                  </tr>
                  <tr data-entry-id="">
                      <td></td>
                      <td>Section 3</td>
                      <td>
                          <a href="{{ route('admin.home.section3List',env('APP_LANG')) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>
                  </tr>
                  <tr data-entry-id="">
                      <td></td>
                      <td>Client Review</td>
                      <td>
                          <a href="{{ route('admin.home.clientReview',env('APP_LANG')) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>
                  </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
