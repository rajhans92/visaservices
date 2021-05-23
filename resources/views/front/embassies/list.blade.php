@extends('front.layouts.app')


@section('content')
<section class="embassies-section">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="inner-head">Embassy Finder and Information</h1>
        @if(count($data))
        <ul class="link_container">
          @foreach($data as $key => $val)
           <li class="letter_link"><a href="#{{$key}}">{{strtoupper($key)}}</a></li>
          @endForeach
        </ul>

        <div class="card">
          @foreach($data as $key => $val)
            <div class="row" id="{{$key}}">
              @foreach($val as $key1 => $val1)
                <div class="col-md-3 col-sm-3"><a href="{{url($val1['url'])}}">{{ucfirst($val1['name'])}}</a></div>
              @endForeach
            </div>
          @endForeach
        </div>

        @endif
      </div>
    </div>
  </div>
</section>

@stop
@section('javascript')

<script type="text/javascript">

</script>
@endsection
