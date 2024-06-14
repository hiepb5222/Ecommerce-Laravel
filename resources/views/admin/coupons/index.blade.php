@extends('admin.layouts.app')
@section('title', 'Phiếu Giảm Giá')
@section('content')
    <div class="card">

        @if (@session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
        @endif
        <h1>Danh sách phiếu giảm giá</h1>
        <div>
            <a href="{{ route('coupons.create') }}" class="btn btn-primary">Tạo phiếu giảm giá</a>
        </div>

        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Mã Giảm Giá</th>
                    <th>Thể Loại</th>
                    <th>Giá Trị</th>
                    <th>Hạn Sử Dụng</th>
                    <th>Thao Tác</th>
                </tr>
                @foreach ($coupons as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->expiry_date }}</td>
                        <td>
                            @can('update-coupon')
                                <a href="{{ route('coupons.edit', $item->id) }}" class="btn btn-warning">Sửa</a>
                            @endcan
                            
                            @can('delete-coupon')
                                <form action="{{ route('coupons.destroy', $item->id) }} " id="form-delete{{ $item->id }}"
                                    method="post" class="d-inline">
                                    @csrf
                                    @method('delete')

                                </form>
                                <button class='btn btn-delete btn btn-danger' data-id={{ $item->id }}>Xóa</button>
                            @endcan

                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $coupons->links() }}
        </div>
    </div>
@endsection
