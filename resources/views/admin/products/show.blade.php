@extends('admin.layouts.app')
@section('title', ' Show Product')
@section('content')
    <div class="card">
        <h1>Show Product</h1>
        <div>

            <div class="row">
                <div class="">
                    <label>Image</label>
                    <div class="col-5">
                        <img src="{{ $product->images->count() > 0 ? asset('upload/' . $product->images->first()->url) : 'upload/default.jpg' }}"
                            id="show-image" alt="">
                    </div>
                </div>


                <div class="4">
                    <label>Name : {{ $product->name }}</label>

                </div>

                <div class="4">
                    <label>Price : {{ $product->price }}</label>

                </div>

                <div class="4">
                    <label>Sale : {{ $product->sale }}</label>

                </div>

                <div class="form-group ">
                    <label>Description</label>
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
                    <label for="exampleFormControlSelect1" class="ms-0">Category: </label>

                    @foreach ($product->categories as $item)
                        <p> {{ $item->name }}</p>
                    @endforeach
                </div>
            </div>





        </div>


        <button type="submit" class="btn btn-submit btn btn-primary"> Submit</button>

    </div>
    </div>
@endsection
