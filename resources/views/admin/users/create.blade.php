@extends('admin.layouts.app')
@section('title', ' Thêm Người Dùng')
@section('content')
    <div class="card">
        <h1>Thêm Người Dùng Mới</h1>
        <div>
            <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="input-group-static col-5 mb-4">
                        <label>Ảnh Người Dùng</label>
                        <input type="file" accept="image/*" name="image" id="image-input" class="form-control">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-5">
                        <img src="" id="show-image" alt="" style="max-width: 100%; max-height: 200px;">
                    </div>
                </div>


                <div class="input-group input-group-static mb-4">
                    <label>Tên Người Dùng</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">

                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Số Điện Thoại</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">

                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Mật Khẩu</label>
                    <input type="password" name="password" class="form-control">

                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Giới Tính</label>
                    <select class="form-control" name="gender">
                        <option value="male">Name</option>
                        <option value="female">Nữ</option>
                    </select>

                    @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Địa Chỉ</label>
                    <textarea name="address" class="form-control">{{ old('address') }}</textarea>

                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label>Phân Quyền</label>
                    <div class="row">
                        @foreach ($roles as $groupName => $role)
                            <div class="col-4">
                                <h4>{{ $groupName }}</h4>
                                <div>
                                    @foreach ($role as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" name="role_ids[]" type="checkbox"
                                                value="{{ $item->id }}">
                                            <label class="custom-control-label"
                                                for="customCheck1">{{ $item->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
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
    <script>
        $(() => {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#show-image').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image-input").change(function() {
                readURL(this);
            });



        });
    </script>
@endsection
