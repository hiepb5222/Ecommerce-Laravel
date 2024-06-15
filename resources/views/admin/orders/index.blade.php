@extends('admin.layouts.app')
@section('title', 'Đơn hàng')
@section('content')
@can('list-order')
    <div class="card">
        <div class="row mb-3">
        <h1>
            Đơn Hàng
        </h1>
        
        <div class="col-md-5">
            <form action="{{ route('admin.orders.index') }}" method="GET" id="search-form">
                <div class="d-flex align-items-center">
                    <div class="input-group input-group-outline flex-grow-1"> 
                        <label class="form-label">Tìm kiếm tên khách hàng</label>
                        <input type="text" name="keyword" id="search-input" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>
                </div>
            </form>
        </div>
    </div>
        <div class="container-fluid pt-5">

            <div class="col card">
                <div>
                    <table class="table table-hover">
                        <tr>
                            <th>#</th>
                            <th>Trạng Thái</th>
                            <th>Tổng Tiền</th>
                            <th>Tiền Ship</th>
                            <th>Tên Khách Hàng</th>
                            <th>Email Khách Hàng</th>
                            <th>Địa Chỉ Khách Hàng</th>
                            <th>Ghi Chú</th>
                            <th>Thanh Toán</th>
                        </tr>

                        @foreach ($orders as $index => $item)
                            <tr>
                                <td>{{ $index +1 }}</td>
                                <td>

                                    <div class="input-group input-group-static mb-4">
                                        <select name="status" class="form-control select-status"
                                            data-action="{{ route('admin.orders.update_status', $item->id) }}">
                                            @foreach (config('order.status') as $status)
                                                <option value="{{ $status }}"
                                                    {{ $status == $item->status ? 'selected' : '' }}>{{ $status }}
                                                </option>
                                            @endforeach
                                        </select>

                                </td>
                                <td>${{ $item->total }}</td>

                                <td>${{ $item->ship }}</td>
                                <td>{{ $item->customer_name }}</td>
                                <td>{{ $item->customer_email }}</td>

                                <td>{{ $item->customer_address }}</td>
                                <td>{{ $item->note }}</td>
                                <td>{{ $item->payment }}</td>

                            </tr>
                        @endforeach
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin/assets/order/order.js')}}"></script>
@endsection
@endcan
