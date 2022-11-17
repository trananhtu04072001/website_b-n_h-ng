@extends('customer.layout.layout')
@section('title','Chi tiết sản phẩm')
@section('css')
<style>
  .left-column img {
    width: 550px;
  }
  .color {
    float: left;
  }
  .size {
    float: right;
  }
</style>
@stop
@section('content')
<main class="containerl">
  
    <!-- Left Column / Headphones Image -->
    <div class="imagedetail">
        @foreach ($data4 as $image)
        <img data-image="blue" src="{{asset($image->image)}}" alt="">
        @endforeach
    </div>
    <div class="left-column">
    @foreach ($data as $detail)
      <img data-image="red" class="active" src="{{asset($detail->image)}}" alt="">
    </div>
    
    <input type="hidden" name="valueid" value="{{$detail->id}}">
    <!-- Right Column -->
    <div class="right-column">
      <div class="message">
        <span class="error"></span>
        <span class="errortwo"></span>
      </div>
    
      <!-- Product Description -->
      <div class="product-description">
        <span>sản phẩm chi tiết</span>
        <h3>{{$detail->name}}</h3><br>
        <span>Miêu tả sản phẩm</span>
        <p>{{$detail->des}}</p>
      </div>
      @endforeach
      <!-- Product Configuration -->
      <div class="product-configuration">
    
        <!-- Product Color -->
        <br><br>
        <label class="control-label">Màu sắc:</label>
        <label class="control-label size">Kích thước:</label>
      <div class="product_atr">
        <select name="color" class="color" form="formreq">
          <option value="0">Màu sắc</option>
          @foreach ($data3 as $atribute)
          @if($atribute->atr->id_atrgroup == 1)
          <option value="{{$atribute->atr->value}}">{{$atribute->atr->value}}<i class="fa-solid fa-brush" style="color: {{$atribute->atr->value}}"></i></option>
          @endif
          @endforeach
        </select>

        <!-- Cable Configuration -->
          <select name="size" class="size" form="formreq">
            <option value="0">Kích thước</option>
            @foreach ($data3 as $atribute)
            @if($atribute->atr->id_atrgroup == 3)
            <option value="{{$atribute->atr->value}}">{{$atribute->atr->value}}</option>
            @endif
            @endforeach
          </select>
      </div>
      </div>
      <br><br><br>
      @foreach ($data as $detail)
      <form method="GET" action="{{ route('cartadd.detail',$detail->id)}}" id="formreq">
        @endforeach
      <div class="product-quantity">
        <span>Số lượng:</span>
        <input id="product-quantity" name="quantity" type="number" value="1" class="form-control" min="1">
      </div>
      <!-- Product Pricing -->
      <br><br><br>
      <div class="product-price text-center">
        <button type="submit" class="cart-btn">Add to cart</button>
      </div>
    </form>
    </div>
  </main>
@endsection
@section('js')
<script>
//     $(document).ready(function() {
  
//   $('.color-choose input').on('click', function() {
//       var headphonesColor = $(this).attr('data-image');
  
//       $('.active').removeClass('active');
//       $('.left-column img[data-image = ' + headphonesColor + ']').addClass('active');
//       $(this).addClass('active');
//   });
  
// });



var dataim = @json($data6);
$('input[name=quantity]').on('click', function() {
  var valquan = $('input[name=quantity]').val();
  var valueid = $('input[name=valueid]').val();
  dataim.forEach(function(item,index){
    if(item['id_product'] == valueid) {
      // console.log('đúng');
      $('input[name=quantity]').attr('max',item['sum']);
      var total = $('input[name=quantity]').attr('max');
      if(valquan > total) {
        $('.message').css('background-color','red');
        $('.message').css('height','30px');
        $('.message').css('text-aligh','center');
        $('.error').text('Sản phẩm đã vượt số lượng trong kho');
        $('.message').css('display','block');
      }
      if(valquan < total) {
        $('.message').css('display','none');
      }
    }
    else {
      var total = $('input[name=quantity]').attr('max');
      $('input[name=quantity]').attr('max',0);
      if(total == 0){
        $('.message').css('background-color','skyblue');
        $('.message').css('height','30px');
        $('.message').css('text-aligh','center');
        $('.errortwo').text('sản phẩm không tồn tại trong kho');  
      }
    }
  });
});
</script>
@stop