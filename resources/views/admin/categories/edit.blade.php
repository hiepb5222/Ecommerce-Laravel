@extends('admin.layouts.app')
@section('title', ' Edit Category' . $category->name)
@section('content')
    <div class="card">
        <h1>Edit Category</h1>
        <div>
            <form action="{{ route('categories.update', $category->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') ?? $category->name }}" class="form-control">

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @if ($category->childrens->count() < 1)
                    <div class="input-group input-group-static mb-4">
                        <label for="exampleFormControlSelect1" class="ms-0">Parent Category</label>
                        <select class="form-control" name="parent_id">
                            <option value="">Select Parent Category</option>
                            @foreach ($parentCategories as $item)
                                <option value="{{ $item->id }}"
                                    {{ (old('parent_id') ?? $category->parent_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>

                        @error('parent_ids')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
                <button type="submit" class="btn btn-submit btn btn-primary"> Submit</button>
            </form>
        </div>
    </div>
@endsection
