@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body d-flex justify-content-center">
                    <div class="col-lg-10">
                        <img class="mb-3" width="100%" src="{{ URL::asset('img/綠雷德LOGO.png') }}" alt="">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input placeholder="帳號" autocomplete="off" id="nickname" type="text" class="form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }} rounded-pill" name="nickname" value="{{ old('nickname') }}" required autofocus>
                                    @if ($errors->has('nickname'))
                                    <span class="invalid-feedback" role="alert">
                                        <small>帳號錯誤或已被停權</small>
                                    </span>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group row mb-1">
                                <div class="col-md-12">
                                    <input placeholder="密碼" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} rounded-pill" name="password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            <small> {{ __('customize.Remember Me') }}</small>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="submit" class="w-100 btn btn-green rounded-pill">
                                        {{ __('customize.Login') }}
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        <small>{{ __('customize.Forgot Your Password?') }}</small>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection