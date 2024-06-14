@extends('admin.layouts.app')
@section('title', 'Danh Mục')
@section('content')
    <div class="card">

        @if (@session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
        @endif
        <h1>Danh sách danh mục</h1>
        <div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Tạo Danh mục mới</a>
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
