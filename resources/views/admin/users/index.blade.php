@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
    <div class="card">

        @if (@session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
        @endif
        <h1>User List</h1>
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>
        </div>

        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
                @foreach ($users as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <th><img src="{{ $item->images->count() > 0 ? asset('upload/users/' . $item->images->first()->url) : 'upload/users/default.jpg' }}"
                                width="200px" height="200px" alt=""></th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                            <a href="{{ route('users.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('users.destroy', $item->id) }}" id="form-delete{{ $item->id }}"
                                method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-delete btn-danger" type="submit"
                                    data-id={{ $item->id }}>Delete</button>


                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $users->links() }}
        </div>




    </div>

@endsection
