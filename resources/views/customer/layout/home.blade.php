@extends('customer.layout.layout')
@section('title','Trang chủ')
@section('css')
<style>
    .product img {
        height: 300px;
    }
</style>
@stop
@section('content')
@if (session('success'))
<div class="alert alert-success">
      <p>{{ session('success') }}</p>
</div>
@endif
<header class="bg-dark py-5">
    <div class="slideshow-container">
        @foreach ($data3 as $banner)
        <div class="mySlides fade">
          <img src="{{ asset($banner->image)}}" style="width:100%;height:500px">
          <div class="text">{{$banner->name}}</div>
        </div>
        @endforeach
        
        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>
        
        </div>
        <br>
        
        <div style="text-align:center">
          <span class="dot" onclick="currentSlide(1)"></span> 
          <span class="dot" onclick="currentSlide(2)"></span> 
          <span class="dot" onclick="currentSlide(3)"></span> 
        </div>        
</header>
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        @foreach ($data as  $event)
        @endforeach
        <h2 class="text-center">{{$event->event->name}}</h2>
        <br>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @foreach ($data as  $event)
            <div class="col mb-5">
                <div class="listproduct card h-100">
                    <!-- Sale badge-->
                    <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">giảm {{$event->discount}} %</div>
                    <!-- Product image-->
                    <a href="{{route('cusproduct.detail',$event->product->id)}}" class="product">
                    <img class="card-img-top" src="{{asset($event->product->image)}}" alt="..." />
                    </a>
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">{{$event->product->name}}</h5>
                            <span class="text-muted text-decoration-line-through">{{number_format($event->product->price, 0, ',', '.')}} VND</span>
                            <br>
                            {{number_format($event->product->price-($event->product->price*$event->discount)/100, 0, ',', '.') }} VND
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{route('checkout.buy',$event->product->id)}}">Mua hàng</a></div>
                        <br>
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{route('cart.event',$event->product->id)}}">Thêm vào giỏ hàng</a></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <br><br>
        <h2 class="text-center">Sản phẩm lượt xem nhiều</h2>
        <br>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        @foreach ($view as  $vew)
            <div class="col mb-5">
                    @if ($vew->import->sum('quantity') > 0 && $vew->status == 1)
                    <span class="badge bg-success">Còn hàng</span>
                    @else
                    <span class="badge bg-danger">Hết hàng</span>
                    @endif
                <div class="listproduct card h-100">
                    <!-- Sale badge-->
                    {{-- <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">giảm {{$event->discount}} %</div> --}}
                    <!-- Product image-->
                    <a href="{{route('cusproduct.detail',$vew->id)}}" class="product">
                    <img class="card-img-top" src="{{asset($vew->image)}}" alt="..." />
                    </a>
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">{{$vew->name}}</h5>
                            {{-- <span class="text-muted text-decoration-line-through">{{number_format($vew->price, 0, ',', '.')}} VND</span>
                            <br> --}}
                            {{number_format($vew->price-($vew->price*$vew->discount)/100, 0, ',', '.') }} VND
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{route('checkout.buy',$vew->id)}}">Mua hàng</a></div>
                        <br>
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{route('cart.add',$vew->id)}}">Thêm vào giỏ hàng</a></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
    let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>
@stop