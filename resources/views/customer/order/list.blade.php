@extends('customer.layout.layout')
@section('title','Đơn hàng')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<style>
    .ordercus table {
        width: 1000px;
    }
    .ordercus {
        text-align: center;
    }
</style>
@stop
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <h2 class="text-center">Đơn hàng</h2>
    <br>
<div class="ordercus">
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Số lượng</th>
            <th>Ghi chú</th>
            <th>Trạng thái</th>
            <th>Cập nhật</th>
            <th colspan="2">Thao tác</th>
        </tr>
        @foreach ($order as $val)
        <tr>
                 <td>{{$val->id}}</td>
                <td>{{$val->quantity}} sản phẩm</td>
                <td>{{$val->des}}</td>
                <td class="status">
                    {{-- @if ($val->status == 0)
                    <a href="#" class="btn btn-danger">Đã huỷ</a>
                    @endif --}}
                    @if ($val->status == 1)
                    <h6 class="link-warning">Chờ xác nhận</h6>
                    @endif
                    @if ($val->status == 2)
                    <h6 class="link-secondary">Đã xác nhận</h6>
                    @endif
                    @if ($val->status == 3)
                    <h6 class="link-secondary">Đang chuẩn bị hàng</h6>
                    @endif
                    @if ($val->status == 4)
                    <h6 class="link-secondary">Đã Giao cho shipper</h6>
                    @endif
                    @if ($val->status == 5)
                    <h6 class="link-success">Chờ xác nhận đã nhận hàng</h6>
                    @endif
                    {{-- @if ($val->status == 6)
                    <h6 class="btn btn-success">Đơn hàng thành công</h6>
                    <a href="#" class="btn btn-success">Mua lại</a>
                    @endif --}}
                </td>
                <td>
                    @if ($val->status == 0)
                    <a href="{{route('order.status',$val->id)}}" class="btn btn-success">Đặt lại</a>
                    @endif
                    @if ($val->status == 1)
                    <a href="{{route('order.status',$val->id)}}" class="btn btn-secondary">Huỷ đơn hàng</a>
                    @endif
                    @if ($val->status == 5)
                    <a href="{{route('order.status',$val->id)}}" class="btn btn-success">Xác nhận đã nhận hàng</a>
                    <a href="{{route('order.reorder',$val->id)}}" class="btn btn-secondary reorder" data-id="{{$val->id}}" data-bs-toggle="modal" data-bs-target="#staticBackdroptwo">Trả lại hàng</a>
                    @endif
                    @if ($val->status == 7)
                       <a href="#" class="btn btn-secondary">Đơn hàng đã hoàng trả</a>
                    @endif
                </td>
                {{-- <td>
                    @if($val->status == 1)
                        <a href="{{route('order.status',$val->id)}}" class="btn btn-secondary">Huỷ đơn hàng</a>
                    @endif
                </td> --}}
                <td>
                    <button class="btn btn-info order_detail" data-id="{{$val->id}}" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Chi tiết</button>
                </td>
        </tr>
        @endforeach
    </table>

  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="staticBackdropLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="order_detail"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
        </div>
      </div>
    </div>
  </div>


    <div class="modal fade" id="staticBackdroptwo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="push" action="" method="GET">
                @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="staticBackdropLabeltwo"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="re_order"> </div>
                    <select name="ship_id">
                        <option value="0" selected>Chọn đơn vị vận chuyển</option>
                        <option value="1">GHTK</option>
                        <option value="2">EXPRESS</option>
                        <option value="3">Hoả Tốc</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">Trả hàng</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
 integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}
<script>
   $('.order_detail').click(function(){
        // window.location.reload();
        var id = $(this).attr('data-id');
            $.ajax({
               type :'GET',
               url  : '/customer/orderdetail/'+id,
            //    data : {
            //    },
               success:function(data){
                   console.log(data);
                //    window.stop();
                //    window.location.reload();
                   if(data){
                    let htm = '';
                    $('#staticBackdropLabel').text('Thông tin đơn hàng số:'+ data[0].order_id);
                    // htm += '<h2 class="text-center">Thông tin đơn hàng</h2>'
                    htm += '<div class="text-center">';
                    htm += data[0].receiver['name'] + '<br>';
                    htm += data[0].receiver['email'] + '<br>';
                    htm += data[0].receiver['phone'] + '<br>';
                    htm += data[0].receiver['address'] + '<br>';
                    data.forEach(element => {
                        htm += '<img src="' + 'http://127.0.0.1:8000/' + element.product['image'] + '" alt="error" style="width:100px">';
                        htm += '<p> ' + element.product['name'] + ' </p>';
                        htm += '<p> ' + moneyfomart(element.product['price']) + ' VND</p>';
                        htm += '<p>Màu sắc: ' + element.color + '</p>';
                        htm += '<p>Kích thước: ' + element.size + '</p>';
                        htm += '<p>Số lượng: ' + element.single_quantity + '</p>';


                    });
                    htm += '<p>Vận chuyển: ' + data[0].ship['name'] + '-' + moneyfomart(data[0].ship['price']) + ' VND<br>';
                    htm += '<p>Phương thức thanh toán: ' + data[0].payment['method'] + '<br>';
                    htm += '<p>Tổng số lượng: ' + data[0].order['quantity'] + '<br>';
                    htm += '<p>Tổng giá tiền: ' + moneyfomart(data[0].total) + ' VND<br>';
                    htm += '</div>';
                       $('#order_detail').html(htm);
                   }else{
                        alert("Đơn hàng trống");
                        window.stop();
                   }
               }
            });

        }
        );
        function moneyfomart(value) {
            var number = new Intl.NumberFormat('vi-VN').format(value);
    return number;
   }
</script>
    <script>
        $('.reorder').click(function(){
                // window.location.reload();
                var id = $(this).attr('data-id');
                $.ajax({
                    type :'GET',
                    url  : '/customer/reorder/'+id,
                    //    data : {
                    //    },
                    success:function(data){
                        console.log(data);
                        //    window.stop();
                        //    window.location.reload();
                        if(data){
                            let htm = '';
                            $('#push').attr('action','http://127.0.0.1:8000/customer/reorderpush/'+ data[0].order_id);
                            $('#staticBackdropLabeltwo').text('Thông tin đơn hàng số:'+ data[0].order_id);
                            htm += '<div class="text-center">';
                            data.forEach(element => {
                                htm += '<img src="' + 'http://127.0.0.1:8000/' + element.product['image'] + '" alt="error" style="width:100px">';
                                htm += '<p> ' + element.product['name'] + ' </p>';
                                htm += '<p> ' + moneyfomart(element.product['price']) + ' VND</p>';
                                htm += '<p>Số lượng: ' + element.single_quantity + '</p>';
                                htm += '<input type="hidden" name="quanti" value="' + element.single_quantity +'"/>';
                                // htm += 'Số lượng trả :<input type="text" name="quantity"/></br>';
                                htm += '<input type="checkbox" id="' + element.product['name'] + '" value="' + element.product['id'] + '" name="product"><label for="'+ element.product['name'] + '">Trả hàng</label><br><br>';
                            });

                            htm += '<label>Lí do: <label/></br></br>';
                            htm += '<textarea rows="5" cols="20" name="des"></textarea>';
                            htm += '</div>';
                            $('#re_order').html(htm);
                        }else{
                            alert("Đơn hàng trống");
                            window.stop();
                        }
                    }
                });

            }
        );
        function moneyfomart(value) {
            var number = new Intl.NumberFormat('vi-VN').format(value);
            return number;
        }
    </script>
@endsection
