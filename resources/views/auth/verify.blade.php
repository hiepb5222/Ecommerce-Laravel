@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Xác thực tài khoản email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Một tin nhắn email mới đã được gửi.') }}
                        </div>
                    @endif

                    {{ __('Để sử dụng chức năng này, hãy xác thực bằng email của bạn') }}
                    {{ __('Nếu không nhận được email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('nhấn vào đây để gửi email khác') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
