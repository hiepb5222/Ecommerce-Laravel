@extends('admin.layouts.app')
@section('title', 'Danh Mục')
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
        <h1>Danh sách danh mục</h1>
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="{{ route('categories.create') }}" class="btn btn-primary">Tạo Danh mục mới</a>
            </div>
            <div class="col-md-5">
                <form action="{{ route('categories.index') }}" method="GET" id="search-form">
                    <div class="d-flex align-items-center">
                        <div class="input-group input-group-outline flex-grow-1">
                            <label class="form-label">Tìm kiếm tên danh mục</label>
                            <input type="text" name="keyword" id="search-input" class="form-control"
                                onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Tên Danh Mục</th>
                    <th>Danh Mục Cha</th>
                    <th>Thao Tác</th>
                </tr>
                @foreach ($categories as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->parent_name }}</td>
                        <td>

                            @can('update-category')
                                <a href="{{ route('categories.edit', $item->id) }}" class="btn btn-warning">Sửa</a>
                            @endcan

                            @can('delete-category')
                                <form action="{{ route('categories.destroy', $item->id) }} " id="form-delete{{ $item->id }}"
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
            {{ $categories->links() }}
        </div>
    </div>
@endsection
