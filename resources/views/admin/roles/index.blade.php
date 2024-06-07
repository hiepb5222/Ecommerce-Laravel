@extends('admin.layouts.app')
@section('title', 'Roles')
@section('content')
    <div class="card">

        @if (@session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
        @endif
        <h1>Role List</h1>
        <div>
            <a href="{{ route('roles.create') }}" class="btn btn-primary">Create Role</a>
        </div>

        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>DisplayName</th>
                    <th>Action</th>
                </tr>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->display_name }}</td>
                        <td>
                            @can('super-admin')
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('roles.destroy', $role->id) }}" id="form-delete{{ $role->id }}"
                                    method="post" class="d-inline">
                                    @csrf
                                    @method('delete')

                                </form>
                                <button class='btn btn-delete btn btn-danger' data-id={{ $role->id }}>Delete</button>
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
