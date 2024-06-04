@extends('admin.layouts.app')
@section('title', 'Coupons')
@section('content')
    <div class="card">

        @if (@session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
        @endif
        <h1>Coupon List</h1>
        <div>
            <a href="{{ route('coupons.create') }}" class="btn btn-primary">Create Coupon</a>
        </div>

        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Expiry Date</th>
                    <th>Action</th>
                </tr>
                @foreach ($coupons as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->expiry_date }}</td>
                        <td>
                            @can('update-coupon')
                                <a href="{{ route('coupons.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            @endcan
                            
                            @can('delete-coupon')
                                <form action="{{ route('coupons.destroy', $item->id) }} " id="form-delete{{ $item->id }}"
                                    method="post">
                                    @csrf
                                    @method('delete')

                                </form>
                                <button class='btn btn-delete btn btn-danger' data-id={{ $item->id }}>Delete</button>
                            @endcan

                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $coupons->links() }}
        </div>
    </div>
@endsection
