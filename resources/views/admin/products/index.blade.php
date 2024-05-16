@extends('admin.layouts.app')
@section('title', 'Products')
@section('content')
    <div class="card">

        @if (@session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
        @endif
        <h1>Product List</h1>
        <div>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Create Product</a>
        </div>

        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Sale</th>
                    <th>Action</th>
                </tr>
                @foreach ($products as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <th><img src="{{ $item->images->count() > 0 ? asset('upload/' . $item->images->first()->url) : 'upload/default.jpg' }}"
                                width="200px" height="200px" alt=""></th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->sale }}</td>
                        <td>
                            <a href="{{ route('products.show', $item->id) }}" class="btn btn-info">Show</a>
                            <a href="{{ route('products.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $item->id) }}" id="form-delete{{ $item->id }}"
                                method="post">
                                @csrf
                                @method('delete')

                            </form>
                            <button class='btn btn-delete btn btn-danger' data-id={{ $item->id }}>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $products->links() }}
        </div>
    </div>

@endsection

