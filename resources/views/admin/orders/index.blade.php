@extends('admin.layouts.app')
@section('title', 'Đơn hàng')
@section('content')

    <div class="card">

        <h1>
            Đơn Hàng
        </h1>
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
    {{-- <script>
        $(function() {
            $(document).on("change", ".select-status", function(e) {
                e.preventDefault();
                let url = $(this).data("action");
                let data = {
                    status: $(this).val(),
                    _token: '{{ csrf_token() }}'
                };
                $.post(url, data, (res) => {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "success",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                });
            });
        });
    </script> --}}
@endsection
