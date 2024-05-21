@extends('admin.layouts.app')
@section('title', ' Create Coupon')
@section('content')
    <div class="card">
        <h1>Create Coupon</h1>
        <div>
            <form action="{{ route('coupons.store') }}" method="post">
                @csrf
                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" style="text-transform: uppercase">

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Value</label>
                    <input type="number" name="value" value="{{ old('value') }}" class="form-control">

                    @error('value')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Type</label>
                    <select class="form-control" name="type">
                        <option>Select Type</option>
                        <option value="money">Money</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Expiry Date</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" class="form-control">

                    @error('expiry_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>



                <button type="submit" class="btn btn-submit btn btn-primary"> Submit</button>
            </form>
        </div>
    </div>
@endsection
