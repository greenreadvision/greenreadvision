@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header text-center">
                    <h1>@lang('customize.Post')</h1>
                </div>
                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <span>準備中 敬啟期待!</span><br>
                    @if (\Auth::user()->role=='manager')
                        <button class="btn btn-primary">@lang('customize.Edit') (建置中)</button>
                    @endif
                    <hr>
                    <span>你已登入～</span>
                </div>
            </div>
        </div>
    </div>
@endsection
