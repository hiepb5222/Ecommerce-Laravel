@extends('admin.layouts.app')
@section('title', 'Sản Phẩm')
@section('content')
    <div class="card">

        @if (session('message'))
            <div class="position-fixed top-0 end-0 p-3 z-index-2" style="z-index: 1050;">
                <div class="toast fade show bg-success text-white" role="alert" aria-live="assertive" id="toastMessage"
                    aria-atomic="true">
                    <div class="toast-header border-0 bg-success text-white">
                        <i class="material-icons text-white me-2">check</i>
                        <span class="me-auto font-weight-bold">Thông báo</span>
                        <small class="text-white">Vừa xong</small>
                        <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
                    </div>
                    <hr class="horizontal light m-0">
                    <div class="toast-body">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        @endif
        <h1>Danh Sách Sản Phẩm</h1>
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Thêm Sản Phẩm</a>
            </div>
            <div class="col-md-5">
                <form action="{{ route('products.index') }}" method="GET" id="search-form">
                    <div class="d-flex align-items-center">
                        <div class="input-group input-group-outline flex-grow-1"> 
                            <label class="form-label">Tìm kiếm sản phẩm</label>
                            <input type="text" name="keyword" id="search-input" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                    </div>
                </form>
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
                            <td>{{ $index + 1 }}</td>
                            <th><img src="{{ $item->image_path }}" width="200px" height="200px" alt=""></th>
                            <td>{{ $item->name }}</td>
                            <td>{{ number_format($item->price) }} VND</td>
                            <td>{{ $item->sale }}%</td>
                            <td>
                                @can('show-product')
                                    <a href="{{ route('products.show', $item->slug) }}" class="btn btn-info">Xem</a>
                                @endcan

                                @can('update-product')
                                    <a href="{{ route('products.edit', $item->id) }}" class="btn btn-warning">Sửa</a>
                                @endcan

                                @can('delete-product')
                                    <form action="{{ route('products.destroy', $item->id) }}"
                                        id="form-delete{{ $item->id }}" method="post" class="d-inline">
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
