@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.app')

@section('content')
    <h3 class="page-title">Visa Application</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            Detail &nbsp;&nbsp;     <a href="{{ route('admin.application.index') }}" class="btn btn-default">Back To List</a>
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
                            <th>Email Id</th>
                            <td>{{$visaData->email_id}}</td>

                        </tr>
                        <tr>
                            <th>Arrival Date</th>
                            <td>{{ date('d-m-Y',strtotime($visaData->arrival_date)) }}</td>
                            <th>Departure Date</th>
                            <td>{{ date('d-m-Y',strtotime($visaData->departure_date)) }}</td>
                        </tr>
                        <tr>
                            <th>Visa Type</th>
                            <td>{{ $visaData->visa_type_name }}</td>
                            <th>Visa Processing Type</th>
                            <td>{{ $visaData->visa_process_type }}</td>
                        </tr>
                        <tr>
                            <th>Country Live</th>
                            <td>{{ $visaData->country_live }}</td>
                            <th>Port Of Arrival</th>
                            <td>{{ $visaData->port_of_arrival }}</td>

                        </tr>
                        <tr>
                          <th>Contact No</th>
                          <td>{{ $visaData->contact_no }}</td>
                          <th>Total Payment</th>
                          <td>{{ $visaData->total_payment }}</td>

                        </tr>
                        <tr>
                          <th>Payment Status</th>
                          <td>{{ $visaData->payment_status == 1 ? "Paid" : "Panding" }}</td>

                        </tr>
                    </table>
                    <?php $count=1;?>
                    @foreach($visaApplicant as $key => $val)
                    <table class="table table-bordered table-striped">
                      <tr>
                          <th colspan="4"><h4>Applicant #{{$count++}} Info</h4></th>

                      </tr>
                        <tr>
                            <th>
                              First Name
                            </th>
                            <td>
                                {{$val->first_name}}
                            </td>
                            <th>Last Name</th>
                            <td>{{$val->last_name}}</td>

                        </tr>
                        <tr>
                            <th>Visa Type</th>
                            <td>{{ $visaData->visa_type_name }}</td>
                            <th>Visa Nationality</th>
                            <td>{{$val->nationality}}</td>
                        </tr>
                        <tr>
                            <th>Date Of Birth</th>
                            <td>{{ date('d-m-Y',strtotime($val->date_of_birth)) }}</td>
                            <th>Passport Expiry Date</th>
                            <td>{{ date('d-m-Y',strtotime($val->passport_expiry_date)) }}</td>

                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $val->gender }}</td>
                            <th>Payment (Applicant fee + Tax)</th>
                            <td>{{$val->applicant_payment}} + {{$val->govt_fee}} = {{ $val->applicant_payment + $val->govt_fee }}</td>
                        </tr>
                        <tr>
                          @if($val->passport_file != "")
                            <th>Passport File</th>
                            <td><a href="{{url('images/application/file/'.$val->passport_file)}}" download="passport_file"></td>
                          @endif
                          @if($val->applicant_photo != "")
                            <th>Passport Photo</th>
                            <td><img src="{{url('images/application/photo/'.$val->applicant_photo)}}" onerror="this.src='{{ url('images/default.png') }}'" width="100" height="100"/></td>
                          @endif

                        </tr>
                    </table>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
