<div class="container-fluid">
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
                        placeholder="Tìm kiếm sản phẩm" autocomplete="off">
                    <div class="input-group-append">
                        <button class="input-group-text bg-transparent text-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div id="autocomplete-results"
                    style="position: absolute; background-color: white; border: 1px solid #ddd; max-height: 200px; overflow-y: auto; z-index: 1000; padding: 0;">
                    <ul style="list-style: none; margin: 0; padding: 0;"></ul>
                </div>
            </form>
        </div>

        <div class="col-lg-3 col-6 text-right">
            <a href="{{ route('client.carts.index') }}" class="btn border">
                <i class="fas fa-shopping-cart text-primary"></i>
                <span class="badge" id="productCountCart">Giỏ Hàng {{ $countProductInCart }}</span>
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
                        let results = $('#autocomplete-results ul');
                        results.empty();
                        if (data.length > 0) {
                            data.forEach(function(product) {
                                results.append(
                                    '<li style="padding: 8px; border-bottom: 1px solid #eaeaea;"><a href="/product-detail/' +
                                    product.slug + '" style="text-decoration: none; color: #333; display: block;">' +
                                    product.name + '</a></li>');
                            });
                        } else {
                            results.append(
                                '<li class="autocomplete-item disabled" style="padding: 8px; color: #999;">No results found</li>'
                            );
                        }
                    }
                });
            } else {
                $('#autocomplete-results ul').empty();
            }
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('#autocomplete-results, #search-input').length) {
                $('#autocomplete-results ul').empty();
            }
        });
    });
</script>
@endsection

