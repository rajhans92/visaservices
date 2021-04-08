@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Visa Types</h3>
    <p>
        <a href="{{ route('admin.visa.typeOfVisaUpload',[$visa_id]) }}" class="btn btn-success">Upload Excel</a>

    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            List
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped datatable dt-select ">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>Visa Type</th>
                        <th>Nationality</th>
                        <th>Govt Fee</th>
                        <th>Standard Price</th>
                        <th>Rush Price</th>
                        <th>Express Price</th>
                    </tr>
                </thead>

                <tbody>
                  @foreach($visaType as $key => $val)
                    <tr data-entry-id="">
                        <td></td>
                        <td>{{$val->visa_type_name}}</td>
                        <td>{{$val->nationality_name}}</td>
                        <td>{{$val->govt_fee}}</td>
                        <td>{{$val->standard_usd_price}}</td>
                        <td>{{$val->rush_usd_price}}</td>
                        <td>{{$val->express_usd_price}}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
