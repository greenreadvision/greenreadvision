@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header">{{ __('customize.Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('customize.A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('customize.Before proceeding, please check your email for a verification link.') }}
                    {{ __('customize.If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('customize.click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
