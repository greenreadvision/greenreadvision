@extends('layouts.app')

@section('content')
@auth
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card border-0 shadow rounded-pill">
                <!-- <div class="card-header text-center btn-green" style="border-top-left-radius:25px;border-top-right-radius:25px">{{ __('customize.Register') }}</div> -->
                <div class="card-body d-flex justify-content-center">
                    <div class="col-lg-10">
                        <img class="mb-3" width="90%" src="{{ URL::asset('img/綠雷德LOGO.png') }}" alt="">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row">
                                <!-- <label for="account" class="col-md-4 col-form-label text-md-right">{{ __('customize.account') }}</label> -->
                                <div class="col-md-12">
                                    <input placeholder="帳號" autocomplete="off" id="account" type="text" class="rounded-pill form-control{{ $errors->has('account') ? ' is-invalid' : '' }}" name="account" value="{{ old('account') }}" required autofocus>
                                    @if ($errors->has('account'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>此帳號已重複</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('customize.Password') }}</label> -->
                                <div class="col-md-12">
                                    <input placeholder="密碼" autocomplete="off" id="password" type="password" class="rounded-pill form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <small class="pl-2">請輸入8~16個字元</small>
                                    </span>
                                    @else
                                    <span style="font-size: 80%;">
                                        <small class="pl-2">請輸入8~16個字元</small>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <!-- <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('customize.Confirm Password') }}</label> -->

                                <div class="col-md-12">
                                    <input placeholder="確認密碼" autocomplete="off" id="password-confirm" type="password" class="rounded-pill form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-12 mt-2">
                                    <button type="submit" class="w-100 btn btn-green rounded-pill">
                                        {{ __('customize.Register') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endauth
@endsection