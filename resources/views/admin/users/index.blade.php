@extends('admin.layouts.app')
@section('title', 'Người Dùng')
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


        <h1>Danh Sách Người Dùng</h1>
        <div class="row mb-3">
        <div class="col-md-6">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Thêm Người Dùng</a>
        </div>
        <div class="col-md-5">
            <form action="{{ route('users.index') }}" method="GET" id="search-form">
                <div class="d-flex align-items-center">
                    <div class="input-group input-group-outline flex-grow-1"> 
                        <label class="form-label">Tìm kiếm tên người dùng</label>
                        <input type="text" name="keyword" id="search-input" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>
                </div>
            </form>
        </div>
    </div>

        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Ảnh Người Dùng</th>
                    <th>Tên Người Dùng</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Thao Tác</th>
                </tr>
                @foreach ($users as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <th><img src="{{ $item->image_path }}" width="200px" height="200px" alt=""></th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                            @can('update-user')
                                <a href="{{ route('users.edit', $item->id) }}" class="btn btn-warning">Sửa</a>
                            @endcan

                            @can('delete-user')
                                <form action="{{ route('users.destroy', $item->id) }}" id="form-delete{{ $item->id }}"
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
            {{ $users->links() }}
        </div>
    </div>

@endsection
