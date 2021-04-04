<meta charset="utf-8">
<title>@yield('title')</title>
<meta name="description" content="@yield('meta_description')">
<meta name="keywords" content="@yield('meta_keywords')">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="{{ url('images/logo/logo.jpg') }}" rel="icon" type="image/png">
<link href="{{ url('images/favicon.png') }}" rel="icon">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ env('APP_NAME') }}</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet" />
<link href="{{ url('front\css\bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ url('front\css\styles.css') }}" rel="stylesheet" />
