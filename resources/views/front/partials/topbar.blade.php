<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container"> <a class="navbar-brand" href="#"><img src="{{ url('images/logo.png') }}" /></a>
    <button class="navbar-toggler" type="button" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="navbar-collapse" id="navbarNavDropdown">
      <div class="toggle-overlay"></div>
      <ul class="navbar-nav">
        @if($menu['visa'] != "")
          <li class="nav-item"> <a class="nav-link active" href="#">{{$menu['visa']}}</a> </li>
        @endif
        @if($menu['about'] != "")
        <li class="nav-item"> <a class="nav-link" href="/about">{{$menu['about']}}</a> </li>
        @endif
        @if($menu['blog'] != "")
        <li class="nav-item"> <a class="nav-link" href="/blog">{{$menu['blog']}}</a> </li>
        @endif
        @if($menu['contact'] != "")
        <li class="nav-item"> <a class="nav-link" href="/contact-us">{{$menu['contact']}}</a> </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
