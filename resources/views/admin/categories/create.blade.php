@extends('admin.layouts.app')
@section('title', ' Tạo Danh Mục')
@section('content')
    <div class="card">
        <h1>Tạo Danh Mục Mới</h1>
        <div>
            <form action="{{ route('categories.store') }}" method="post">
                @csrf
                <div class="input-group input-group-static mb-4">
                    <label>Tên Danh Mục</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Danh Mục Cha</label>
                    <select class="form-control" name="parent_id">
                        <option value="">Chọn Danh Mục Cha</option>
                        @foreach ($parentCategories as $item)
                            <option value="{{ $item->id }}" {{ old('parent_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>

                    @error('parent_ids')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-submit btn btn-primary"> Thêm Mới</button>
            </form>
        </div>
    </div>
@endsection
