<!DOCTYPE html>
<html>
<head>
  @include('front.partials.head')
</head>
<body>

    @include('front.partials.topbar')
    <!-- <div class="page-content"> -->
              @yield('content')
    <!-- </div> -->
    @include('front.partials.footer')
    <style>
    </style>

    @include('front.partials.javascripts')
    <script type="text/javascript">
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();

            if (scroll >= 20) {
                $(".navbar").addClass("sticky");
            } else {
                $(".navbar").removeClass("sticky");
            }
        });
        $(document).ready(function(){
          $(".navbar-toggler").click(function(){
            $("body").addClass("menu-show");
          });
           $(".toggle-overlay").click(function(){
            $("body").removeClass("menu-show");
          });
        });
    </script>

</body>
</html>
