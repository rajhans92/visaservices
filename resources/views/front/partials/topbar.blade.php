<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="/"><img src="{{ url('images/logo.png') }}" /></a>
    <button class="navbar-toggler" type="button" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse" id="navbarNavDropdown">
      <div class="toggle-overlay"></div>
      <ul class="navbar-nav">
      @if(isset($menu['header']))
        @foreach($menu['header'] as $key => $val)
          <li class="nav-item"> <a class="nav-link" href="{{isset($val['url']) ? $val['url'] : '#'}}">{{$val['name']}}</a> </li>
        @endforeach
      @endif
      </ul>
    </div>
  </div>
</nav>
