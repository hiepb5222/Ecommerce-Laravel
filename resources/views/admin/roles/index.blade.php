@extends('admin.layouts.app')
@section('title', 'Phân Quyền')
@section('content')
    @hasrole('super-admin')
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
            <h1>Nhóm Quyền</h1>
            <div>
                <a href="{{ route('roles.create') }}" class="btn btn-primary">Thêm Quyền Mới</a>
            </div>

            <div>
                <table class="table table-hover">
                    <tr>
                        <th>#</th>
                        <th>Tên Quyền</th>
                        <th>Tên Hiển Thị</th>
                        <th>Thao Tác</th>
                    </tr>
                    @foreach ($roles as $index => $role)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>
                                @hasrole('super-admin')
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Sửa</a>
                                    <form action="{{ route('roles.destroy', $role->id) }}" id="form-delete{{ $role->id }}"
                                        method="post" class="d-inline">
                                        @csrf
                                        @method('delete')

                                    </form>
                                    <button class='btn btn-delete btn btn-danger' data-id={{ $role->id }}>Xóa</button>
                                @endhasrole

                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $roles->links() }}
            </div>
        </div>
    @endsection

@endhasrole
