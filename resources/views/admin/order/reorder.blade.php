@extends('admin.layout.layout')
@section('title','Đơn hàng hoàn trả')
@section('css')
<style>
    #datatablesreorder {
        width: 1050px;
    }
</style>
@stop
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <br>
    <h2 class="text-center">Đơn hàng hoàn trả</h2>
    <div class="card-body">
        <table id="datatablesreorder" class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Sản phẩm</th>
                <th>người trả</th>
                <th>Đơn vị vận chuyển</th>
                <th>Lí do</th>
                <th>Trạng thái</th>
                <th>Cập nhật</th>
                <th>Chi tiết</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($data as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->product->name}}</td>
                    <td>{{$order->user->name}}</td>
                    <td>{{$order->ship->name}}
                        {{number_format($order->ship->price, 0, ',', '.')}} VND</td>
                    <td>{{$order->des}}</td>
                    <td>
                        @if ($order->status == 1)
                            <h6 href="#" class="link-warning">Đơn hàng hoàn trả</h6>
                        @endif
                        @if ($order->status == 2)
                            <h6 class="link-secondary">Đã xác nhận đơn</h6>
                        @endif
                        @if ($order->status == 3)
                            <h6 class="link-secondary">Shipper lấy hàng</h6>
                        @endif
                        @if ($order->status == 4)
                        <h6 class="link-success">Hoàn trả thành công</h6>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('admin.reorderstatus',$order->id)}}" class="btn btn-primary">Cập nhật</a>
                    </td>
                    <td>
                        <button class="btn btn-info order_detail" data-id="{{$order->order->id}}" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Chi tiết</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Danh sách rỗng</td>
                </tr>
            @endforelse
            </tbody>
        </table>
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
    </div>
@endsection
@section('js')
    {{-- <script>
        window.addEventListener('DOMContentLoaded', event => {
            // Simple-DataTables
            // https://github.com/fiduswriter/Simple-DataTables/wiki

            const datatablesSimple = document.getElementById('datatablesreorder');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });
    </script> --}}
    <script>
         $('.order_detail').click(function(){
        // window.location.reload();
        var id = $(this).attr('data-id');
            $.ajax({
               type :'GET',
               url  : '/admin/reorderdetail/'+id,
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
                        // htm += '<p> ' + number_format("+element.product['price']+", 0, ',', '.') + ' </p>';
                        htm += '<p> ' + moneyfomart(element.product['price']) + ' VND</p>';
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
     {{-- <script>
        window.addEventListener('DOMContentLoaded', event => {
            // Simple-DataTables
            // https://github.com/fiduswriter/Simple-DataTables/wiki

            const datatablesSimple = document.getElementById('datatablesreorder');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });
    </script> --}}
@endsection
