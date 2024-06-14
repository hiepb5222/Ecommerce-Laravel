@extends('admin.layouts.app')
@section('title', ' Chỉnh Sửa Phiếu Giảm Giá ' . $coupon->name)
@section('content')
    <div class="card">
        <h1>Chỉnh Sửa Phiếu Giảm Giá</h1>
        <div>
            <form action="{{ route('coupons.update', $coupon->id )}}" method="post">
                @csrf
                @method('PUT')
                <div class="input-group input-group-static mb-4">
                    <label>Mã Giảm Giá</label>
                    <input type="text" name="name" value="{{ old('name') ?? $coupon->name }}" class="form-control" style="text-transform: uppercase">

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Giá Trị</label>
                    <input type="number" name="value" value="{{ old('value') ?? $coupon->value }}" class="form-control">

                    @error('value')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Loại Giảm Giá</label>
                    <select class="form-control" name="type">
                        <option>Chọn Loại</option>
                        <option value="money" {{ (old('type') ?? $coupon->type) =='money' ? 'selected' :''}}>Tiền Mặt</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Hạn Sử Dụng</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date') ?? $coupon->expiry_date }}" class="form-control">

                    @error('expiry_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>



                <button type="submit" class="btn btn-submit btn btn-primary"> Xác Nhận</button>
            </form>
        </div>
    </div>
@endsection
