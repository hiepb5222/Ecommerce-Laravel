<!-- Page Header Start -->
@extends('client.layouts.app')
@section('title', 'Products')
@section('content')
    <div class="row ">
        <div class="d-inline-flex" style="margin-left:40px">
            <p class="m-0"><a href="">Trang chủ</a></p>
            <p class="m-0 px-2">/</p>
            <p class="m-0">Shop</p>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Lọc theo danh mục</h5>
                    <form action="" method="GET">
                        @foreach ($categories as $category)
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="categories[]" id="category-{{ $category->id }}"
                                value="{{ $category->id }}">
                            <label class="custom-control-label"
                                for="category-{{ $category->id }}">{{ $category->name }}</label>
                            <!-- Replace with actual badge content related to each category -->
                            <span class="badge border font-weight-normal">{{ $category->count }}</span>
                        </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </form>
                </div>
                <!-- Price End -->

                <!-- Color Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Lọc theo giá</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-1">
                            <label class="custom-control-label" for="price-1">Dưới 200k</label>
                            {{-- <span class="badge border font-weight-normal">150</span> --}}
                        </div>

                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-2">
                            <label class="custom-control-label" for="price-2">Khoảng 200k - 500k</label>
                            {{-- <span class="badge border font-weight-normal">150</span> --}}
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-3">
                            <label class="custom-control-label" for="price-3">Trên 500k</label>
                            {{-- <span class="badge border font-weight-normal">150</span> --}}
                        </div>
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </form>
                </div>
                <!-- Color End -->
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">

                    </div>
                    <div class="container">
                        @if (isset($message))
                            <div class="alert alert-info text-center">{{ $message }}</div>
                        @else
                            <div class="row">
                                @foreach ($products as $item)
                                    <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                                        <div class="card product-item border-0 mb-4">
                                            <div
                                                class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                                <img class="img-fluid w-100" src="{{ $item->imagepath }}" alt="">
                                            </div>
                                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                                <h6 class="text-truncate mb-3">{{ $item->name }}</h6>
                                                <div class="d-flex justify-content-center">
                                                    <h6>${{ $item->price }}</h6>
                                                    <h6 class="item-muted ml-2"><del>${{ $item->price }}</del></h6>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between bg-light border">
                                                <a href="{{ route('client.products.show', $item->slug) }}"
                                                    class="btn btn-sm text-dark p-0"><i
                                                        class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                                <a href="" class="btn btn-sm text-dark p-0"><i
                                                        class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>


                    <div class="col-12 pb-1">
                        {{-- {{ $products->links() }} --}}

                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection
