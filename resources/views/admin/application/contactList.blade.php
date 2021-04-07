@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Contact Query</h3>


    <div class="panel panel-default">
        <div class="panel-heading">
            List
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped datatable dt-select ">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>Name</th>
                        <th>Email Id</th>
                        <th>Phone Number</th>
                        <th>Message</th>
                        <th>Visa Country</th>
                        <th>Nationality</th>
                        <th>Submit Date</th>>
                    </tr>
                </thead>

                <tbody>
                  @foreach($visaData as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->name}}</td>
                        <td>{{$val->email}}</td>
                        <td>{{$val->contact_number}}</td>
                        <td>{{$val->message}}</td>
                        <td>{{$val->visa_country}}</td>
                        <td>{{$val->nationality}}</td>
                        <td>{{date('d-m-Y',strtotime($val->submission_date))}}</td>

                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
