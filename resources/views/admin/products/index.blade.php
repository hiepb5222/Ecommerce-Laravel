@extends('admin.layouts.app')
@section('title', 'Sản Phẩm')
@section('content')
    <div class="card">

        @if (@session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
        @endif
        <h1>Danh Sách Sản Phẩm</h1>
        <div>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Thêm Sản Phẩm</a>
        </div>

        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Ảnh Sản Phẩm</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá Sản Phẩm</th>
                    <th>Khuyến Mãi (%)</th>
                    <th>Thao Tác</th>
                </tr>
                @foreach ($products as $index => $item)
                    <tr>
                        <td>{{ $index +1 }}</td>
                        <th><img src="{{ $item->image_path }}"
                                width="200px" height="200px" alt=""></th>
                        <td>{{ $item->name }}</td>
                        <td>{{ number_format($item->price) }} VND</td>
                        <td>{{ $item->sale }}%</td>
                        <td>
                            @can('show-product')
                                <a href="{{ route('products.show',  $item->slug) }}" class="btn btn-info">Xem</a>
                            @endcan

                            @can('update-product')
                                <a href="{{ route('products.edit', $item->id) }}" class="btn btn-warning">Sửa</a>
                            @endcan

                            @can('delete-product')
                                <form action="{{ route('products.destroy', $item->id) }}" id="form-delete{{ $item->id }}"
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
            {{ $products->links() }}
        </div>
    </div>

@endsection
