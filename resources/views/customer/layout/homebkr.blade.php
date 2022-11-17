@extends('customer.layout.layout')
@section('title','Trang chủ')
@section('css')
<style>
  .product img {
    height: 400px;
  }
</style>
@endsection
@section('cart')
<div class="top-cart-block">
  <div class="top-cart-info">
    <a href="javascript:void(0);" class="top-cart-info-count">{{ $count }} Sản phẩm</a>
    {{-- <a href="javascript:void(0);" class="top-cart-info-value">$1260</a> --}}
  </div>
  <i class="fa fa-shopping-cart"></i>
                
  <div class="top-cart-content-wrapper">
    <div class="top-cart-content">
      <ul class="scroller" style="height: 250px;">
        @forelse ($cart as $val)
        <li>
          {{-- <a href="shop-item.html"><img src="#" alt="Rolex Classic Watch" width="37" height="34"></a> --}}
          <span class="cart-content-count">x {{$val['quantity']}}</span>
          <strong><a href="shop-item.html">{{$val['name']}}</a></strong>
          <em>{{number_format($val['price'], 0, ',', '.')}} VND</em>
          <a href="{{route('cart.remove',$val['id'])}}" class="del-goods">&nbsp;</a>
        </li>
        @empty
          <span>giỏ hàng trống</span>
        @endforelse
      </ul>
      <div class="text-right">
        <a href="{{route('cart.list')}}" class="btn btn-default">Xem giỏ hàng</a>
      </div>
    </div>
  </div>            
</div>
@endsection
@section('content')
@if (session('success'))
<div class="alert alert-success">
      <p>{{ session('success') }}</p>
</div>
@endif
{{-- <header class="bg-dark py-5">    
</header> --}} 
<div class="page-slider margin-bottom-35">
        <div id="carousel-example-generic" class="carousel slide carousel-slider">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                <li data-target="#carousel-example-generic" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <!-- First slide -->
                {{-- @foreach ($data3 as $banner)
                @endforeach
                <img src="{{asset($banner->image)}}" alt="slight"> --}}
                <div class="item carousel-item-four active">
                    @foreach ($data3 as $banner)
                    @endforeach
                    <img src="{{asset($banner->image)}}" alt="slight" class="slight">
                    <div class="container">
                        <div class="carousel-position-four text-center">
                            <h2 class="margin-bottom-20 animate-delay carousel-title-v3 border-bottom-title text-uppercase" data-animation="animated fadeInDown">
                            <span class="color-red-v2">{{$banner->title}}</span>
                            </h2>
                            <p class="carousel-subtitle-v2" data-animation="animated fadeInUp">{{$banner->des}}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Second slide -->
                @foreach ($data3 as $banner)
                <div class="item carousel-item-five">
                    <img src="{{asset($banner->image)}}" alt="slight" class="slight">
                    <div class="container">
                        <div class="carousel-position-four text-center">
                            <h2 class="animate-delay carousel-title-v4" data-animation="animated fadeInDown">
                               {{$banner->title}}
                            </h2>
                            <p class="carousel-subtitle-v2" data-animation="animated fadeInUp">{{$banner->des}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Controls -->
            <a class="left carousel-control carousel-control-shop" href="#carousel-example-generic" role="button" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
            <a class="right carousel-control carousel-control-shop" href="#carousel-example-generic" role="button" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
    <div class="main">
        <div class="container">
          <!-- BEGIN SALE PRODUCT & NEW ARRIVALS -->
          <div class="row margin-bottom-40">
            <!-- BEGIN SALE PRODUCT -->
            <div class="col-md-12 sale-product">
                @foreach ($data as  $event)
                @endforeach
              <h2>{{$event->event->name}}</h2>
              <div class="owl-carousel owl-carousel5">
                @foreach ($data as  $event)
                <div>
                  <div class="product-item">
                    <div class="pi-img-wrapper product">
                      <img src="{{asset($event->product->image)}}" class="img-responsive" alt="Berry Lace Dress">
                      <div>
                        <a href="{{asset($event->product->image)}}" class="btn btn-default fancybox-button">Zoom</a>
                        <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
                      </div>
                    </div>
                    <h3><a href="shop-item.html">{{$event->product->name}}</a></h3>
                    <div class="pi-price">
                        <span class="text-muted text-decoration-line-through">{{number_format($event->product->price, 0, ',', '.')}} VND</span><br>
                        {{number_format($event->product->price-($event->product->price*$event->discount)/100, 0, ',', '.') }} VND
                    </div><br>
                    <a href="{{route('checkout.buy',$event->product->id)}}" class="btn btn-default add2cart">Mua hàng</a>
                    <a href="{{route('cart.add',$event->product->id)}}" class="btn btn-default add2cart">Thêm vào giỏ</a>
                    <div class="sticker sticker-sale"></div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <!-- END SALE PRODUCT -->
          </div>
          <!-- END SALE PRODUCT & NEW ARRIVALS -->
  
          <!-- BEGIN SIDEBAR & CONTENT -->
          <div class="row margin-bottom-40 ">
            <!-- BEGIN SIDEBAR -->
            <div class="sidebar col-md-3 col-sm-4">
              <ul class="list-group margin-bottom-25 sidebar-menu">
                <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Ladies</a></li>
                <li class="list-group-item clearfix dropdown">
                  <a href="shop-product-list.html">
                    <i class="fa fa-angle-right"></i>
                    Mens
                    
                  </a>
                  <ul class="dropdown-menu">
                    <li class="list-group-item dropdown clearfix">
                      <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Shoes </a>
                        <ul class="dropdown-menu">
                          <li class="list-group-item dropdown clearfix">
                            <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Classic </a>
                            <ul class="dropdown-menu">
                              <li><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Classic 1</a></li>
                              <li><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Classic 2</a></li>
                            </ul>
                          </li>
                          <li class="list-group-item dropdown clearfix">
                            <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Sport  </a>
                            <ul class="dropdown-menu">
                              <li><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Sport 1</a></li>
                              <li><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Sport 2</a></li>
                            </ul>
                          </li>
                        </ul>
                    </li>
                    <li><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Trainers</a></li>
                    <li><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Jeans</a></li>
                    <li><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Chinos</a></li>
                    <li><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> T-Shirts</a></li>
                  </ul>
                </li>
                <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Kids</a></li>
                <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Accessories</a></li>
                <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Sports</a></li>
                <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Brands</a></li>
                <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Electronics</a></li>
                <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Home & Garden</a></li>
                <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Custom Link</a></li>
              </ul>
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="col-md-9 col-sm-8">
              <h2>Sản phẩm có lượt xem nhiều</h2>
              <div class="owl-carousel owl-carousel3">
                @foreach ($view as  $vew)
                <div>
                    @if ($vew->import->sum('quantity') > 0 && $vew->status == 1)
                    <span class="badge bg-success">Còn hàng</span>
                    @else
                    <span class="badge bg-danger">Hết hàng</span>
                    @endif
                  <div class="product-item">
                    <div class="pi-img-wrapper product">
                      <img src="{{asset($vew->image)}}" class="img-responsive" alt="Berry Lace Dress">
                      <div>
                        <a href="{{asset($vew->image)}}" class="btn btn-default fancybox-button">Zoom</a>
                        <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
                      </div>
                    </div>
                    <h3><a href="shop-item.html">{{$vew->name}}</a></h3>
                    <div class="pi-price">{{number_format($vew->price, 0, ',', '.') }} VND</div>
                    <br><br>
                    <a href="{{route('checkout.buy',$vew->id)}}" class="btn btn-default add2cart">Mua hàng</a>
                    <a href="{{route('cart.add',$vew->id)}}" class="btn btn-default add2cart">Thêm vào giỏ</a>
                    <div class="sticker sticker-new"></div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>     
          <!-- END TWO PRODUCTS & PROMO -->
        </div>
    </div>
@endsection