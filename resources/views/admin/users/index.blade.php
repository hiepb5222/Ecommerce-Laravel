@extends('admin.layouts.app')
@section('title', 'Người Dùng')
@section('content')
    <div class="card">

        @if (@session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
        @endif
        <h1>Danh Sách Người Dùng</h1>
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Thêm Người Dùng</a>
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
                        <td>{{ $index +1 }}</td>
                        <th><img src="{{ $item->image_path}}"
                                width="200px" height="200px" alt=""></th>
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
