@extends('admin.layout.layout')
@section('title','Tài khoản khách hàng')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" 
rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
@stop
@section('content')
<div class="card mb-4">
  <div class="card-header">
      <i class="fas fa-table me-1"></i>
      Danh sách khách hàng:
  </div>
  <div class="card-body">
      <table id="datatablesSimple">
          <thead>
              <tr>
                  <th>Tên</th>
                  <th>Địa chỉ</th>
                  <th>Email</th>
                  <th>Số điện thoại</th>
                  <th>Hoạt động</th>
                  <th>Cập nhật</th>
                  <th>Thao tác</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($data as $user)
              <tr>
                  <td>{{$user->name}}</td>
                  <td>{{$user->address}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone}}</td>
                  <td> @if ($user->active == 1)
                      <h6 class="link-success">Đang hoạt động</h6>
                      @else
                      <h6 class="link-danger">Đã khoá tài khoản</h6>
                      @endif
                  </td>
                      <td>
                          <a href="{{route('active.cus',$user->id)}}" class="btn btn-primary">Cập nhật</a>
                      </td>
                      <td>
                        <a href="{{ route('delete.cus',$user->id)}}"><button class="btn btn-primary">Xoá</button></a>
                      </td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
</div>
@endsection
@section('js')
@stop