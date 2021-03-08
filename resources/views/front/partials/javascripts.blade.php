<script src="{{ url('front\js\jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ url('front\js\bootstrap.min.js') }}" type="text/javascript"></script>

<script>
    window._token = '{{ csrf_token() }}';
</script>



@yield('javascript')
