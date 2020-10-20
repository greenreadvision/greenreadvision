@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                    <h1>{{__('customize.Post')}}</h1>
                    @if (\Auth::user()->role=='manager')
                        <button class="btn btn-primary" onclick="location.href='{{route('home.create')}}'">{{__('customize.Add')}}</button>
                    @endif
                </div>
                <div class="card-body text-center table-style">
                    <!-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>@lang('customize.Title')</th>
                                <th>@lang('customize.content')</th>
                                <th>@lang('customize.Post')@lang('customize.date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($homes as $home)
                                <tr>
                                    <td >{{$home->title}}</td>
                                    <td><a href="{{route('home.review', $home->home_id)}}">{{$home->content}}</a></td>
                                    <td>{{$home->created_at->format('Y-m-d')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- <span>準備中 敬啟期待!</span><br>
                    @if (\Auth::user()->role=='manager')
                        <button class="btn btn-primary">@lang('customize.Edit') (建置中)</button>
                    @endif
                    <hr>
                    <span>你已登入～</span> -->
                </div>
            </div>
        </div>
    </div>
@endsection
