@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Footer</h3>


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
                      <td>Tags</td>
                      <td>
                          <a href="{{ route('admin.footer.tags',[env('APP_LANG')]) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>
                  </tr>
                  <tr data-entry-id="">
                      <td></td>
                      <td>Logo</td>
                      <td>
                          <a href="{{ route('admin.footer.logo',env('APP_LANG')) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>

                  </tr>
                  <tr data-entry-id="">
                      <td></td>
                      <td>Office Address</td>
                      <td>
                          <a href="{{ route('admin.footer.office',env('APP_LANG')) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>

                  </tr>
                  <tr >
                      <td></td>
                      <td>Social Network</td>
                      <td>
                          <a href="{{ route('admin.footer.social',env('APP_LANG')) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>
                  </tr>
                  <tr data-entry-id="">
                      <td></td>
                      <td>Disclaimer</td>
                      <td>
                          <a href="{{ route('admin.footer.disclaimer',env('APP_LANG')) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>
                  </tr>
                  <tr data-entry-id="">
                      <td></td>
                      <td>Company Detail</td>
                      <td>
                          <a href="{{ route('admin.footer.company',env('APP_LANG')) }}" class="btn btn-xs btn-info">Edit</a>
                      </td>
                  </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
