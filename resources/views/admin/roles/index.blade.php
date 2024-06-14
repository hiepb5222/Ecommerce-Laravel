@extends('admin.layouts.app')
@section('title', 'Phân Quyền')
@section('content')
    <div class="card">

        @if (@session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
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
                            @can('super-admin')
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Sửa</a>
                                <form action="{{ route('roles.destroy', $role->id) }}" id="form-delete{{ $role->id }}"
                                    method="post" class="d-inline">
                                    @csrf
                                    @method('delete')

                                </form>
                                <button class='btn btn-delete btn btn-danger' data-id={{ $role->id }}>Xóa</button>
                            @endcan

                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $roles->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection
