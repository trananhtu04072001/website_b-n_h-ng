@extends('admin.layout.layout')
@section('title','Sự kiện sản phẩm')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" 
rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
@stop
@section('content')
<a href="{{route('event.add')}}" class="nav-link">Thêm sự kiện sản phẩm</a>
<a href="{{route('add.event')}}" class="nav-link">Thêm sự kiện</a>
<div class="card-body">
  <table id="datatablesevent" class="text-center">
      <thead>
          <tr>
        <th>ID</th>
        <th>Sự kiện</th>
        <th>sản phẩm áp dụng</th>
        <th>Triết khấu</th>
        <th>Ngày bắt đầu</th>
        <th>Ngày kết thúc</th>
        <th>Trạng thái</th>
        <th>Cập nhật</th>
        <th colspan="2">Thao tác</th>
          </tr>
      </thead>
      <tbody>
        @forelse($data as $item)
        <tr class="text-center">
          <td>{{$item->id}}</td>
          <td>{{$item->event->name}}</td>
          <td>{{$item->product->name}}</td>
          <td>{{$item->discount}} %</td>
          <td>{{date('d-m-Y',strtotime($item->start))}}</td>
          <td>{{date('d-m-Y',strtotime($item->end))}}</td>
          <td>
                @if ($item->status == 1)
                <h6 href="" class="link-success">Đang áp dụng</h6>
                @else
                <h6 href="" class="link-danger">Đã đóng</h6>
                @endif
            </td>
            <td>
              <a href="{{ route('event.status',$item->id) }}" class="btn btn-primary">Cập nhật</a>
            </td>
          <td>
          <a href="{{ route('destroy.event',$item->id)}}"><button class="btn btn-primary">Xoá</button></a>
          </td>

        </tr>
     @empty
         <tr class="text-center">
          <td colspan="8">Danh sách rỗng</td>
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

    const datatablesSimple = document.getElementById('datatablesevent');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
});
</script>
@stop
