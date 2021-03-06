<!DOCTYPE html>
<html>
<head>
  @include('front.partials.head')
</head>
<body>
    <div id="wrapper">

          @include('front.partials.topbar')
          <!-- <div class="page-content"> -->
                    @yield('content')
          <!-- </div> -->
          @include('front.partials.footer')
    </div>
    <style>
    </style>

    @include('front.partials.javascripts')
    <script type="text/javascript">

    </script>

</body>
</html>
