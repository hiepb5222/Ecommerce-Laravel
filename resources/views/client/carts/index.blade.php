@extends('client.layouts.app')
@section('title', 'cart')
@section('content')
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            @if (session('message'))
                <div class="row">
                    <h3 class="text-danger">{{ session('message') }}</h3>
                </div>
            @endif

            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Sale</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cart->products as $item)
                            <tr id="row-{{ $item->id }}">
                                <td class="align-middle"><img src="{{ $item->product->image_path }}" alt=""
                                        style="width: 50px;"> {{ $item->product->name }}</td>
                                <td class="align-middle">
                                    <p style="{{ $item->product->sale ? 'text-decoration: line-through' : '' }}";>
                                        ${{ $item->product->price }}
                                    </p>
                                    @if ($item->product->sale)
                                        <p>

                                            ${{ $item->product->sale_price }}
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
                                        <input type="number"
                                            class="form-control form-control-sm bg-secondary text-center p-0"
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
                                        id="cartProductPrice{{ $item->id }}">${{ $item->product->sale ? $item->product->sale_price * $item->product_quantity : $item->product->price * $item->product_quantity }}</span>

                                </td>


                                </td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-primary btn-remove-product"
                                        data-action="{{ route('client.carts.remove_product', $item->id) }}"
                                        data-token="{{ csrf_token() }}">
                                        <i class="fa fa-times"></i></button>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-5" action="">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium total-price" data-price="{{ $cart->total_price }}">
                                ${{ $cart->total_price }}</h6>
                        </div>

                        <button class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->




    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        $(function() {
            getTotalValue();

            function getTotalValue() {
                let total = $(".total-price").data("price");
                let couponPrice = $(".coupon-div")?.data("price") ?? 0;
                $(".total-price-all").text(`$${total - couponPrice}`);
            }

            $(document).on("click", ".btn-remove-product", function(e) {
                let url = $(this).data("action");
                confirmDelete()
                    .then(function() {
                        $.post(url, (res) => {
                            let cart = res.cart;
                            let cartProductId = res.product_cart_id;
                            $("#productCountCart").text(cart.product_count);
                            $(".total-price")
                                .text(`$${cart.total_price}`)
                                .data("price", cart.product_count);
                            $(`#row-${cartProductId}`).remove();
                            getTotalValue();
                        });
                    })
                    .catch(function() {});
            });

            $(document).on('click', '.btn-remove-product', function(e) {
                let url = $(this).data('action')
                let data = {
                        _token: '{{ csrf_token() }}'
                    };
                
                confirmDelete()
                    .then(function() {
                        $.post(url, data  // Gửi CSRF token trong dữ liệu yêu cầu
                        ,(res) => {
                            let cart = res.cart;
                            let cartProductId = res.product_cart_id;
                            $("#productCountCart").text(cart.product_count);
                            $(".total-price")
                                .text(`$${cart.total_price}`)
                                .data("price", cart.product_count);
                            $(`#row-${cartProductId}`).remove();

                        });
                    })
                    .catch(function() {});


            })

            const TIME_TO_UPDATE = 1000;

            $(document).on(
                "click",
                ".btn-update-quantity",
                _.debounce(function(e) {

                    let url = $(this).data("action");
                    let id = $(this).data("id");
                    let data = {
                        product_quantity: $(`#productQuantityInput-${id}`).val(),
                        _token: '{{ csrf_token() }}'
                    };
                    $.post(url, data, (res) => {
                        console.log(res);
                        let cartProductId = res.product_cart_id;
                        let cart = res.cart;

                        $("#productCountCart").text(cart.product_count);
                        if (res.remove_product) {
                            $(`#row-${cartProductId}`).remove();
                        } else {
                            $(`#cartProductPrice${cartProductId}`).html(
                                `$${res.cart_product_price}`
                            );
                        }
                        getTotalValue();
                        // cartProductPrice;

                        $(".total-price").text(`$${cart.total_price}`);
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "success",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    });
                }, TIME_TO_UPDATE)
            );
        });
    </script>
    </body>

    </html>
@endsection
