@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Visa Application</h3>


    <div class="panel panel-default">
        <div class="panel-heading">
            List
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped datatable dt-select ">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>Order ID</th>
                        <th>Email Id</th>
                        <th>Total Payment</th>
                        <th>Visa Type</th>
                        <th>Processing Type</th>
                        <th>Submission Date</th>
                        <th>Payment Status</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($visaData as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->order_id}}</td>
                        <td>{{$val->email_id}}</td>
                        <td>{{$val->total_payment}}</td>
                        <td>{{$val->type_of_visa}}</td>
                        <td>{{$val->visa_process_type}}</td>
                        <td>{{date('d-m-Y',strtotime($val->submission_date))}}</td>
                        <td>{{$val->payment_status == 1 ? "Paid":"Panding"}}</td>
                        <td>
                          <a href="{{ route('admin.application.detail',[$val->id]) }}" class="btn btn-xs btn-info">Show DetailS</a>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
