@extends('admin.layouts.app')
@section('title', ' Thêm Sản Phẩm')
@section('content')
    <div class="card">
        <h1>Thêm Sản Phẩm</h1>
        <div>
            <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="input-group-static col-5 mb-4">
                        <label>Ảnh Sản Phẩm</label>
                        <input type="file" accept="image/*" name="image" id="image-input" class="form-control" multiple>
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-5">
                        <img src="" id="show-image" alt="" style="max-width: 100%; max-height: 200px;">
                    </div>
                </div>


                <div class="input-group input-group-static mb-4">
                    <label>Tên Sản Phẩm</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Giá Sản Phẩm</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="form-control">

                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Khuyến Mãi</label>
                    <input type="number" name="sale" value="{{ old('sale') }}" class="form-control">

                    @error('sale')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group ">
                    <label>Mô Tả</label>
                    <textarea name="description" id="description" >{{ old('description') }} </textarea>
                    @error('description')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Danh Mục</label>
                    <select class="form-control" name="category_ids[]" multiple>
                        @foreach ($categories as $item)
                            @if ($item->parentname)
                            @continue
                            @endif
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @if ($item->childrens->isNotEmpty())
                                @foreach ($item->childrens as $child)
                                    <option value="{{ $child->id }}">-- {{ $child->name }}</option>
                                @endforeach
                            @endif
                        @endforeach

                    </select>

                    @error('category_ids')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <input type="hidden" id="inputSize" name='sizes'>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddSizeModal">
                    Thêm Size
                </button>

                <!-- Modal -->

                <div class="modal fade" id="AddSizeModal" tabindex="-1" aria-labelledby="AddSizeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AddSizeModalLabel">Thêm Size</h5>
                                <button type="button" class="btn-close btn btn-danger" data-bs-dismiss="modal"
                                    aria-label="Close"
                                    style=" background-color: red;
                                color: white;
                                display: flex;
                                align-items: center;
                                justify-content: center;">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>
                            <div class="modal-body" id="AddSizeModalBody">

                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn  btn-primary btn-add-size ms-3">Thêm</button>
                            </div>
                        </div>
                    </div>
                </div>




        </div>


        <button type="submit" class="btn btn-submit btn btn-primary"> Thêm Mới</button>
        </form>
    </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script src="{{ asset('plugin/ckeditor5-build-classic/ckeditor.js') }}"></script>
    <script>
        let sizes = [{
            id: Date.now(),
            size: 'M',
            quantity: 1
        }];
    </script>
    <script src="{{ asset('admin/assets/base/product.js') }}"></script>
@endsection
