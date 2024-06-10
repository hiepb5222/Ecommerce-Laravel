<div class="container-fluid">
    <div class="row bg-secondary py-2 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark" href="">FAQs</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Help</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Support</a>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark px-2" href="">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="text-dark px-2" href="">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-dark pl-2" href="">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-semi-bold"><span
                        class="text-primary font-weight-bold border px-3 mr-1">HQH</span>Shopper</h1>
            </a>
        </div>
        <div class="col-lg-6 col-6 text-left" style="position:relative">
            <form action="{{ route('client.product.index') }}" method="GET" id="search-form">
                <div class="input-group">
                    <input type="text" name="keyword" id="search-input" class="form-control"
                        placeholder="Search for products" autocomplete="off">
                    <div class="input-group-append">
                        <button class="input-group-text bg-transparent text-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div id="autocomplete-results"
                    style=" position: absolute;background-color: white; border: 1px solid #ddd;max-height: 200px;overflow-y: auto; z-index: 1000;">
                </div>
            </form>
        </div>

        <div class="col-lg-3 col-6 text-right">
            <a href="{{ route('client.carts.index') }}" class="btn border">
                <i class="fas fa-shopping-cart text-primary"></i>
                <span class="badge" id="productCountCart">{{ $countProductInCart }}</span>
            </a>
        </div>
    </div>
</div>

@section('script')
    <script>
        $(document).ready(function() {
            $('#search-input').on('input', function() {
                let keyword = $(this).val();
                if (keyword.length > 0) {
                    $.ajax({
                        url: "{{ route('client.products.autocomplete') }}",
                        type: "GET",
                        data: {
                            keyword: keyword
                        },
                        success: function(data) {
                            let results = $('#autocomplete-results');
                            results.empty();
                            if (data.length > 0) {
                                data.forEach(function(product) {
                                    results.append(
                                        '<div><a href="/product-detail/' +
                                        product.slug + '">' + product.name +
                                        '</a></div>');
                                });
                                if (data.length > 5) {
                                    results.append('<div class="read-more">Read more...</div>');
                                }
                            } else {
                                results.append(
                                    '<div class="autocomplete-item disabled">No results found</div>'
                                );
                            }
                        }
                    });
                } else {
                    $('#autocomplete-results').empty();
                }
            });

            // Hide autocomplete when clicking outside
            // $(document).click(function(e) {
            //     if (!$(e.target).closest('#autocomplete-results, #search-input').length) {
            //         $('#autocomplete-results').empty();
            //     }
            // });
        });
    </script>
@endsection
