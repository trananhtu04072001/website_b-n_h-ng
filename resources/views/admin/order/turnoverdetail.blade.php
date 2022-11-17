@extends('admin.layout.layout')
@section('title','Doanh thu theo tháng')
@section('css')
@stop
@section('content')
<div class="card-header">
    <i class="fas fa-table me-1"></i>
    @foreach ($detail as $val)
    @endforeach
    Danh sách Đơn hàng Tháng {{date('m',strtotime($val->created_at))}}
  </div>
<div class="card-body">
  <table id="datatablesorder" class="text-center">
      <thead class="text">
          <tr>
              <th>Khách hàng</th>
              <th>Số lượng</th>
              <th>Tổng tiền</th>
          </tr>
      </thead>
      <tbody>
          @forelse ($detail as $val)
              <tr>
                <td>{{$val->users->name}}</td>
                <td>{{$val->quantity}} Sản phẩm</td>
                <td>{{number_format($val->total, 0, ',', '.')}} VND</td>
              </tr>
          @empty
              <tr>
                <td>Trống</td>
              </tr>
          @endforelse
      </thead>
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