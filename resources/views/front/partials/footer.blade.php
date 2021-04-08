<footer style="background-image:url({{ url('images/offices-map.jpg') }});">
  <div class="container">
    <ul class="footer-top d-flex">
      @if($footerData->tag_1 != "")
        <li><a href="{{isset($urlSet[$footerData->tag_link_1]) ? $urlSet[$footerData->tag_link_1] : '#'}}">{{$footerData->tag_1}}</a></li>
      @endif
      @if($footerData->tag_2 != "")
        <li><a href="{{isset($urlSet[$footerData->tag_link_2]) ? $urlSet[$footerData->tag_link_2] : '#'}}">{{$footerData->tag_2}}</a></li>
      @endif
      @if($footerData->tag_3 != "")
        <li><a href="{{isset($urlSet[$footerData->tag_link_3]) ? $urlSet[$footerData->tag_link_3] : '#'}}">{{$footerData->tag_3}}</a></li>
      @endif
      @if($footerData->tag_4 != "")
        <li><a href="{{isset($urlSet[$footerData->tag_link_4]) ? $urlSet[$footerData->tag_link_4] : '#'}}">{{$footerData->tag_4}}</a></li>
      @endif
    </ul>
    <ul class="payment_images">
      @if($footerData->img_left != "")
        <li><img src="{{ url('images/footer/'.$footerData->img_left) }}" /></li>
      @endif
      @if($footerData->img_right != "")
        <li><img src="{{ url('images/footer/'.$footerData->img_right) }}" /></li>
      @endif
    </ul>
    <div class="row">
      <div class="col-lg-2 col-md-6 col-sm-6">
        <div class="address">
          @if($footerData->address_title_1 != "")
            <h5>{{$footerData->address_title_1}}</h5>
          @endif
          @if($footerData->address_detail_1 != "")
            <address>{{$footerData->address_detail_1}}</address>
          @endif
        </div>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-6">
        <div class="address">
          @if($footerData->address_title_2 != "")
            <h5>{{$footerData->address_title_2}}</h5>
          @endif
          @if($footerData->address_detail_2 != "")
            <address>{{$footerData->address_detail_2}}</address>
          @endif
        </div>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-6">
        <div class="address">
          @if($footerData->address_title_3 != "")
            <h5>{{$footerData->address_title_3}}</h5>
          @endif
          @if($footerData->address_detail_3 != "")
            <address>{{$footerData->address_detail_3}}</address>
          @endif
        </div>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-6">
        <div class="address">
          @if($footerData->address_title_4 != "")
            <h5>{{$footerData->address_title_4}}</h5>
          @endif
          @if($footerData->address_detail_4 != "")
            <address>{{$footerData->address_detail_4}}</address>
          @endif
        </div>
      </div>
      <div class="col-lg-4 col-md-12 col-sm-12">
        <div class="connect">
          <h5>{{$footerData->social_network_title}}</h5>
          <ul class="social-links d-flex">
            <li><a href="{{$footerData->social_network_link1}}"><i class="fab fa-facebook-square"></i></a></li>
            <li><a href="{{$footerData->social_network_link2}}"><i class="fab fa-twitter-square"></i></a></li>
            <li><a href="{{$footerData->social_network_link3}}"><i class="fab fa-instagram-square"></i></a></li>
          </ul>
          @if($footerData->disclaimer_title != "")
            <h5>{{$footerData->disclaimer_title}}</h5>
          @endif
          @if($footerData->disclaimer_detail != "")
            <p>{{$footerData->disclaimer_detail}}</p>
          @endif
        </div>
      </div>
    </div>
    <div class="footer-bottom d-flex">
      <div class="_links">
        <ul class="d-flex">
        @if(isset($menu['footer']))
          @foreach($menu['footer'] as $key => $val)
            <li> <a href="{{$val['url']}}">{{$val['name']}}</a> </li>
          @endforeach
        @endif
        </ul>
      </div>
      @if($footerData->company_detail != "")
        <div class="_copyright"> &copy; {{$footerData->company_detail}} </div>
      @endif
    </div>
  </div>
</footer>
