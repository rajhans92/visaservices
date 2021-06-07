@extends('front.layouts.app')

@section('title', $blogData->meta_title)
@section('meta_keywords', $blogData->meta_keywords)
@section('meta_description', $blogData->meta_description)

@section('content')

<!-- Header -->
<section class="blogs-section">
  <div class="inner-content">
      <div class="left-sidebar">
          <h5>Choose your topic</h5>
          <ul>
            @foreach($blogCategory as $value)
              <li><a href="{{url('/blog-list'.'?id='.$value->id)}}">{{$value->name}}</a></li>
            @endforeach
          </ul>
          <h5 class="top-articles-heading">The Most Popular Guides</h5>
          <ul class="top-articles">
            @foreach($blogPages as $value)
              <li><a href="{{url($value->visa_url)}}">{{$value->blog_heading}}</a></li>
            @endforeach
          </ul>
      </div>
      <div class="right-content">
          <h1>{{$blogData->blog_heading}}</h1>
          <p class="slogan">{!! $blogData->content_1 !!}</p>
          <div class="_img">
            <img src="{{url('images/blog/'.$blogData->landing_img)}}" />
          </div>
          <div class="_des">
          <div>
            {!! $blogData->content_2 !!}
          </div>
          <a href="{{url($blogData->main_button_url)}}">Apply Now</a>
         </div>
      </div>
  </div>
</section>

@stop
@section('javascript')

@endsection
