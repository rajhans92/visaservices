@extends('admin.layouts.home')

@section('main')

<div >
  <div >
    <div >
      <p>Hi {{$user['name']}}</p>
      <p><b>Email Verification</b></p>
      <h2>Verify your email id to click below link.</h2>
    </div>
    <a href="{{url('/verify-email/'.$user['token'])}}">Click Here</a>
  </div>
</div>

@endsection
