@extends('admin.layouts.app')
@section('title', ' Xem Sản Phẩm')
@section('content')
    <div class="card">
        <h1>Xem Sản Phẩm</h1>
        <div>

            <div class="row">
                <div class="">
                    <label>Ảnh Sản Phẩm</label>
                    <div class="col-5">
                        <img src="{{ $product->images->count() > 0 ? asset('upload/' . $product->images->first()->url) : 'upload/default.jpg' }}"
                            id="show-image" alt="">
                    </div>
                </div>


                <div class="4">
                    <label>Tên Sản Phẩm : {{ $product->name }}</label>

                </div>

                <div class="4">
                    <label>Giá Sản Phẩm : {{ $product->price }}</label>

                </div>

                <div class="4">
                    <label>Khuyến Mãi : {{ $product->sale }} %</label>

                </div>

                <div class="form-group ">
                    <label>Mô Tả: </label>
                    <div class="row w-100 h-100">
                        {!! $product->description !!}
                    </div>

                </div>

                <div>
                    <label>Size</label>
                    @if ($product->details->count() > 0)
                        @foreach ($product->details as $detail)
                            <p>Size: {{ $detail->size }} - Quantity: {{ $detail->quantity }}</p>
                        @endforeach
                    @else
                    <p>Sản phẩm này chưa nhập Size</p>
                    @endif

                    

                </div>


                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Danh Mục: </label>
                    @foreach ($product->categories as $item)
                        <p> {{ $item->name }}</p>
                    @endforeach
                </div>
            </div>





        </div>


        <a href="{{route('products.index')}}" type="submit" class="btn btn-submit btn btn-primary"> Đóng</a>

    </div>
    </div>
@endsection
