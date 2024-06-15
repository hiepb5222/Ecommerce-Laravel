@extends('client.layouts.app')
@section('title', 'Cart')
@section('content')
    <!-- Cart Start -->
    @if (session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('message') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            });
        </script>
    @endif
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Đơn Giá</th>
                        <th>Size</th>
                        <th>Khuyến Mãi (%)</th>
                        <th>Số Lượng</th>
                        <th>Tổng </th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach ($cart->products as $item)
                        <tr id="row-{{ $item->id }}">
                            <td class="align-middle"><img src="{{ $item->product->image_path }}" alt=""
                                    style="width: 50px;"> {{ $item->product->name }}</td>
                            <td class="align-middle">
                                <p style="{{ $item->product->sale ? 'text-decoration: line-through' : '' }}";>
                                    {{ $item->product->price }} VND
                                </p>
                                @if ($item->product->sale)
                                    <p>

                                        {{ $item->product->sale_price }} VND
                                    </p>
                                @endif
                            </td>
                            <td class="align-middle">{{ $item->product_size }}</td>
                            <td class="align-middle">{{ $item->product->sale }}</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus btn-update-quantity"
                                            data-action="{{ route('client.carts.update_product_quantity', $item->id) }}"
                                            data-id="{{ $item->id }}">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="number" class="form-control form-control-sm bg-secondary text-center p-0"
                                        id="productQuantityInput-{{ $item->id }}" min="1"
                                        value="{{ $item->product_quantity }}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus btn-update-quantity"
                                            data-action="{{ route('client.carts.update_product_quantity', $item->id) }}"
                                            data-id="{{ $item->id }}">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td class="align-middle">
                                <span
                                    id="cartProductPrice{{ $item->id }}">{{ $item->product->sale ? $item->product->sale_price * $item->product_quantity : $item->product->price * $item->product_quantity }}
                                    VND</span>

                            </td>


                            </td>
                            <td class="align-middle">
                                <button class="btn btn-sm btn-primary btn-remove-product"
                                    data-action="{{ route('client.carts.remove_product', $item->id) }}">
                                    <i class="fa fa-times"></i></button>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <form class="mb-5" action=" {{ route('client.carts.apply_coupon') }}" method="POST">
                @csrf

                <div class="input-group">
                    <input type="text" class="form-control p-4" name="coupon_name" placeholder="Nhập Mã Giảm Giá">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Xác Nhận</button>
                    </div>
                </div>
            </form>
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Tổng Đơn Hàng</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Giá tạm thời</h6>
                        <h6 class="font-weight-medium total-price" data-price="{{ $cart->total_price }}">
                            ${{ $cart->total_price }}</h6>
                    </div>

                    @if (session('discount_amount_price'))
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Giảm Giá </h6>
                            <h6 class="font-weight-medium coupon-div" data-price="{{ session('discount_amount_price') }}">
                                ${{ session('discount_amount_price') }}</h6>
                        </div>
                    @endif
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Tổng</h5>
                        <h5 class="font-weight-bold total-price-all"></h5>
                    </div>
                    <a href="{{ route('client.checkout.index') }}" class="btn btn-block btn-primary my-3 py-3">Xác Nhận
                        Thanh Toán</a>
                </div>


            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('client/cart/cart.js') }}"></script>
@endsection
