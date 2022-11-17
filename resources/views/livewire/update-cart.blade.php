@extends('customer.layout.layout')
@section('title','Giỏ hàng')
@section('content')
@if (session('success'))
<div class="alert alert-success">
      <p>{{ session('success') }}</p>
</div>
@endif
<div class="cart_area section_padding_100 clearfix">
    <form action="" method="GET" id="form1">
    </form>
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
                                <th>Màu sắc</th>
                                <th>Kích cỡ</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thao tác</th>
                                <th>
                                    <input type="checkbox" name="selectall" id="selectall">
                                    <label for="selectall">Chọn tất</label>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                              @forelse ($cart as $id => $val)
                            <tr>
                                <td class="cart_product_img d-flex align-items-center">
                                    {{-- <a href="#"><img src="img/product-img/product-9.jpg" alt="Product"></a> --}}
                                    <div class="row" name="product" value="{{$val->id}}">
                                        {{-- <h6>{{$val['attributes']['image']}}</h6> --}}
                                        <img src="{{asset($val['attributes']['image'])}}" alt="" style="width:100px">
                                        <br><br>
                                        <h6>{{$val['name']}}</h6>
                                    </div>
                                </td>
                                <td>
                                    <h6>{{$val['attributes']['color']}}</h6>
                                </td>
                                <td>
                                    <h6>{{$val['attributes']['size']}}</h6>
                                </td>
                                <td class="price">
                                    <span>{{number_format($val['price'], 0, ',', '.')}} VND</span>
                                    <input id="price" value="{{$val['price']}}" type="hidden">
                                </td>
                                <td class="qty">
                                    <div class="quantity">
                                        <input type="number" class="qty-text" id="qty" step="1" min="1" max="99" name="{{$val['id']}}" value="{{$val['quantity']}}" form="form1">
                                        <button type="submit" class="updat" form="form1">Cập nhật</button>
                                        <input type="hidden" class="valueid" value="{{$val['id']}}">
                                    </div>
                                </td>
                                <td> <span class="close"><a href="{{ route('cart.remove',$val->id)}}">&#10005;</a></span></td>
                                {{-- <td>
                                    <input class="checkbox1" type="checkbox" name="checkbuy[]" id="{{$val['id']}}" value="{{$val->id}}">
                                    <label for="{{$val['id']}}">Chọn mua</label>
                                </td> --}}
                                <td>
                                    @foreach ($product as $prod)
                                        @if ($prod->image == $val['attributes']['image'])
                                        <input class="checkbox1" type="checkbox" name="checkbuy[]" id="{{$val['id']}}" value="{{$prod->id}}">
                                        <label for="{{$val['id']}}">Chọn mua</label>
                                        @endif
                                    @endforeach
                                </td>
                                {{-- <input type="hidden" class="valueid" value="{{$val['id']}}"> --}}
                            </tr>
                            @empty
                            <tr>
                                <td>Giỏ hàng rỗng</td>
                            </tr>
                      @endforelse
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
                        <input type="hidden" name="quantity" value="" class="quantipush">
                        <li><span>Sản phẩm:</span> <span class="quantione"></span></li>
                        <li><span><strong>Tạm tính:</strong></span> <span><strong><input type="hidden" name="total" value=""><strong class="pricetotalone"></strong></span></li>
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
    var cart = @json($cart);
    function moneyfomart(value) {
    let numbe = value.toLocaleString("it-IT", {style:"currency", currency:"VND"});
    return numbe;
   }
     $('.totatwo').css('display','none');
    $('input[name="checkbuy[]"]').on('change', function(){

        var valueStore = [];
        var total_price = 0;
        var totalprice = [];
        var totalquantity = [];
        var totalquanti = [];
                valueStore.push($(this).val());
                var product = $('input[name="checkbuy[]"]:checked');
                Array(product).forEach(function(item,index){
                    for(var i=0 ; i < item.length ; i++) {
                        // console.log(item[i].id);
                        totalquantity.push(item[i].id);
                        var id = totalquantity[i];
                        totalprice.push((cart[id].price)*(cart[id].quantity));
                        totalquanti.push((cart[id].quantity))
                        }
                        var total = 0;
                        for(var k = 0 ; k < totalprice.length ; k++) {
                           total = parseInt(total) + parseInt(totalprice[k]);
                    }
                    var totalquan = 0;
                    for(var t = 0 ; t < totalquanti.length ; t++) {
                           totalquan = parseInt(totalquan) + parseInt(totalquanti[t]);
                    }
                    // console.log(totalquan);
                    $('.quanti').text(totalquan + ' Sản phẩm');
                    $('.pricetotal').text(moneyfomart(total)); 
                    $('input[name=totaltwo]').val(total);
                    $('.quantipush').val(totalquan);
                })  
                $('.tota').css('display','none');
                $('.totatwo').css('display','block');
    });

var count = @json($count);
var price = @json($total);
    $(document).ready(function(){
$("#selectall").change(function(){
  $(".checkbox1").prop('checked', $(this).prop("checked"));
  $('.quantione').text(Number(count) + ' Sản phẩm');
  $('.pricetotalone').text(moneyfomart(price)); 
  $('input[name=total]').val(price);
  });   
});


$("input[type=number]").click(function(){
var id = $('.valueid').val();
console.log(id);
$('#form1').attr('action','http://127.0.0.1:8000/customer/updatecart/' + id);
});
</script>
@endsection