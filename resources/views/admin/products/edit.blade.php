@extends('admin.layouts.app')
@section('title', ' Edit Product')
@section('content')
    <div class="card">
        <h1>Edit Product</h1>
        <div>
            <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="input-group-static col-5 mb-4">
                        <label>Image</label>
                        <input type="file" accept="image/*" name="image" id="image-input" class="form-control" multiple>
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-5">
                        <img src="{{ $product->images->count() > 0 ? asset('upload/' . $product->images->first()->url) : 'upload/default.jpg' }}"
                            id="show-image" alt="" style="max-width: 100%; max-height: 200px;">
                    </div>
                </div>


                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') ?? $product->name }}" class="form-control">

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Price</label>
                    <input type="number" name="price" value="{{ old('price') ?? $product->price }}" class="form-control">

                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Sale</label>
                    <input type="number" name="sale" value="{{ old('sale') ?? $product->sale }}" class="form-control">

                    @error('sale')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group ">
                    <label>Description</label>
                    <div class="row w-100 h-100">
                        <textarea name="description" id="description" class="form-control" cols="4" rows="5" style="width: 100%">{{ old('description') ?? $product->description }} </textarea>
                    </div>
                    @error('description')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Category</label>
                    <select class="form-control" name="category_ids[]" multiple>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}"
                                {{ $product->categories->contains('id', $item->id) ? 'selected' : '' }}>{{ $item->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('category_ids')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <input type="hidden" id="inputSize" name='sizes'>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddSizeModal">
                    Add size
                </button>

                <!-- Modal -->
                <!-- Modal -->
                <div class="modal fade" id="AddSizeModal" tabindex="-1" aria-labelledby="AddSizeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AddSizeModalLabel">Add size</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="AddSizeModalBody">

                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn  btn-primary btn-add-size">Add</button>
                            </div>
                        </div>
                    </div>
                </div>


        </div>


        <button type="submit" class="btn btn-submit btn btn-primary"> Submit</button>
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
        let sizes = @json($product->details);
    </script>

    <script src="{{ asset('admin/assets/base/product.js') }}"></script>




@endsection
