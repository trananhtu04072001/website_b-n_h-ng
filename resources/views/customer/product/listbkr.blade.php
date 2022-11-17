@extends('customer.layout.layout')
@section('title','Tất cả sản phẩm')
@section('css')
<style>
.pi-img-wrapper img {
  height: 400px;
}
</style>
@endsection
@section('content')
<div class="row product-list">
    @foreach ($products as  $product)
    <div>
        <div class="col-md-4 col-sm-6 col-xs-12">
          @if ($product->import->sum('quantity') > 0 && $product->status == 1)
        <span class="badge bg-success">Còn hàng</span>
        @else
        <span class="badge bg-danger">Hết hàng</span>
        @endif
      <div class="product-item">
        <div class="pi-img-wrapper">
          <img src="{{asset($product->image)}}" class="img-responsive" alt="Berry Lace Dress">
          <div>
            <a href="{{asset($product->image)}}" class="btn btn-default fancybox-button">Zoom</a>
            <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
          </div>
        </div>
        <h3><a href="">{{$product->name}}</a></h3>
        <div class="pi-price">{{number_format($product->price, 0, ',', '.') }} VND</div>
        <br><br>
        <a href="javascript:;" class="btn btn-default add2cart">Mua hàng</a>
        <a href="javascript:;" class="btn btn-default add2cart">Thêm vào giỏ</a>
        {{-- <div class="sticker sticker-new"></div> --}}
      </div>
        </div>
    </div>
    @endforeach
  </div>
<footer class="text-center">
    {{ $products->withQueryString()->links() }}
    </footer>
@endsection