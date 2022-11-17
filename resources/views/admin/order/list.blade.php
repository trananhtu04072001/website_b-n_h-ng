@extends('admin.layout.layout')
@section('title','Đơn hàng')
@section('css')
@stop
@section('content')
@if (session('success'))
<div class="alert alert-success">
      <p>{{ session('success') }}</p>
</div>
@endif
<div class="card-header">
  <i class="fas fa-table me-1"></i>
  Danh sách Đơn hàng:
</div>
<div class="card-body">
  <table id="datatablesorder" class="text-center">
      <thead>
          <tr>
              <th>ID</th>
              <th>Tên</th>
              <th>Số lượng</th>
              <th>Tổng tiền</th>
              <th>Ghi chú</th>
              <th>Trạng thái</th>
              <th>Cập nhật</th>
              <th colspan="2">Thao tác</th>
          </tr>
      </thead>
      <tbody>
          @forelse ($data as $order)
          <tr>
              <td>{{$order->id}}</td>
              <td>{{$order->users->name}}</td>
              <td>{{$order->quantity}} sản phẩm</td>
              <td>{{number_format($order->total, 0, ',', '.')}} VND</td>
              <td>{{$order->des}}</td>
              <td>
                @if ($order->status == 0)
                <h6 class="link-danger">Đơn hàng đã huỷ</h6>
                @endif
                @if ($order->status == 1)
                <h6 class="link-warning">xác nhận đơn</h6>
                @endif
                @if ($order->status == 2)
                <h6 class="link-secondary">Đã xác nhận</h6>
                @endif
                @if ($order->status == 3)
                <h6 class="link-secondary">Đang chuẩn bị hàng</h6>
                @endif
                @if ($order->status == 4)
                <h6 class="link-secondary">Đã giao cho shipper</h6>
                @endif
                @if ($order->status == 5)
                <h6 class="link-secondary">Xác nhận đã nhận hàng</h6>
                @endif
                @if ($order->status == 6)
                <h6 class="link-success">Đơn hàng thành công</h6>
                @endif
                {{-- @if ($order->status == 7)
                <a href="#" class="btn btn-success">Đơn hàng thành công</a>
                @endif --}}
              </td>
              <td>
                <a href="{{route('admin.order.status',$order->id)}}" class="btn btn-primary">Cập nhật</a>
              </td>
                <td>
                  {{-- <a href="{{ route('admin.detail_order',$order->id)}}"><button class="btn btn-primary">Chi tiết</button></a> --}}
                  <a href="{{ route('admin.detail_order',$order->id)}}"><i class="fa-solid fa-eye"></i></a>
                </td>
          </tr>
          @empty
          <tr>
            <td colspan="6">Danh sách rỗng</td>
          </tr>
          @endforelse
      </tbody>
  </table>
</div>
@endsection
@section('js')
<script>
  window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesorder');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
});
</script>
@stop