@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Service Application</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            Detail &nbsp;&nbsp;     <a href="{{ route('admin.services.applicationList') }}" class="btn btn-default">Back To List</a>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                      <tr>
                          <th colspan="4"><h4>General Info</h4></th>

                      </tr>
                        <tr>
                            <th>
                              Order Id
                            </th>
                            <td>
                                {{$visaData->order_id}}
                            </td>
                            <th>Service Name</th>
                            <td><b>{{ ucfirst($visaData->services_name) }}</b></td>
                        </tr>
                        <tr>
                          <th>Email Id</th>
                          <td>{{$visaData->email_id}}</td>
                          <th>Contact No</th>
                          <td>{{ $visaData->contact_no }}</td>
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td>{{ $visaData->nationality }}</td>
                            <th>Visa Processing Type</th>
                            <td>{{ $visaData->visa_process_type }}</td>
                        </tr>
                        <tr>
                            <th>Country Live</th>
                            <td>{{ $visaData->country_live }}</td>
                            <th>Contact No</th>
                            <td>{{ $visaData->contact_no }}</td>

                        </tr>
                        <tr>
                          <th>Service Fee</th>
                          <td>{{ $visaData->service_fee }}</td>
                          <th>Govt Fees</th>
                          <td>{{ $visaData->govt_fee }}</td>

                        </tr>
                        <tr>
                          <th>Total Payment</th>
                          <td>{{ $visaData->total_payment }}</td>
                          <th>Payment Status</th>
                          <td>{{$visaData->payment_status == 1 ? "Paid": "Panding"}}
                          </td>

                        </tr>
                        <tr>
                            <th>Submission Date</th>
                            <td>{{ date('d-m-Y',strtotime($visaData->submission_date)) }}</td>
                        </tr>
                        <tr>
                          @if($visaData->upload_passport != "")
                            <th>Passport File</th>
                            <td><a href="{{url('images/services/application/file/'.$visaData->upload_passport)}}" download="passport_file">Download</a></td>
                          @endif
                          @if($visaData->upload_photo != "")
                            <th>Passport Photo</th>
                            <td>
                              <a href="{{url('images/services/application/photo/'.$visaData->upload_photo)}}" download="passport_photo">Download</a></td>
                          @endif

                        </tr>
                        <tr>
                          @if($visaData->upload_other != "")
                            <th>Other File</th>
                            <td><a href="{{url('images/services/application/other/'.$visaData->upload_other)}}" download="other_file">Download</a></td>
                          @endif
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
