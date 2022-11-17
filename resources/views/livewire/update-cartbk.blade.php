@extends('customer.layout.layout')
@section('title','Giỏ hàng')
@section('content')
@if (session('success'))
<div class="alert alert-success">
      <p>{{ session('success') }}</p>
</div>
@endif
<div class="cart_area section_padding_100 clearfix">
<form method="POST" action="{{route('checkout.infor')}}">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cart-table clearfix">
                    <table class="table table-responsive">
                        <thead>
                            <tr class="text-center">
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th colspan="2">Thao tác</th>
                                <th>Chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (session('carts') != null)
                              @forelse (session('carts') as $id => $val)
                            <tr>
                                <td class="cart_product_img d-flex align-items-center">
                                    {{-- <a href="#"><img src="img/product-img/product-9.jpg" alt="Product"></a> --}}
                                    <div class="row" name="product" value="{{$id}}">
                                        <h6>{{$val['name']}}</h6>
                                    </div>
                                </td>
                                <td class="price">
                                    <span>{{number_format($val['price'], 0, ',', '.')}} VND</span>
                                    <input id="price" value="{{$val['price']}}" type="hidden">
                                </td>
                                <td class="qty">
                                    <div class="quantity">
                                        <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                        <input type="number" class="qty-text" id="qty" step="1" min="1" max="99" name="quantity" value="{{$val['quantity']}}">
                                        <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                    </div>
                                </td>
                                <td> <span class="close"><a href="{{ route('cart.remove',$id)}}">&#10005;</a></span></td>
                                <td><span><a href="{{route('cart.update',$id)}}">Cập nhật</a></span></td>
                                <td>
                                    <input type="checkbox" name="checkbuy" id="{{$val['name']}}" value="{{$id}}">
                                    <label for="{{$val['name']}}">Chọn mua</label>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>Giỏ hàng rỗng</td>
                            </tr>
                      @endforelse
                         @endif
                        </tbody>
                    </table>
                </div>

                <div class="cart-footer d-flex mt-30">
                    <div class="back-to-shop w-50">
                        <a href="{{route('product.event')}}">Mua tiếp sản phẩm</a>
                    </div>
                    <div class="update-checkout w-50 text-right">
                        <a href="{{route('cart.clear')}}">Xoá giỏ hàng</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="shipping-method-area mt-70">
                    <div class="cart-page-heading">
                        <h5>Ghi chú</h5>
                        <p>Điền thông tin cần ghi chú</p>
                    </div>

                    <div class="custom-control custom-radio mb-30">
                        <textarea name="des" id="" cols="30" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="cart-total-area mt-70">
                    <div class="cart-page-heading">
                        <h5>Giỏ hàng tạm tính</h5>
                    </div>

                    <ul class="cart-total-chart tota">
                        <li><span>Sản phẩm:</span> <span>{{$count}} Sản phẩm</span></li>
                        <li><span><strong>Tạm tính:</strong></span> <span><strong><input type="hidden" name="total" value="{{$total}}"><strong>{{number_format($total, 0, ',', '.')}} VND</strong></span></li>
                    </ul>
                    <ul class="cart-total-chart totatwo">
                        <li><span>Sản phẩm:</span> <span class="quanti"></span></li>
                        <li><span><strong>Tạm tính:</strong></span> <span><strong><input type="hidden" name="totaltwo" value=""><strong class="pricetotal"> VND</strong></span></li>
                    </ul>
                    <button type="submit" class="btn karl-checkout-btn">checkout</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
@endsection
@section('js')
<script>
    var cart = @json(session('carts'));
        console.log(Array(cart));
    function moneyfomart(value) {
    let numbe = value.toLocaleString("it-IT", {style:"currency", currency:"VND"});
    return numbe;
   }
    $('.totatwo').css('display','none');
     $('input[name=checkbuy]').on('change', function() {
        var qty = $('#qty').val();
        var price = $('#price').val();
        var id = $('input[name=checkbuy]:checked').val();
       $('.tota').css('display','none');
       $('.totatwo').css('display','block');
       Array(cart).forEach(function(item,index){
        var mang = ['4'];
        if(jQuery.inArray(item[id].id,mang) > 0) {
            console.log('mang ton tại');
        }
        else {
            mang.push(item[id].id);
        }
        console.log(mang);
        if(item[id].id == id){
        let pric = 0;
        pric = Number(item[id].quantity) * Number(item[id].price);
        $('.pricetotal').text(moneyfomart(pric)); 
        $('input[name=totaltwo]').val(pric);
        // console.log(pric);
        $('.quanti').text(Number(item[id].quantity) + ' Sản phẩm');
        return;
        }
       });
});
    //  $('.totatwo').css('display','none');
    // $('input[name=checkbuy]').on('change', function(){

    //     var valueStore = [];
    //     var total_price = 0;
    //     var totalprice = [];
    //     var id = $('input[name=checkbuy]:checked').val();
    //          $.each($("input[name=checkbuy]:checked"), function () {
    //             valueStore.push($(this).val());
    //             Array(cart).forEach(function(item,index){
    //                 if(item[id].id == $("input[name=checkbuy]:checked").val()){ 
    //                 total_price = item[id].quantity * item[id].price;
    //                 totalprice.push(total_price);
    //                 }
    //             })  
    //          });
    //             $('.tota').css('display','none');
    //             $('.totatwo').css('display','block');
    //          $('.pricetotal').text(moneyfomart(totalprice)); 
    //          $('.quanti').text(valueStore.length + ' Sản phẩm');
    // })
</script>
@endsection